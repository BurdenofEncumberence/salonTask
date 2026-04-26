<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title', 'Dashboard') — Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --black: #0a0a0a;
            --gray-900: #1a1a1a;
            --gray-700: #333333;
            --gray-500: #666666;
            --gray-300: #cccccc;
            --gray-100: #f0f0f0;
            --gray-50: #f8f8f8;
            --white: #ffffff;
            --success: #1a7a3c;
            --success-bg: #e8f5ed;
            --danger: #a01a1a;
            --danger-bg: #f5e8e8;
            --warning: #7a5a00;
            --warning-bg: #f5f0e0;
            --border: #e0e0e0;
            --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
        }

        body {
            font-family: 'Geist', system-ui, sans-serif;
            background: var(--gray-50);
            color: var(--black);
            min-height: 100vh;
            font-size: 14px;
            line-height: 1.5;
        }

        /* ── Navbar ── */
        .navbar {
            background: var(--black);
            height: 50px;
            display: flex;
            align-items: center;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2px;
            flex: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 400;
            border-radius: 5px;
            transition: all 0.15s;
            white-space: nowrap;
        }
        .nav-item:hover { color: var(--white); background: rgba(255,255,255,0.07); }
        .nav-item.active { color: var(--white); background: rgba(255,255,255,0.1); font-weight: 500; }
        .nav-item svg { opacity: 0.65; flex-shrink: 0; }
        .nav-item:hover svg, .nav-item.active svg { opacity: 1; }

        .nav-sep {
            width: 1px; height: 18px;
            background: rgba(255,255,255,0.1);
            margin: 0 6px;
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .nav-user-name { font-size: 0.78rem; color: rgba(255,255,255,0.5); }

        .nav-logout {
            padding: 5px 11px;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.5);
            border-radius: 5px;
            font-size: 0.76rem;
            font-family: 'Geist', sans-serif;
            cursor: pointer;
            transition: all 0.15s;
        }
        .nav-logout:hover { background: rgba(255,255,255,0.07); color: var(--white); border-color: rgba(255,255,255,0.25); }

        /* ── Page header ── */
        .page-header {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 18px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .page-title { font-size: 1rem; font-weight: 600; color: var(--black); letter-spacing: -0.01em; }
        .page-subtitle { font-size: 0.75rem; color: var(--gray-500); margin-top: 1px; }

        /* ── Content ── */
        .content-area { padding: 24px 28px; }

        /* ── Alerts ── */
        .alert {
            padding: 10px 14px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-size: 0.82rem;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid;
        }
        .alert-success { background: var(--success-bg); color: var(--success); border-color: #b2d8c0; }
        .alert-error   { background: var(--danger-bg);  color: var(--danger);  border-color: #d8b2b2; }

        /* ── Cards ── */
        .card { background: var(--white); border-radius: 8px; border: 1px solid var(--border); overflow: hidden; }
        .card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-title { font-size: 0.86rem; font-weight: 600; color: var(--black); }
        .card-body { padding: 20px; }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 15px;
            border-radius: 6px;
            font-size: 0.81rem;
            font-family: 'Geist', sans-serif;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.15s;
            line-height: 1;
        }
        .btn-primary  { background: var(--black); color: var(--white); border-color: var(--black); }
        .btn-primary:hover { background: var(--gray-900); box-shadow: var(--shadow-md); }
        .btn-outline  { background: var(--white); color: var(--black); border-color: var(--border); }
        .btn-outline:hover { background: var(--gray-50); border-color: var(--gray-300); }
        .btn-danger   { background: var(--white); color: var(--danger); border-color: #d8b2b2; }
        .btn-danger:hover { background: var(--danger-bg); }
        .btn-success  { background: var(--black); color: var(--white); border-color: var(--black); }
        .btn-success:hover { background: var(--gray-900); }
        .btn-sm { padding: 5px 10px; font-size: 0.75rem; }

        /* ── Table ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.83rem; }
        thead tr { background: var(--gray-50); border-bottom: 1px solid var(--border); }
        thead th {
            padding: 10px 16px;
            text-align: left;
            font-size: 0.67rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--gray-500);
        }
        tbody tr { border-bottom: 1px solid var(--gray-100); transition: background 0.1s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--gray-50); }
        tbody td { padding: 12px 16px; color: var(--black); vertical-align: middle; }

        /* ── Badges ── */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.67rem;
            font-weight: 500;
            text-transform: capitalize;
            font-family: 'Geist Mono', monospace;
        }
        .badge-paid      { background: var(--success-bg); color: var(--success); }
        .badge-unpaid    { background: var(--danger-bg);  color: var(--danger); }
        .badge-pending   { background: var(--warning-bg); color: var(--warning); }
        .badge-confirmed { background: var(--success-bg); color: var(--success); }
        .badge-completed { background: var(--gray-100);   color: var(--gray-700); }
        .badge-cancelled { background: var(--gray-100);   color: var(--gray-500); }

        /* ── Forms ── */
        .form-group { margin-bottom: 15px; }
        .form-label { display: block; font-size: 0.76rem; font-weight: 500; color: var(--gray-700); margin-bottom: 5px; }
        .form-control {
            width: 100%;
            padding: 8px 11px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-family: 'Geist', sans-serif;
            font-size: 0.84rem;
            color: var(--black);
            background: var(--white);
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }
        .form-control:focus { border-color: var(--black); box-shadow: 0 0 0 3px rgba(0,0,0,0.06); }
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23666' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 11px center;
            padding-right: 30px;
        }
        textarea.form-control { min-height: 88px; resize: vertical; }
        .form-error { font-size: 0.72rem; color: var(--danger); margin-top: 4px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }

        .form-section-label {
            font-size: 0.66rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-bottom: 8px;
        }
        .form-section {
            padding: 16px;
            background: var(--gray-50);
            border: 1px solid var(--border);
            border-radius: 7px;
            margin-bottom: 16px;
        }

        .action-btns { display: flex; gap: 5px; align-items: center; }

        /* ── Stats ── */
        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 22px; }
        .stat-card { background: var(--white); border-radius: 8px; padding: 18px; border: 1px solid var(--border); }
        .stat-icon { width: 32px; height: 32px; background: var(--gray-100); border-radius: 6px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
        .stat-value { font-size: 1.55rem; font-weight: 600; color: var(--black); line-height: 1; letter-spacing: -0.02em; }
        .stat-label { font-size: 0.7rem; color: var(--gray-500); margin-top: 4px; text-transform: uppercase; letter-spacing: 0.08em; }

        /* ── Empty ── */
        .empty-state { text-align: center; padding: 52px 20px; }
        .empty-state svg { opacity: 0.22; margin-bottom: 12px; }
        .empty-state p { font-size: 0.85rem; color: var(--gray-500); }

        /* ── Pagination ── */
        .pagination { display: flex; gap: 4px; }
        .pagination a, .pagination span {
            padding: 6px 10px; border-radius: 5px; font-size: 0.78rem;
            text-decoration: none; color: var(--gray-500); border: 1px solid var(--border); transition: all 0.15s;
        }
        .pagination a:hover { background: var(--gray-50); color: var(--black); }
        .pagination span.current { background: var(--black); color: white; border-color: var(--black); }

        @media (max-width: 1024px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
            <div class="nav-sep"></div>
            <a href="{{ route('services.index') }}" class="nav-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Services
            </a>
            <a href="{{ route('appointments.index') }}" class="nav-item {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Appointments
            </a>
            <a href="{{ route('payments.index') }}" class="nav-item {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Payments
            </a>
        </div>

        <div class="nav-user">
            <span class="nav-user-name">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-logout">Sign Out</button>
            </form>
        </div>
    </nav>

    <header class="page-header">
        <div>
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            <p class="page-subtitle">@yield('page-subtitle', '')</p>
        </div>
        <div>@yield('header-action')</div>
    </header>

    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

</body>
</html>