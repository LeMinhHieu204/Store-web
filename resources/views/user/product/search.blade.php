@extends('layouts.user')

@section('content')
    <style>
        .search-products-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .search-products-grid .product-card {
            padding: 12px;
            gap: 10px;
        }

        .search-products-grid .thumb {
            height: 185px;
            border-radius: 12px;
        }

        .search-products-grid .product-card h3 {
            font-size: 16px;
            line-height: 1.35;
        }

        .search-products-grid .product-card .price {
            font-size: 18px;
        }

        .search-products-grid .product-card .btn {
            min-height: 42px;
            padding: 0 14px;
        }

        @media (max-width: 1400px) {
            .search-products-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .search-products-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 820px) {
            .search-products-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 560px) {
            .search-products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <section class="page-section card" style="padding:20px;">
        <h1 class="section-title">Kết quả tìm kiếm: {{ $keyword ?: 'Tất cả sản phẩm' }}</h1>
        <form class="stack-form" method="GET" action="{{ route('user.search') }}" style="max-width:520px;">
            <input type="text" name="keyword" value="{{ $keyword }}" placeholder="Nhập từ khóa...">
            <button class="btn">Tìm kiếm</button>
        </form>

        <div class="product-grid search-products-grid" style="margin-top:20px;">
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
                <p class="meta">Không tìm thấy sản phẩm phù hợp với từ khóa bạn đã nhập.</p>
            @endforelse
        </div>
    </section>
@endsection
