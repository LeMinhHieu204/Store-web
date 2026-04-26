<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DepositTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class DepositController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'integer', 'min:10000', 'max:50000000'],
        ]);

        DepositTransaction::create([
            'user_id' => $request->user()->id,
            'code' => 'NAP'.now()->format('YmdHis').Str::upper(Str::random(6)),
            'amount' => $data['amount'],
            'status' => 'pending',
            'bank_name' => env('TOPUP_BANK_NAME', 'MBBank'),
            'bank_account_name' => env('TOPUP_BANK_ACCOUNT_NAME', 'WEB BAN SOURCE'),
            'bank_account_number' => env('TOPUP_BANK_ACCOUNT_NUMBER', '0123456789'),
        ]);

        return back()->with('success', 'Da tao yeu cau nap tien. Chuyen khoan dung noi dung de he thong cong tien tu dong.');
    }

    public function callback(Request $request)
    {
        $payload = $request->all();
        $secret = (string) $request->header('X-Secret-Key', $request->input('secret', ''));
        $authorization = trim((string) $request->header('Authorization', ''));
        $expectedSecret = (string) env('TOPUP_CALLBACK_SECRET', 'changeme');
        $expectedApiKey = (string) env('TOPUP_CALLBACK_API_KEY', '');
        $validSecret = $secret !== '' && hash_equals($expectedSecret, $secret);
        $validApiKey = $expectedApiKey !== '' && $authorization !== '' && (
            hash_equals('Apikey '.$expectedApiKey, $authorization)
            || hash_equals('ApiKey '.$expectedApiKey, $authorization)
            || hash_equals('Bearer '.$expectedApiKey, $authorization)
        );

        abort_unless($validSecret || $validApiKey, Response::HTTP_FORBIDDEN);

        $code = $payload['code'] ?? null;
        $amount = $payload['transferAmount'] ?? $payload['amount'] ?? null;
        $reference = $payload['referenceCode'] ?? $payload['reference'] ?? null;
        $status = $payload['status'] ?? null;
        $transferType = $payload['transferType'] ?? null;

        abort_if(! is_string($code) || $code === '', Response::HTTP_UNPROCESSABLE_ENTITY, 'Khong tim thay ma nap tien.');
        abort_if(! is_numeric($amount) || (float) $amount < 10000, Response::HTTP_UNPROCESSABLE_ENTITY, 'So tien khong hop le.');
        abort_if(! is_string($reference) || $reference === '', Response::HTTP_UNPROCESSABLE_ENTITY, 'Thieu ma tham chieu giao dich.');
        abort_if($transferType !== null && $transferType !== 'in', Response::HTTP_UNPROCESSABLE_ENTITY, 'Khong phai giao dich nap tien.');

        $deposit = DepositTransaction::where('code', $code)->firstOrFail();

        if ($deposit->status === 'paid') {
            return response()->json(['success' => true, 'message' => 'already_processed']);
        }

        abort_if((float) $deposit->amount !== (float) $amount, Response::HTTP_UNPROCESSABLE_ENTITY, 'So tien khong khop.');
        abort_if($status !== null && $status !== 'paid', Response::HTTP_UNPROCESSABLE_ENTITY, 'Trang thai thanh toan khong hop le.');

        DB::transaction(function () use ($deposit, $payload, $reference) {
            $deposit->refresh();

            if ($deposit->status === 'paid') {
                return;
            }

            $deposit->update([
                'status' => 'paid',
                'payment_reference' => $reference,
                'paid_at' => now(),
                'meta' => [
                    'callback_payload' => $payload,
                ],
            ]);

            $deposit->user()->lockForUpdate()->first()->increment('balance', $deposit->amount);
        });

        return response()->json(['success' => true]);
    }
}
