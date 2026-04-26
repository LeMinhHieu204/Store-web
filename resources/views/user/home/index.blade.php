@extends('layouts.user')

@section('content')
    <style>
        .home-shell { margin-top: 6px; }
        .home-hero {
            display: grid;
            grid-template-columns: 250px minmax(0, 1fr);
            gap: 0;
        }
        .category-panel {
            background: #fff;
            border: 1px solid var(--line);
            border-right: none;
            border-radius: 18px 0 0 18px;
            overflow: hidden;
            box-shadow: var(--shadow-soft);
        }
        .category-head {
            padding: 12px 18px;
            background: var(--blue-soft);
            border-bottom: 1px solid var(--line);
            font-size: 14px;
            color: var(--muted);
        }
        .category-list a {
            display: grid;
            grid-template-columns: 40px 1fr 14px;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-bottom: 1px solid #edf2f7;
            font-size: 13px;
        }
        .category-list a:hover {
            background: #f8fbff;
            color: var(--blue-deep);
            transform: translateX(3px);
        }
        .category-thumb {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            object-fit: cover;
            background: #eef6ff;
        }
        .hero-banner {
            min-height: 240px;
            padding: 22px 26px;
            border-radius: 0 18px 18px 0;
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at 15% 20%, rgba(255,255,255,0.22), transparent 24%),
                radial-gradient(circle at 85% 18%, rgba(255,107,107,0.18), transparent 22%),
                linear-gradient(135deg, #1d4ed8 0%, #2563eb 30%, #4f46e5 62%, #7c3aed 100%);
            background-size: 180% 180%;
            color: #fff;
            box-shadow: 0 28px 52px rgba(79, 70, 229, 0.26);
            animation: gradientShift 14s ease infinite;
        }
        .hero-banner::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(45deg, transparent 0 8%, rgba(255,255,255,0.09) 8% 10%, transparent 10% 18%, rgba(255,255,255,0.08) 18% 20%, transparent 20%),
                linear-gradient(-45deg, transparent 0 12%, rgba(255,255,255,0.08) 12% 14%, transparent 14%),
                radial-gradient(circle at 14% 22%, rgba(255,255,255,0.14) 0 4px, transparent 5px 100%),
                radial-gradient(circle at 78% 64%, rgba(255,255,255,0.12) 0 3px, transparent 4px 100%);
            background-size: 100% 100%, 100% 100%, 240px 240px, 300px 300px;
            opacity: 0.8;
            pointer-events: none;
            animation: squiggleDrift 16s ease-in-out infinite reverse;
        }
        .hero-banner::after {
            content: "";
            position: absolute;
            inset: -10%;
            background:
                linear-gradient(135deg, transparent 0 24%, rgba(255,255,255,0.07) 24% 25%, transparent 25% 48%, rgba(255,255,255,0.06) 48% 49%, transparent 49%),
                linear-gradient(75deg, transparent 0 30%, rgba(255,255,255,0.06) 30% 31%, transparent 31% 54%, rgba(255,255,255,0.05) 54% 55%, transparent 55%);
            opacity: .65;
            pointer-events: none;
            animation: squiggleDrift 18s ease-in-out infinite;
        }
        .hero-banner > * { position: relative; z-index: 1; }
        .hero-topline {
            display: inline-block;
            padding: 10px 22px;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(255,255,255,0.24), rgba(96,165,250,0.18));
            color: #fff;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .06em;
            border: 1px solid rgba(255,255,255,0.22);
            box-shadow: 0 10px 22px rgba(255,255,255,0.08);
        }
        .hero-banner h1 {
            margin: 18px 0 10px;
            max-width: 560px;
            font-size: clamp(34px, 5vw, 56px);
            line-height: 1.06;
            text-transform: uppercase;
        }
        .hero-banner p {
            margin: 0;
            max-width: 560px;
            font-size: 17px;
            line-height: 1.7;
            font-weight: 600;
        }
        .hero-contact {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
            margin-top: 18px;
            font-size: 15px;
            font-weight: 700;
        }
        .hero-contact span {
            padding: 8px 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(96,165,250,0.12));
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.12);
        }
        .step-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 10px;
        }
        .step-box {
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--line);
            box-shadow: var(--shadow-soft);
        }
        .step-header {
            padding: 9px 14px;
            font-size: 14px;
            font-weight: 900;
            color: #fff;
        }
        .step-header.blue { background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); }
        .step-header.green { background: linear-gradient(135deg, #16a34a 0%, #22c55e 45%, #0f766e 100%); }
        .step-content {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
            padding: 12px;
        }
        .step-item {
            min-height: 78px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            text-align: center;
            padding: 10px;
            background: linear-gradient(135deg, #fff7e8, #ffe5b4 55%, #ffd86b 100%);
            border: 2px solid rgba(255, 191, 71, 0.5);
            color: var(--ink);
            font-size: 13px;
            font-weight: 900;
            line-height: 1.35;
            transition: transform .22s ease, border-color .22s ease, box-shadow .22s ease;
        }
        .step-item:hover {
            transform: translateY(-2px);
            border-color: #93c5fd;
            box-shadow: 0 14px 28px rgba(255, 159, 10, 0.22);
        }
        .home-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 270px;
            gap: 14px;
            margin-top: 18px;
        }
        .section-block { margin-bottom: 16px; }
        .section-title {
            margin: 0 0 10px;
            font-size: 30px;
            background: linear-gradient(135deg, #1d4ed8, #7c3aed 52%, #ff2d55 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-transform: uppercase;
            letter-spacing: 0.01em;
        }
        .product-row {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
        }
        .product-card-mini {
            position: relative;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            border: 1px solid rgba(124,58,237,0.12);
            padding: 10px;
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
        }
        .product-card-mini:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 38px rgba(79, 70, 229, 0.18);
            border-color: rgba(124,58,237,0.28);
        }
        .product-card-mini img.main {
            width: 100%;
            height: 118px;
            object-fit: cover;
            background: #f0f5fb;
            border-radius: 12px;
        }
        .sale-badge {
            position: absolute;
            top: 6px;
            left: 6px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff7a3d 0%, #ff4d6d 45%, #ff2d55 100%);
            color: #fff;
            font-size: 9px;
            font-weight: 900;
            display: grid;
            place-items: center;
        }
        .product-card-mini h3 {
            margin: 8px 0 6px;
            font-size: 12px;
            line-height: 1.45;
            height: 52px;
            overflow: hidden;
        }
        .price-row {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
            font-size: 11px;
        }
        .old-price {
            color: #8a96a4;
            text-decoration: line-through;
        }
        .new-price {
            color: var(--red-deep);
            font-size: 15px;
            font-weight: 900;
        }
        .side-card {
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            border: 1px solid rgba(124,58,237,0.12);
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            margin-bottom: 14px;
        }
        .side-head {
            padding: 10px 12px;
            font-size: 14px;
            font-weight: 900;
            background: linear-gradient(135deg, #2563eb, #4f46e5 55%, #7c3aed);
            color: #fff;
            text-transform: uppercase;
            border-bottom: 1px solid #ebf2f8;
            border-radius: 16px 16px 0 0;
        }
        .featured-list, .news-list {
            display: grid;
            gap: 10px;
            padding: 10px;
        }
        .featured-item {
            display: grid;
            grid-template-columns: 72px 1fr;
            gap: 10px;
            align-items: start;
            padding-bottom: 10px;
            border-bottom: 1px solid #edf3f8;
            transition: transform .22s ease;
        }
        .featured-item:hover { transform: translateX(3px); }
        .featured-item:last-child { border-bottom: none; padding-bottom: 0; }
        .featured-item img {
            width: 72px;
            height: 58px;
            object-fit: cover;
            background: #eef5fb;
        }
        .featured-item h4 {
            margin: 0 0 4px;
            font-size: 12px;
            line-height: 1.45;
        }
        .news-list a {
            position: relative;
            display: block;
            padding-left: 12px;
            font-size: 12px;
            line-height: 1.6;
            color: #324b63;
        }
        .news-list a:hover { color: var(--blue-deep); }
        .news-list a::before {
            content: "";
            position: absolute;
            left: 0;
            top: 7px;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--red-deep);
        }
        @media (max-width: 1180px) {
            .product-row { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .home-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 860px) {
            .home-hero, .step-row { grid-template-columns: 1fr; }
            .category-panel {
                border-right: 1px solid var(--line);
                border-radius: 18px 18px 0 0;
            }
            .hero-banner { border-radius: 0 0 18px 18px; }
        }
        @media (max-width: 680px) {
            .product-row, .step-content { grid-template-columns: 1fr 1fr; }
        }
    </style>

    <div class="home-shell page-section">
        <section class="home-hero">
            <aside class="category-panel">
                <div class="category-head">Trang chủ | Code đồ án</div>
                <div class="category-list">
                    @foreach($categories->take(8) as $category)
                        <a href="{{ route('user.category', $category->slug) }}">
                            @if($category->image_path)
                                <img class="category-thumb" src="{{ \Illuminate\Support\Str::startsWith($category->image_path, ['http://', 'https://']) ? $category->image_path : '/'.$category->image_path }}" alt="{{ $category->name }}">
                            @else
                                <div class="category-thumb"></div>
                            @endif
                            <span>{{ $category->name }}</span>
                            <span>›</span>
                        </a>
                    @endforeach
                </div>
            </aside>

            <div class="hero-banner">
                <span class="hero-topline">Nền tảng chia sẻ source code</span>
                <h1>Hỗ trợ cài đặt qua TeamViewer - UltraViewer</h1>
                <p>Đội ngũ admin nhiều năm kinh nghiệm, hỗ trợ source code nhanh, dễ dàng triển khai và sửa theo yêu cầu cơ bản.</p>
                <div class="hero-contact">
                    <span>◷ Hỗ trợ từ 6h - 22h</span>
                </div>
            </div>
        </section>

        <section class="step-row">
            <div class="step-box">
                <div class="step-header blue">Các bước cơ bản để tải code tại website</div>
                <div class="step-content">
                    <div class="step-item">B1<br>Chọn code cần mua</div>
                    <div class="step-item">B2<br>Thanh toán và nhận code</div>
                    <div class="step-item">B3<br>Liên hệ shop để được hỗ trợ cài đặt</div>
                </div>
            </div>
            <div class="step-box">
                <div class="step-header green">Các bước cơ bản để tải code tại website</div>
                <div class="step-content">
                    <div class="step-item">B1<br>Chọn code cần mua</div>
                    <div class="step-item">B2<br>Thanh toán và nhận code</div>
                    <div class="step-item">B3<br>Liên hệ shop để được hỗ trợ cài đặt</div>
                </div>
            </div>
        </section>

        <div class="home-grid">
            <div>
                @foreach($categorySections as $section)
                    <section class="section-block">
                        <h2 class="section-title">{{ $section['category']->name }} nổi bật</h2>
                        <div class="product-row">
                            @foreach($section['products'] as $product)
                                <article class="product-card-mini">
                                    <div class="sale-badge">HOT</div>
                                    <a href="{{ route('user.product.show', $product->slug) }}">
                                        <img class="main" src="{{ \Illuminate\Support\Str::startsWith($product->thumbnail, ['http://', 'https://']) ? $product->thumbnail : '/'.$product->thumbnail }}" alt="{{ $product->title }}">
                                    </a>
                                    <h3><a href="{{ route('user.product.show', $product->slug) }}">{{ $product->title }}</a></h3>
                                    <div class="price-row">
                                        @if($product->has_discount)
                                            <span class="old-price">{{ number_format($product->display_original_price) }} đ</span>
                                        @endif
                                        <span class="new-price">{{ number_format($product->display_sale_price) }} đ</span>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>

            <aside>
                <section class="side-card">
                    <div class="side-head">❤ Sản phẩm nổi bật</div>
                    <div class="featured-list">
                        @foreach($featuredProducts as $product)
                            <a class="featured-item" href="{{ route('user.product.show', $product->slug) }}">
                                <img src="{{ \Illuminate\Support\Str::startsWith($product->thumbnail, ['http://', 'https://']) ? $product->thumbnail : '/'.$product->thumbnail }}" alt="{{ $product->title }}">
                                <div>
                                    <h4>{{ $product->title }}</h4>
                                    @if($product->has_discount)
                                        <div class="old-price">{{ number_format($product->display_original_price) }} đ</div>
                                    @endif
                                    <div class="new-price">{{ number_format($product->display_sale_price) }} đ</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>

                <section class="side-card">
                    <div class="side-head">📰 Tin Tức Mới Nhất</div>
                    <div class="news-list">
                        @foreach($posts as $post)
                            <a href="{{ route('user.contact') }}">{{ $post->title }}</a>
                        @endforeach
                    </div>
                </section>
            </aside>
        </div>
    </div>
@endsection
