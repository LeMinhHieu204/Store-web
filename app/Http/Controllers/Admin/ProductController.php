<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct(private readonly CloudinaryService $cloudinary)
    {
    }

    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::with(['category', 'images'])->latest()->paginate(12),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $product = Product::create($this->preparePayload($request, $data));
        $this->syncGalleryImages($request, $product);

        return back()->with('success', 'Da them san pham.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validatedData($request, $product->id);
        $product->update($this->preparePayload($request, $data, $product));
        $this->syncGalleryImages($request, $product);

        if ($request->filled('remove_image_ids')) {
            ProductImage::where('product_id', $product->id)
                ->whereIn('id', (array) $request->input('remove_image_ids'))
                ->delete();
        }

        return back()->with('success', 'Da cap nhat san pham.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Da xoa san pham.');
    }

    protected function validatedData(Request $request, ?int $productId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'original_price' => ['nullable', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'thumbnail' => [$productId ? 'nullable' : 'required', 'image'],
            'gallery_images.*' => ['nullable', 'image'],
            'source_zip' => [$productId ? 'nullable' : 'required', 'file', 'mimes:zip'],
            'remove_image_ids.*' => ['nullable', 'integer'],
            'is_featured' => ['nullable', 'boolean'],
        ]);
    }

    protected function preparePayload(Request $request, array $data, ?Product $product = null): array
    {
        $slug = $this->makeUniqueSlug($data['title'], $product?->id);
        $thumbnailPath = $product?->thumbnail;
        $filePath = $product?->file_path;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $this->cloudinary->uploadImage($request->file('thumbnail'), 'web ban/products');
        }

        if ($request->hasFile('source_zip')) {
            $filePath = 'storage/'.$request->file('source_zip')->store('uploads/products', 'public');
        }

        return [
            'title' => $data['title'],
            'slug' => $slug,
            'description' => $data['description'],
            'original_price' => $data['original_price'] ?? null,
            'price' => $data['price'],
            'thumbnail' => $thumbnailPath,
            'file_path' => $filePath,
            'category_id' => $data['category_id'],
            'is_featured' => (bool) ($data['is_featured'] ?? false),
        ];
    }

    private function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug !== '' ? Str::limit($baseSlug, 255, '') : 'san-pham';
        $originalSlug = $slug;
        $counter = 1;

        while (Product::query()
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $suffix = '-'.$counter;
            $slug = Str::limit($originalSlug, 255 - strlen($suffix), '').$suffix;
            $counter++;
        }

        return $slug;
    }

    protected function syncGalleryImages(Request $request, Product $product): void
    {
        if (! $request->hasFile('gallery_images')) {
            return;
        }

        foreach ($request->file('gallery_images') as $image) {
            if (! $image) {
                continue;
            }

            $product->images()->create([
                'image_path' => $this->cloudinary->uploadImage($image, 'web ban/products/gallery'),
            ]);
        }
    }
}
