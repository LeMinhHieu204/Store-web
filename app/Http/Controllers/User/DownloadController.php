<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DownloadController extends Controller
{
    public function __invoke(int $id)
    {
        $product = Product::findOrFail($id);

        $hasPurchased = auth()->user()->orders()
            ->where('status', 'completed')
            ->whereHas('items', fn ($query) => $query->where('product_id', $id))
            ->exists();

        abort_unless($hasPurchased, 403, 'Ban can mua san pham nay truoc khi tai.');
        abort_unless(is_file(public_path($product->file_path)), 404, 'File tai xuong hien chua ton tai tren may chu.');

        return response()->download(public_path($product->file_path));
    }
}
