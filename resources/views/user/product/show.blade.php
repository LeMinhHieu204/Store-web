@extends('layouts.user')

@section('content')
    @php
        $galleryImages = collect([$product->thumbnail])
            ->merge($product->images->pluck('image_path'))
            ->values();
    @endphp

    <section class="page-section card" style="padding:22px;">
        <div style="display:grid; grid-template-columns:minmax(280px, 440px) 1fr; gap:24px;">
            <div>
                <button type="button" onclick="openGallery(0)" style="padding:0; border:none; background:none; width:100%; cursor:zoom-in;">
                    <img id="product-main-image" class="thumb" src="{{ \Illuminate\Support\Str::startsWith($product->thumbnail, ['http://', 'https://']) ? $product->thumbnail : '/'.$product->thumbnail }}" alt="{{ $product->title }}" style="height:320px;">
                </button>
                <div style="display:flex; gap:10px; overflow:auto; margin-top:12px;">
                    @foreach($galleryImages as $index => $imagePath)
                        <button type="button" onclick="swapProductImage('{{ \Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://']) ? $imagePath : '/'.$imagePath }}'); openGallery({{ $index }});" style="padding:0; border:none; background:none; cursor:pointer;">
                            <img src="{{ \Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://']) ? $imagePath : '/'.$imagePath }}" alt="{{ $product->title }}" style="width:90px; height:72px; object-fit:cover; border-radius:12px;">
                        </button>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="meta">{{ $product->category->name }}</div>
                <h1 style="margin:10px 0 14px; font-size:34px; line-height:1.25;">{{ $product->title }}</h1>
                <div class="meta" style="font-size:15px; line-height:1.8;">@productDescription($product->description)</div>
                <div style="margin:18px 0;">
                    @if($product->has_discount)
                        <div class="meta" style="font-size:24px; text-decoration:line-through;">{{ number_format($product->display_original_price) }} đ</div>
                    @endif
                    <div class="price">{{ number_format($product->display_sale_price) }} đ</div>
                </div>
                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                    <form method="POST" action="{{ route('user.cart.add', $product) }}">
                        @csrf
                        <button class="btn">Thêm vào giỏ hàng</button>
                    </form>
                    <form method="POST" action="{{ route('user.cart.buy_now', $product) }}">
                        @csrf
                        <button class="btn secondary">Mua ngay</button>
                    </form>
                    @guest
                        <a class="btn secondary" href="{{ route('user.login') }}">Đăng nhập để mua</a>
                    @endguest
                </div>
                <div class="meta" style="margin-top:18px;">Sản phẩm được cung cấp dưới dạng file số và có thể tải về sau khi thanh toán thành công.</div>
            </div>
        </div>
    </section>

    <section class="page-section card" style="padding:20px;">
        <div class="section-head">
            <h2 class="section-title">Sản phẩm liên quan</h2>
        </div>
        <div class="product-grid">
            @foreach($relatedProducts as $item)
                <article class="card product-card" style="box-shadow:none;">
                    <img src="{{ \Illuminate\Support\Str::startsWith($item->thumbnail, ['http://', 'https://']) ? $item->thumbnail : '/'.$item->thumbnail }}" alt="{{ $item->title }}">
                    <h3><a href="{{ route('user.product.show', $item->slug) }}">{{ $item->title }}</a></h3>
                    <div class="price">{{ number_format($item->display_sale_price) }} đ</div>
                    <a class="btn" href="{{ route('user.product.show', $item->slug) }}">Xem chi tiết</a>
                </article>
            @endforeach
        </div>
    </section>

    <div id="product-gallery-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.68); z-index:2000; padding:20px; overflow:auto;">
        <div style="position:relative; width:min(640px, 100%); margin:18px auto; background:#0f172a; border-radius:18px; padding:16px; border:1px solid rgba(255,255,255,.08); box-shadow:0 24px 60px rgba(0,0,0,.35);">
            <button type="button" onclick="closeGallery()" style="position:absolute; top:10px; right:10px; z-index:2; border:none; background:rgba(255,255,255,.14); color:#fff; width:36px; height:36px; border-radius:50%; cursor:pointer; font-size:22px;">×</button>
            <div style="height:min(54vh, 420px); display:flex; align-items:center; justify-content:center; padding:12px; margin-bottom:12px; border-radius:14px; background:rgba(255,255,255,.03); overflow:hidden;">
                <img id="gallery-preview" src="" alt="{{ $product->title }}" style="max-width:100%; max-height:100%; object-fit:contain; border-radius:12px;">
            </div>
            <div style="display:flex; gap:8px; overflow-x:auto; overflow-y:hidden; justify-content:flex-start; padding:4px 2px 2px;">
                @foreach($galleryImages as $index => $imagePath)
                    <button type="button" onclick="setGalleryImage({{ $index }})" data-gallery-thumb="{{ $index }}" style="flex:0 0 auto; padding:2px; border:1px solid transparent; border-radius:12px; background:none; cursor:pointer;">
                        <img src="{{ \Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://']) ? $imagePath : '/'.$imagePath }}" alt="{{ $product->title }}" style="width:72px; height:56px; object-fit:cover; border-radius:10px;">
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        const galleryImages = @json($galleryImages->map(fn ($path) => \Illuminate\Support\Str::startsWith($path, ['http://', 'https://']) ? $path : '/'.$path)->all());
        let currentGalleryIndex = 0;

        function swapProductImage(src) {
            const image = document.getElementById('product-main-image');
            if (image) image.src = src;
        }

        function setGalleryImage(index) {
            currentGalleryIndex = index;
            const preview = document.getElementById('gallery-preview');
            if (preview) preview.src = galleryImages[index];
            swapProductImage(galleryImages[index]);
            document.querySelectorAll('[data-gallery-thumb]').forEach(function (thumb) {
                const active = Number(thumb.dataset.galleryThumb) === index;
                thumb.style.borderColor = active ? '#38bdf8' : 'transparent';
                thumb.style.background = active ? 'rgba(56, 189, 248, 0.12)' : 'transparent';
            });
        }

        function openGallery(index) {
            currentGalleryIndex = index;
            setGalleryImage(index);
            const modal = document.getElementById('product-gallery-modal');
            if (modal) modal.style.display = 'block';
        }

        function closeGallery() {
            const modal = document.getElementById('product-gallery-modal');
            if (modal) modal.style.display = 'none';
        }

        document.addEventListener('keydown', function (event) {
            const modal = document.getElementById('product-gallery-modal');
            if (!modal || modal.style.display !== 'block') return;

            if (event.key === 'Escape') closeGallery();
            if (event.key === 'ArrowRight') setGalleryImage((currentGalleryIndex + 1) % galleryImages.length);
            if (event.key === 'ArrowLeft') setGalleryImage((currentGalleryIndex - 1 + galleryImages.length) % galleryImages.length);
        });

        document.getElementById('product-gallery-modal')?.addEventListener('click', function (event) {
            if (event.target === this) closeGallery();
        });
    </script>
@endsection
