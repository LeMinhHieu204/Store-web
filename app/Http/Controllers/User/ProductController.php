<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->string('keyword')->toString();
        $isSearching = trim($keyword) !== '';

        return view('user.product.index', [
            'products' => $isSearching
                ? $this->searchProducts($keyword, 24)
                : Product::with(['category', 'images'])->latest()->paginate(12),
            'keyword' => $keyword,
            'isSearching' => $isSearching,
        ]);
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return view('user.category.index', [
            'category' => $category,
            'products' => $category->products()->with('images')->latest()->paginate(12),
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'images'])->where('slug', $slug)->firstOrFail();

        return view('user.product.show', [
            'product' => $product,
            'relatedProducts' => Product::with('images')->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->take(4)
                ->get(),
        ]);
    }

    public function search(Request $request)
    {
        return redirect()->route('user.products', [
            'keyword' => $request->string('keyword')->toString(),
        ]);
    }

    public function liveSearch(Request $request)
    {
        $keyword = $request->string('keyword')->toString();
        $products = trim($keyword) === ''
            ? Product::with(['category', 'images'])->latest()->limit(12)->get()
            : $this->searchProducts($keyword, 24);

        return response()->json([
            'html' => view('user.product._cards', ['products' => $products])->render(),
            'count' => $products->count(),
            'keyword' => $keyword,
        ]);
    }

    protected function searchProducts(string $keyword, int $limit)
    {
        return Product::with(['category', 'images'])
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($keyword) {
                        $categoryQuery->where('name', 'like', "%{$keyword}%");
                    });
            })
            ->latest()
            ->limit($limit)
            ->get();
    }
}
