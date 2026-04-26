<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }}</title>
    <style>
        :root {
            --bg: #0a1020;
            --panel: #0f172a;
            --panel-soft: #111c34;
            --panel-muted: #15223d;
            --line: rgba(148, 163, 184, 0.14);
            --text: #e5edf8;
            --muted: #94a3b8;
            --blue: #60a5fa;
            --blue-deep: #2563eb;
            --violet: #8b5cf6;
            --green: #22c55e;
            --amber: #f59e0b;
            --red: #f43f5e;
            --shadow: 0 20px 48px rgba(2, 6, 23, 0.34);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.18), transparent 26%),
                radial-gradient(circle at top right, rgba(139, 92, 246, 0.14), transparent 22%),
                linear-gradient(180deg, #0b1120 0%, #09101d 100%);
        }

        a { color: inherit; text-decoration: none; }
        table { width: 100%; border-collapse: collapse; }
        input, textarea, select, button { font: inherit; }

        .layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
        }

        .sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 24px 18px;
            background:
                linear-gradient(180deg, rgba(15, 23, 42, 0.94), rgba(10, 16, 32, 0.98)),
                linear-gradient(135deg, rgba(37, 99, 235, 0.08), rgba(139, 92, 246, 0.08));
            border-right: 1px solid var(--line);
            backdrop-filter: blur(14px);
        }

        .brand-card {
            padding: 18px;
            border-radius: 22px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.22), rgba(139, 92, 246, 0.18));
            border: 1px solid rgba(96, 165, 250, 0.18);
            box-shadow: var(--shadow);
            margin-bottom: 18px;
        }

        .brand-card h2 {
            margin: 0 0 8px;
            font-size: 22px;
            letter-spacing: 0.02em;
        }

        .brand-card p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .sidebar-nav {
            display: grid;
            gap: 8px;
            margin-top: 18px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 13px 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid transparent;
            color: #dbe7f6;
            transition: all .22s ease;
        }

        .sidebar-link:hover {
            transform: translateX(4px);
            background: rgba(96, 165, 250, 0.08);
            border-color: rgba(96, 165, 250, 0.16);
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.18), rgba(139, 92, 246, 0.18));
            border-color: rgba(96, 165, 250, 0.18);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.04);
        }

        .sidebar-link small {
            color: var(--muted);
            font-size: 12px;
        }

        .content {
            padding: 28px;
        }

        .page-head {
            position: sticky;
            top: 16px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 16px 18px;
            margin-bottom: 18px;
            border-radius: 20px;
            background: rgba(15, 23, 42, 0.82);
            border: 1px solid var(--line);
            backdrop-filter: blur(12px);
            box-shadow: var(--shadow);
        }

        .page-head h1 {
            margin: 0 0 4px;
            font-size: 26px;
        }

        .page-head p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 20px;
            margin-bottom: 22px;
            border-radius: 22px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.82), rgba(17, 28, 52, 0.9));
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
        }

        .topbar h1 {
            margin: 0 0 6px;
            font-size: 28px;
        }

        .topbar p {
            margin: 0;
            color: var(--muted);
        }

        .topbar-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-height: 46px;
            padding: 0 18px;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.22), rgba(139, 92, 246, 0.22));
            border: 1px solid rgba(96, 165, 250, 0.18);
            color: #f8fbff;
            font-weight: 700;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .dashboard-shell {
            display: grid;
            gap: 22px;
        }

        .dashboard-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(320px, .9fr);
            gap: 18px;
        }

        .hero-panel,
        .side-panel {
            position: relative;
            overflow: hidden;
            border-radius: 24px;
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
        }

        .hero-panel {
            padding: 26px;
            background:
                radial-gradient(circle at top right, rgba(96, 165, 250, 0.26), transparent 26%),
                radial-gradient(circle at bottom left, rgba(244, 63, 94, 0.18), transparent 24%),
                linear-gradient(135deg, rgba(37, 99, 235, 0.28), rgba(79, 70, 229, 0.22) 52%, rgba(15, 23, 42, 0.98) 100%);
        }

        .hero-panel::after,
        .side-panel::after {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: .38;
            background:
                linear-gradient(130deg, transparent 0 20%, rgba(255,255,255,0.08) 20% 21%, transparent 21% 40%, rgba(255,255,255,0.05) 40% 41%, transparent 41%),
                linear-gradient(40deg, transparent 0 28%, rgba(255,255,255,0.04) 28% 29%, transparent 29% 56%, rgba(255,255,255,0.04) 56% 57%, transparent 57%);
        }

        .hero-panel > *,
        .side-panel > * {
            position: relative;
            z-index: 1;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            min-height: 34px;
            padding: 0 12px;
            border-radius: 999px;
            background: rgba(255,255,255,0.08);
            color: #dbeafe;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .hero-title {
            margin: 0 0 12px;
            font-size: 34px;
            line-height: 1.05;
            letter-spacing: -.02em;
        }

        .hero-copy {
            margin: 0 0 18px;
            color: #cbd5e1;
            max-width: 720px;
            line-height: 1.7;
        }

        .hero-strip {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            margin-top: 18px;
        }

        .hero-chip {
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
        }

        .hero-chip strong {
            display: block;
            font-size: 20px;
            margin-bottom: 4px;
        }

        .hero-chip span {
            color: #94a3b8;
            font-size: 13px;
        }

        .side-panel {
            padding: 22px;
            background:
                radial-gradient(circle at top left, rgba(34, 197, 94, 0.18), transparent 24%),
                linear-gradient(180deg, rgba(17, 28, 52, 0.98), rgba(11, 18, 34, 0.98));
        }

        .side-panel h3 {
            margin: 0 0 8px;
            font-size: 20px;
        }

        .side-panel p {
            margin: 0 0 16px;
            color: var(--muted);
            line-height: 1.6;
        }

        .metric-stack {
            display: grid;
            gap: 12px;
        }

        .metric-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--line);
        }

        .metric-row strong {
            font-size: 20px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.3fr) minmax(320px, .95fr);
            gap: 18px;
        }

        .list-stack {
            display: grid;
            gap: 12px;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--line);
        }

        .activity-item strong,
        .activity-item .title {
            display: block;
            margin-bottom: 4px;
            font-weight: 700;
        }

        .activity-meta {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: 0 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-badge.green {
            background: rgba(34, 197, 94, 0.14);
            color: #86efac;
        }

        .status-badge.amber {
            background: rgba(245, 158, 11, 0.14);
            color: #fcd34d;
        }

        .card,
        .table-wrap {
            background: linear-gradient(180deg, rgba(17, 28, 52, 0.96), rgba(13, 21, 39, 0.98));
            border: 1px solid var(--line);
            border-radius: 22px;
            box-shadow: var(--shadow);
        }

        .card {
            padding: 20px;
        }

        .card.stat-card {
            position: relative;
            overflow: hidden;
        }

        .card.stat-card::before {
            content: "";
            position: absolute;
            inset: auto -30px -30px auto;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .stat-kicker {
            color: var(--muted);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .stat-value {
            font-size: 34px;
            font-weight: 800;
            line-height: 1.1;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            font-size: 20px;
            font-weight: 900;
            color: #fff;
        }

        .stat-icon.blue { background: linear-gradient(135deg, #2563eb, #60a5fa); }
        .stat-icon.violet { background: linear-gradient(135deg, #7c3aed, #a78bfa); }
        .stat-icon.amber { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
        .stat-icon.green { background: linear-gradient(135deg, #16a34a, #4ade80); }

        .muted { color: var(--muted); }

        .table-wrap {
            padding: 18px 18px 10px;
            overflow: auto;
        }

        .table-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 12px;
        }

        .table-head h3 {
            margin: 0;
            font-size: 18px;
        }

        .table-chip {
            display: inline-flex;
            align-items: center;
            min-height: 32px;
            padding: 0 12px;
            border-radius: 999px;
            background: rgba(255,255,255,0.06);
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
        }

        th, td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--line);
            text-align: left;
            vertical-align: top;
        }

        th {
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        tr:last-child td { border-bottom: none; }

        tbody tr:hover td {
            background: rgba(255,255,255,0.02);
        }

        .data-thumb {
            width: 72px;
            height: 54px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid rgba(148, 163, 184, 0.16);
            background: #0b1222;
        }

        .cell-title {
            font-weight: 700;
            margin-bottom: 4px;
        }

        .toolbar-meta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 38px;
            padding: 0 12px;
            border-radius: 999px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--line);
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
        }

        input, textarea, select {
            width: 100%;
            padding: 11px 13px;
            border-radius: 14px;
            border: 1px solid var(--line);
            background: #0b1222;
            color: var(--text);
        }

        form { display: grid; gap: 12px; }

        .field-label {
            display: grid;
            gap: 8px;
            font-weight: 600;
            color: var(--text);
        }

        .btn {
            background: linear-gradient(135deg, #f59e0b, #f97316);
            color: #111827;
            border: none;
            padding: 10px 14px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            box-shadow: 0 10px 24px rgba(245, 158, 11, 0.18);
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn.secondary {
            background: rgba(255,255,255,0.06);
            color: var(--text);
            border: 1px solid var(--line);
            box-shadow: none;
        }

        .btn.danger {
            background: linear-gradient(135deg, #fb7185, #e11d48);
            color: #fff;
            box-shadow: 0 10px 24px rgba(225, 29, 72, 0.18);
        }

        .inline {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(3, 10, 25, 0.68);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            z-index: 1000;
        }

        .modal-backdrop.open { display: flex; }

        .modal-card {
            width: min(760px, 100%);
            max-height: calc(100vh - 48px);
            overflow: auto;
            background: var(--panel-soft);
            border: 1px solid var(--line);
            border-radius: 20px;
            padding: 20px;
        }

        .modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .close-btn {
            background: transparent;
            color: var(--text);
            border: 1px solid var(--line);
            padding: 8px 12px;
            border-radius: 10px;
            cursor: pointer;
        }

        @media (max-width: 980px) {
            .layout { grid-template-columns: 1fr; }
            .sidebar {
                position: static;
                height: auto;
                border-right: none;
                border-bottom: 1px solid var(--line);
            }
            .dashboard-hero,
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            .hero-strip {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    @php($admin = auth()->user())
    @php($currentRoute = request()->route()?->getName())

    <div class="layout">
        <aside class="sidebar">
            <div class="brand-card">
                <h2>Admin Console</h2>
                <p>{{ $admin->name ?? 'Administrator' }}</p>
            </div>

            <nav class="sidebar-nav">
                <a class="sidebar-link {{ $currentRoute === 'admin.dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <span>Dashboard</span>
                    <small>/admin</small>
                </a>
                <a class="sidebar-link {{ str_starts_with($currentRoute ?? '', 'admin.products.') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                    <span>Sản phẩm</span>
                    <small>Catalog</small>
                </a>
                <a class="sidebar-link {{ str_starts_with($currentRoute ?? '', 'admin.categories.') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <span>Danh mục</span>
                    <small>Groups</small>
                </a>
                <a class="sidebar-link {{ str_starts_with($currentRoute ?? '', 'admin.orders.') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                    <span>Đơn hàng</span>
                    <small>Sales</small>
                </a>
                <a class="sidebar-link {{ str_starts_with($currentRoute ?? '', 'admin.users.') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <span>Người dùng</span>
                    <small>Accounts</small>
                </a>
                <a class="sidebar-link {{ str_starts_with($currentRoute ?? '', 'admin.posts.') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">
                    <span>Bài viết</span>
                    <small>Content</small>
                </a>
                <a class="sidebar-link {{ str_starts_with($currentRoute ?? '', 'admin.contacts.') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">
                    <span>Liên hệ</span>
                    <small>Inbox</small>
                </a>
                <a class="sidebar-link" href="{{ route('user.home') }}">
                    <span>Về frontend</span>
                    <small>Store</small>
                </a>
            </nav>
        </aside>

        <section class="content">
            @if(session('success'))
                <div class="card" style="margin-bottom:18px; color:#86efac;">{{ session('success') }}</div>
            @endif

            @yield('content')
        </section>
    </div>
    <script>
        document.addEventListener('submit', function (event) {
            const form = event.target;

            if (!form.matches('form[data-confirm-message]')) {
                return;
            }

            const message = form.getAttribute('data-confirm-message') || 'Ban co chac chan muon xoa muc nay khong?';

            if (!window.confirm(message)) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
