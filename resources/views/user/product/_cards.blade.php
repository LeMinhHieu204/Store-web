@forelse($products as $product)
    <article class="card product-card" style="box-shadow:none;">
        <img class="thumb" src="{{ \Illuminate\Support\Str::startsWith($product->thumbnail, ['http://', 'https://']) ? $product->thumbnail : '/'.$product->thumbnail }}" alt="{{ $product->title }}">
        @if($product->images->isNotEmpty())
            <div style="display:flex; gap:6px; overflow:auto;">
                @foreach($product->images as $image)
                    <img src="{{ \Illuminate\Support\Str::startsWith($image->image_path, ['http://', 'https://']) ? $image->image_path : '/'.$image->image_path }}" alt="{{ $product->title }}" style="width:48px; height:38px; object-fit:cover; border-radius:8px;">
                @endforeach
            </div>
        @endif
        <h3><a href="{{ route('user.product.show', $product->slug) }}">{{ $product->title }}</a></h3>
        <p class="meta">{{ $product->category->name }}</p>
        <div style="display:flex; align-items:baseline; gap:10px; flex-wrap:wrap;">
            @if($product->has_discount)
                <div class="meta" style="text-decoration:line-through;">{{ number_format($product->display_original_price) }} đ</div>
            @endif
            <p class="price">{{ number_format($product->display_sale_price) }} đ</p>
        </div>
        <a class="btn" href="{{ route('user.product.show', $product->slug) }}">Xem chi tiết</a>
    </article>
@empty
    <p class="meta">Không tìm thấy sản phẩm phù hợp.</p>
@endforelse
