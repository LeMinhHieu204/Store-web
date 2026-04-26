<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->cartItems();
        $cartTotal = $cartItems->sum(fn ($item) => $item['quantity'] * $item['product']->display_sale_price);

        return view('user.cart.index', [
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'walletBalance' => auth()->check() ? (float) auth()->user()->balance : 0,
        ]);
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $quantity = max(1, (int) $request->input('quantity', 1));
        $cart = $this->getCart($request);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + $quantity;

        $this->putCart($request, $cart);

        return back()->with('success', 'Da them san pham vao gio hang.');
    }

    public function buyNow(Request $request, Product $product): RedirectResponse
    {
        $this->putCart($request, [$product->id => 1]);

        return redirect()->route('user.cart')->with('success', 'San pham da san sang de thanh toan.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $cart = $this->getCart($request);

        if (isset($cart[$product->id])) {
            $cart[$product->id] = (int) $data['quantity'];
            $this->putCart($request, $cart);
        }

        return back()->with('success', 'Da cap nhat gio hang.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $cart = $this->getCart($request);
        unset($cart[$product->id]);
        $this->putCart($request, $cart);

        return back()->with('success', 'Da xoa san pham khoi gio hang.');
    }

    public function checkout(Request $request): RedirectResponse
    {
        $user = $request->user();
        $cartItems = $this->cartItems();
        $cartTotal = $cartItems->sum(fn ($item) => $item['quantity'] * $item['product']->display_sale_price);

        if ($cartItems->isEmpty()) {
            return back()->withErrors(['cart' => 'Gio hang dang trong.']);
        }

        if ((float) $user->balance < (float) $cartTotal) {
            return back()->withErrors(['balance' => 'So du khong du de thanh toan.']);
        }

        try {
            DB::transaction(function () use ($user, $cartItems, $cartTotal) {
                $lockedUser = $user->newQuery()->lockForUpdate()->findOrFail($user->id);

                if ((float) $lockedUser->balance < (float) $cartTotal) {
                    throw new \RuntimeException('So du khong du de thanh toan.');
                }

                $order = Order::create([
                    'user_id' => $lockedUser->id,
                    'total_price' => $cartTotal,
                    'status' => 'completed',
                ]);

                foreach ($cartItems as $item) {
                    for ($i = 0; $i < $item['quantity']; $i++) {
                        $order->items()->create([
                            'product_id' => $item['product']->id,
                            'price' => $item['product']->display_sale_price,
                        ]);
                    }
                }
                $lockedUser->decrement('balance', $cartTotal);
            });
        } catch (\RuntimeException $exception) {
            return back()->withErrors(['balance' => $exception->getMessage()]);
        }

        $this->putCart($request, []);

        return redirect()->route('user.profile')->with('success', 'Thanh toan thanh cong. Ban co the tai source trong tai khoan.');
    }

    protected function getCart(Request $request): array
    {
        return array_filter($request->session()->get('cart', []), fn ($quantity) => (int) $quantity > 0);
    }

    protected function putCart(Request $request, array $cart): void
    {
        $request->session()->put('cart', $cart);
    }

    protected function cartItems()
    {
        $cart = array_filter(session('cart', []), fn ($quantity) => (int) $quantity > 0);

        if ($cart === []) {
            return collect();
        }

        $products = Product::with('category')->whereIn('id', array_keys($cart))->get()->keyBy('id');

        return collect($cart)
            ->map(fn ($quantity, $productId) => [
                'product' => $products->get($productId),
                'quantity' => (int) $quantity,
            ])
            ->filter(fn ($item) => $item['product'] !== null)
            ->values();
    }
}
