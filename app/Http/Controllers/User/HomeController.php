<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        $categorySections = $categories
            ->map(function (Category $category) {
                $products = Product::with(['category', 'images'])
                    ->where('category_id', $category->id)
                    ->latest()
                    ->take(5)
                    ->get();

                if ($products->isEmpty()) {
                    return null;
                }

                return [
                    'category' => $category,
                    'products' => $products,
                ];
            })
            ->filter()
            ->values();

        return view('user.home.index', [
            'categories' => $categories,
            'categorySections' => $categorySections,
            'featuredProducts' => Product::with(['category', 'images'])->where('is_featured', true)->latest()->take(6)->get(),
            'posts' => Post::latest()->take(6)->get(),
        ]);
    }
}
