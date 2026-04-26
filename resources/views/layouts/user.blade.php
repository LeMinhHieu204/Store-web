<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Web Bán Source Code' }}</title>
    <style>
        :root {
            --red: #ff6a3d;
            --red-deep: #ff2d55;
            --blue: #2563eb;
            --blue-deep: #4f46e5;
            --blue-soft: #eaf1ff;
            --yellow: #ffd86b;
            --ink: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --card: #ffffff;
            --bg: #f7f9fc;
            --shadow: 0 18px 40px rgba(37, 99, 235, 0.14);
            --shadow-soft: 0 12px 28px rgba(79, 70, 229, 0.12);
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes squiggleDrift {
            0% { transform: translate3d(0, 0, 0) scale(1); opacity: .9; }
            50% { transform: translate3d(18px, -14px, 0) scale(1.04); opacity: 1; }
            100% { transform: translate3d(0, 0, 0) scale(1); opacity: .9; }
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at top left, rgba(96, 165, 250, 0.18), transparent 22%),
                radial-gradient(circle at top right, rgba(244, 114, 182, 0.12), transparent 18%),
                linear-gradient(180deg, #fdfdff 0%, #f7f9fc 45%, #eef4ff 100%);
        }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; display: block; }
        button, input, textarea, select { font: inherit; }
        a, button, input, textarea, select {
            transition: all .22s ease;
        }
        .container { width: min(1560px, calc(100% - 28px)); margin: 0 auto; }
        .main-nav, .header-tools, .policy-strip {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }
        .account-menu {
            position: relative;
            z-index: 1000;
        }
        .login-chip {
            padding: 9px 18px;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.7);
            color: #fff;
            font-weight: 600;
        }
        .account-chip {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding-right: 14px;
            background: transparent;
            border: none;
            cursor: pointer;
        }
        .account-name { color: #fff; }
        .account-caret { font-size: 12px; opacity: 0.9; }
        .account-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            min-width: 220px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 42px rgba(5, 40, 76, 0.2);
            border: 1px solid #d9e7f6;
            padding: 10px;
            display: none;
            z-index: 1001;
            pointer-events: auto;
        }
        .account-menu.is-open .account-dropdown {
            display: block;
        }
        .account-dropdown a,
        .account-dropdown button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 12px;
            border: none;
            background: transparent;
            border-radius: 12px;
            color: #17324d;
            text-align: left;
            cursor: pointer;
        }
        .account-dropdown a:hover,
        .account-dropdown button:hover {
            background: #f8fbff;
        }
        .site-header {
            background: linear-gradient(120deg, #1d4ed8 0%, #2563eb 35%, #4f46e5 70%, #7c3aed 100%);
            background-size: 220% 220%;
            animation: gradientShift 12s ease infinite;
            color: #fff;
            box-shadow: 0 14px 36px rgba(79, 70, 229, 0.22);
            position: relative;
            overflow: visible;
        }
        .site-header::before,
        .site-header::after {
            content: "";
            position: absolute;
            inset: -12%;
            pointer-events: none;
        }
        .site-header::before {
            background:
                radial-gradient(circle at 12% 24%, rgba(255,255,255,0.14) 0 3px, transparent 4px 100%),
                radial-gradient(circle at 76% 28%, rgba(255,255,255,0.12) 0 2px, transparent 3px 100%),
                linear-gradient(125deg, transparent 0 18%, rgba(255,255,255,0.08) 18% 19%, transparent 19% 36%, rgba(255,255,255,0.07) 36% 37%, transparent 37% 58%, rgba(255,255,255,0.08) 58% 59%, transparent 59%),
                linear-gradient(55deg, transparent 0 22%, rgba(255,255,255,0.06) 22% 23%, transparent 23% 44%, rgba(255,255,255,0.05) 44% 45%, transparent 45%);
            background-size: 220px 220px, 260px 260px, 100% 100%, 100% 100%;
            mix-blend-mode: screen;
            opacity: .95;
            animation: squiggleDrift 14s ease-in-out infinite;
        }
        .site-header::after {
            background:
                radial-gradient(ellipse at 18% 80%, rgba(147,197,253,0.18), transparent 34%),
                radial-gradient(ellipse at 84% 12%, rgba(255,255,255,0.12), transparent 28%),
                radial-gradient(ellipse at 66% 72%, rgba(244,114,182,0.12), transparent 24%);
            filter: blur(4px);
        }
        .header-main {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 220px minmax(340px, 1fr) auto;
            gap: 22px;
            align-items: center;
            padding: 20px 0 16px;
        }
        .logo-badge {
            width: 170px;
            height: 86px;
            border-radius: 999px 999px 999px 70px;
            background: linear-gradient(135deg, #60a5fa, #2563eb 48%, #7c3aed 100%);
            border: 4px solid rgba(255,255,255,0.22);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            color: #eaf4ff;
            position: relative;
            box-shadow: 0 12px 30px rgba(99, 102, 241, 0.28), inset 0 0 0 4px rgba(255,255,255,0.08);
        }
        .logo-badge::after {
            content: "";
            position: absolute;
            width: 118px;
            height: 34px;
            border: 3px solid rgba(255,255,255,0.18);
            border-radius: 999px;
            left: 14px;
            top: 14px;
            transform: rotate(-18deg);
        }
        .logo-badge span {
            position: relative;
            z-index: 1;
            color: #f8fbff;
        }
        .search-wrap {
            display: grid;
            grid-template-columns: 1fr 60px;
            border-radius: 14px;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(255,255,255,0.98), rgba(248,250,255,0.96));
            border: 1px solid rgba(255,255,255,0.36);
            box-shadow: 0 14px 30px rgba(37, 99, 235, 0.18);
        }
        .search-wrap:focus-within {
            transform: translateY(-1px);
            box-shadow: 0 18px 34px rgba(79, 70, 229, 0.26);
        }
        .search-wrap input {
            border: none;
            padding: 17px 18px;
            color: var(--ink);
            min-width: 0;
        }
        .search-wrap button {
            border: none;
            background: linear-gradient(135deg, rgba(37,99,235,0.08), rgba(124,58,237,0.12));
            color: var(--blue-deep);
            font-size: 26px;
            cursor: pointer;
        }
        .search-wrap button:hover {
            background: linear-gradient(135deg, rgba(37,99,235,0.16), rgba(124,58,237,0.18));
        }
        .header-tools { justify-content: flex-end; }
        .tool-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-width: 120px;
            color: #fff;
            font-weight: 600;
        }
        .tool-link:hover {
            transform: translateY(-1px);
            opacity: 0.96;
        }
        .tool-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255,255,255,0.38), rgba(147,197,253,0.18));
            display: grid;
            place-items: center;
            box-shadow: 0 10px 20px rgba(59,130,246,0.22), inset 0 -4px 0 rgba(0,0,0,0.08);
            font-size: 22px;
        }
        .cart-pill {
            width: 54px;
            height: 54px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,0.7);
            border-radius: 50%;
            color: #fff;
            position: relative;
            font-size: 24px;
        }
        .cart-pill:hover {
            background: linear-gradient(135deg, rgba(255,255,255,0.16), rgba(147,197,253,0.12));
            transform: translateY(-1px);
        }
        .cart-price {
            position: absolute;
            top: -6px;
            right: -4px;
            min-width: 24px;
            height: 24px;
            padding: 0 6px;
            display: grid;
            place-items: center;
            border-radius: 999px;
            background: linear-gradient(135deg, #ffe08a, #ffb347 55%, #ff8a00 100%);
            color: #2f3f55;
            font-weight: 800;
            font-size: 12px;
        }
        .header-account {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .admin-shortcut {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 16px;
            border-radius: 999px;
            background: linear-gradient(135deg, #ffe08a, #ffbf47 55%, #ff9f0a 100%);
            color: var(--ink);
            font-weight: 800;
        }
        .header-bottom { padding: 0 0 10px; }
        .header-bottom,
        .policy-strip { position: relative; z-index: 1; }
        .main-nav {
            justify-content: flex-start;
            gap: 34px;
            font-weight: 700;
        }
        .main-nav a,
        .trust-item {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
        }
        .trust-item {
            color: #fff;
            cursor: default;
            opacity: 0.9;
        }
        .policy-strip {
            padding: 10px 0 16px;
            justify-content: space-between;
            gap: 16px;
        }
        .policy-card {
            flex: 1 1 220px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            padding: 12px 14px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(96,165,250,0.14) 45%, rgba(124,58,237,0.12) 100%);
            border: 1px solid rgba(255,255,255,0.18);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.14);
        }
        .policy-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ffe08a, #ffbf47 55%, #ff9f0a 100%);
            color: #8a3412;
            display: grid;
            place-items: center;
            font-weight: 800;
            box-shadow: inset 0 -4px 0 rgba(0,0,0,0.08);
        }
        .policy-card strong { display: block; font-size: 14px; text-transform: uppercase; }
        .policy-card span { font-size: 14px; opacity: 0.95; }
        main { padding: 0 0 48px; }
        .flash {
            margin: 18px 0 0;
            padding: 14px 18px;
            border-radius: 16px;
            background: #effaf1;
            border: 1px solid #b7e1be;
            color: #166534;
        }
        .page-section { margin-top: 22px; }
        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow);
        }
        .card:hover {
            box-shadow: 0 22px 44px rgba(79, 70, 229, 0.16);
        }
        .section-title {
            margin: 0 0 16px;
            font-size: 28px;
            color: var(--ink);
        }
        .page-section .section-title {
            background: linear-gradient(135deg, #1d4ed8, #7c3aed 52%, #ff2d55 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 16px;
        }
        .section-link { color: var(--blue-deep); font-weight: 700; }
        .product-grid, .post-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 18px;
        }
        .product-card, .post-card {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
        }
        .product-card:hover, .post-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(79, 70, 229, 0.16);
            border-color: rgba(124,58,237,0.28);
        }
        .product-card img, .thumb {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 14px;
            background: #dfeffc;
        }
        .product-card h3, .post-card h3 { margin: 0; font-size: 18px; line-height: 1.4; }
        .meta { color: var(--muted); font-size: 14px; }
        .price {
            color: var(--red-deep);
            font-size: 24px;
            font-weight: 800;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            border-radius: 999px;
            padding: 11px 18px;
            cursor: pointer;
            background: linear-gradient(135deg, #ff7a3d 0%, #ff4d6d 45%, #ff2d55 100%);
            color: #fff;
            font-weight: 700;
            box-shadow: 0 14px 28px rgba(255, 45, 85, 0.28);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 34px rgba(255, 45, 85, 0.38);
        }
        .btn.secondary {
            background: #fff;
            color: var(--blue-deep);
            border: 1px solid var(--line);
            box-shadow: none;
        }
        .btn.secondary:hover {
            background: #f8fbff;
            border-color: #cbd5e1;
        }
        .stack-form { display: grid; gap: 14px; }
        .stack-form input, .stack-form textarea, .stack-form select {
            width: 100%;
            padding: 13px 15px;
            border-radius: 14px;
            border: 1px solid var(--line);
            background: #fff;
        }
        .stack-form input:focus, .stack-form textarea:focus, .stack-form select:focus {
            outline: none;
            border-color: #93c5fd;
            box-shadow: 0 0 0 4px rgba(21, 101, 192, 0.12);
        }
        footer {
            background: #0f4fa8;
            color: rgba(255,255,255,0.9);
            padding: 28px 0;
        }
        @media (max-width: 1180px) {
            .header-main { grid-template-columns: 1fr; }
            .header-tools { justify-content: flex-start; }
            .cart-pill { min-width: 0; }
            .policy-strip { justify-content: flex-start; }
        }
        @media (max-width: 900px) {
            .topbar-inner, .main-nav { gap: 10px; }
            .container { width: min(100% - 18px, 1560px); }
        }
        @media (max-width: 720px) {
            .topbar-list { gap: 10px; }
            .topbar-item + .topbar-item { padding-left: 0; border-left: 0; }
            .search-wrap { grid-template-columns: 1fr 52px; }
            .policy-card { flex-basis: 100%; }
            .section-title { font-size: 24px; }
        }
    </style>
</head>
<body>
    @php($cartCount = array_sum(session('cart', [])))
    <header class="site-header">
        <div class="container">
            <div class="header-main">
                <a href="{{ route('user.home') }}" class="logo-badge"><span>Code Store</span></a>

                <form class="search-wrap" action="{{ route('user.products') }}" method="GET">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Nhập từ khóa cần tìm...">
                    <button type="submit" aria-label="Tìm kiếm">⌕</button>
                </form>

                <div class="header-tools">
                    <a class="tool-link" href="{{ route('user.profile') }}">
                        <span class="tool-icon">✓</span>
                        <span>Theo dõi đơn hàng</span>
                    </a>
                    <a class="tool-link" href="{{ route('user.contact') }}">
                        <span class="tool-icon">☎</span>
                        <span>Hỗ trợ đặt hàng</span>
                    </a>
                    <div class="header-account">
                        <a class="cart-pill" href="{{ route('user.cart') }}" aria-label="Giỏ hàng">
                            <span>🛒</span>
                            <span class="cart-price">{{ $cartCount }}</span>
                        </a>
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a class="admin-shortcut" href="{{ route('admin.dashboard') }}">Admin</a>
                            @endif
                            <span class="login-chip" style="background:rgba(255,255,255,0.12);">
                                So du: {{ number_format(auth()->user()->balance) }} đ
                            </span>
                            <div class="account-menu" data-account-menu>
                                <button type="button" class="login-chip account-chip" aria-haspopup="true" aria-expanded="false" data-account-toggle>
                                    <span class="account-name">Xin chào, {{ auth()->user()->name }}</span>
                                    <span class="account-caret">▼</span>
                                </button>
                                <div class="account-dropdown" data-account-dropdown>
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('admin.dashboard') }}">Vào trang quản trị</a>
                                    @endif
                                    <a href="{{ route('user.profile') }}">Tài khoản của tôi</a>
                                    <form method="POST" action="{{ route('user.logout') }}" style="margin:0;">
                                        @csrf
                                        <button type="submit">Đăng xuất</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a class="login-chip" href="{{ route('user.login') }}">Đăng nhập / Đăng ký</a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="header-bottom">
                <nav class="main-nav">
                    <a href="{{ route('user.home') }}">☰ Danh mục sản phẩm</a>
                    <a href="{{ route('user.products') }}">Sản phẩm</a>
                    <span class="trust-item">▣ Code phong phú</span>
                    <span class="trust-item">◉ Code chất lượng</span>
                    <span class="trust-item">◌ Hỗ trợ 24/24</span>
                    <span class="trust-item">◍ Thanh toán</span>
                </nav>
            </div>

            <div class="policy-strip">
                <div class="policy-card">
                    <span class="policy-icon">✓</span>
                    <div>
                        <strong>Code phong phú</strong>
                        <span>Đầy đủ các thể loại và công nghệ phổ biến.</span>
                    </div>
                </div>
                <div class="policy-card">
                    <span class="policy-icon">★</span>
                    <div>
                        <strong>Code chất lượng</strong>
                        <span>Cam kết hỗ trợ cài đặt và chỉnh sửa cơ bản.</span>
                    </div>
                </div>
                <div class="policy-card">
                    <span class="policy-icon">24</span>
                    <div>
                        <strong>Hỗ trợ 24/24</strong>
                        <span>Trả lời nhanh qua hotline và form liên hệ.</span>
                    </div>
                </div>
                <div class="policy-card">
                    <span class="policy-icon">$</span>
                    <div>
                        <strong>Thanh toán</strong>
                        <span>Thanh toán an toàn, nhận source nhanh.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container">
        @if(session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="flash" style="background:#fff1f2; border-color:#fecdd3; color:#be123c;">
                {{ $errors->first() }}
            </div>
        @endif
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <strong>Web bán source code Laravel</strong>
            <p class="meta" style="color:rgba(255,255,255,0.78); margin:10px 0 0;">
                Giao diện đã được đổi theo phong cách sàn thương mại source code với topbar đỏ, header xanh, tìm kiếm lớn và bố cục tập trung vào sản phẩm.
            </p>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-account-menu]').forEach(function (menu) {
                var toggle = menu.querySelector('[data-account-toggle]');
                var dropdown = menu.querySelector('[data-account-dropdown]');

                if (!toggle) {
                    return;
                }

                toggle.addEventListener('click', function (event) {
                    event.stopPropagation();

                    var isOpen = menu.classList.toggle('is-open');
                    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                });

                if (dropdown) {
                    dropdown.addEventListener('click', function (event) {
                        event.stopPropagation();
                    });
                }
            });

            document.addEventListener('click', function () {
                document.querySelectorAll('[data-account-menu].is-open').forEach(function (menu) {
                    menu.classList.remove('is-open');

                    var toggle = menu.querySelector('[data-account-toggle]');
                    if (toggle) {
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                });
            });
        });
    </script>
</body>
</html>
