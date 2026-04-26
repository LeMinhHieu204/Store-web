@extends('layouts.user')

@section('content')
    <style>
        .category-products-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .category-products-grid .product-card {
            padding: 12px;
            gap: 10px;
        }

        .category-products-grid .thumb {
            height: 185px;
            border-radius: 12px;
        }

        .category-products-grid .product-card h3 {
            font-size: 16px;
            line-height: 1.35;
        }

        .category-products-grid .product-card .price {
            font-size: 18px;
        }

        .category-products-grid .product-card .btn {
            min-height: 42px;
            padding: 0 14px;
        }

        .category-hero {
            display: grid;
            grid-template-columns: 180px minmax(0, 1fr);
            gap: 20px;
            align-items: center;
            margin-bottom: 18px;
            padding: 20px;
            border-radius: 22px;
            border: 1px solid rgba(124,58,237,0.12);
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.42), transparent 22%),
                linear-gradient(135deg, rgba(37,99,235,0.1), rgba(124,58,237,0.1) 55%, rgba(255,45,85,0.08) 100%);
            box-shadow: var(--shadow-soft);
        }

        .category-hero-image {
            width: 180px;
            height: 140px;
            object-fit: cover;
            border-radius: 18px;
            background: linear-gradient(135deg, #eef4ff, #dbeafe);
            box-shadow: 0 14px 28px rgba(79, 70, 229, 0.12);
        }

        .category-hero-copy p {
            margin: 0;
            max-width: 760px;
        }

        @media (max-width: 1400px) {
            .category-products-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .category-products-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 820px) {
            .category-hero {
                grid-template-columns: 1fr;
            }

            .category-products-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 560px) {
            .category-products-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <section class="page-section card" style="padding:20px;">
        <div class="category-hero">
            @if($category->image_path)
                <img class="category-hero-image" src="{{ \Illuminate\Support\Str::startsWith($category->image_path, ['http://', 'https://']) ? $category->image_path : '/'.$category->image_path }}" alt="{{ $category->name }}">
            @else
                <div class="category-hero-image"></div>
            @endif

            <div class="category-hero-copy">
                <h1 class="section-title" style="margin-bottom:8px;">Danh mục: {{ $category->name }}</h1>
                <p class="meta">Tổng hợp toàn bộ sản phẩm thuộc danh mục này, giữ cùng bố cục và hiệu ứng với trang sản phẩm chính.</p>
            </div>
        </div>

        <div class="product-grid category-products-grid">
            @include('user.product._cards', ['products' => $products])
        </div>

        @if(method_exists($products, 'links'))
            <div style="margin-top:20px;">
                {{ $products->links() }}
            </div>
        @endif
    </section>
@endsection
