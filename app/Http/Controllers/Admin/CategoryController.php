<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct(private readonly CloudinaryService $cloudinary)
    {
    }

    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::withCount('products')->latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image'],
        ]);

        Category::create([
            'name' => $data['name'],
            'slug' => $this->makeUniqueSlug($data['name']),
            'image_path' => $request->hasFile('image')
                ? $this->cloudinary->uploadImage($request->file('image'), 'web ban/categories')
                : null,
        ]);

        return back()->with('success', 'Da them danh muc.');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category->id)],
            'image' => ['nullable', 'image'],
        ]);

        $payload = [
            'name' => $data['name'],
            'slug' => $this->makeUniqueSlug($data['name'], $category->id),
        ];

        if ($request->hasFile('image')) {
            $payload['image_path'] = $this->cloudinary->uploadImage($request->file('image'), 'web ban/categories');
        }

        $category->update($payload);

        return back()->with('success', 'Da cap nhat danh muc.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Da xoa danh muc.');
    }

    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug !== '' ? $baseSlug : 'danh-muc';
        $originalSlug = $slug;
        $counter = 1;

        while (Category::query()
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
