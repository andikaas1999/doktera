<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DOKTERA') — Dokumen Tertata Rapi</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --bg:        #F0F4FF;
            --sidebar-bg:#0F172A;
            --sidebar-w: 256px;
            --white:     #FFFFFF;
            --primary:   #4F46E5;
            --primary2:  #6366F1;
            --secondary: #F59E0B;
            --success:   #10B981;
            --danger:    #EF4444;
            --info:      #3B82F6;
            --text:      #1E293B;
            --text2:     #64748B;
            --border:    #E2E8F0;
            --card:      #FFFFFF;
            --radius:    14px;
            --radius-sm: 8px;
            --shadow:    0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.06);
            --shadow-lg: 0 8px 32px rgba(79,70,229,0.15);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        /* ── Sidebar ───────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow: hidden;
        }

        /* Decorative bg in sidebar */
        .sidebar::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(99,102,241,0.3) 0%, transparent 70%);
            pointer-events: none;
        }
        .sidebar::after {
            content: '';
            position: absolute;
            bottom: 80px; left: -40px;
            width: 150px; height: 150px;
            background: radial-gradient(circle, rgba(245,158,11,0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .sidebar-brand {
            padding: 24px 20px 18px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            position: relative;
            z-index: 1;
        }
        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 11px;
            text-decoration: none;
        }
        .brand-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: white;
            box-shadow: 0 4px 14px rgba(99,102,241,0.5);
            flex-shrink: 0;
        }
        .brand-name {
            font-size: 20px;
            font-weight: 800;
            color: white;
            letter-spacing: -0.3px;
        }
        .brand-sub {
            font-size: 10.5px;
            color: rgba(255,255,255,0.4);
            font-weight: 500;
            letter-spacing: 0.3px;
            margin-top: 1px;
        }

        .sidebar-nav {
            padding: 16px 12px;
            flex: 1;
            position: relative;
            z-index: 1;
        }
        .nav-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255,255,255,0.25);
            padding: 10px 10px 6px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
            position: relative;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.07);
            color: white;
        }
        .nav-item.active {
            background: linear-gradient(135deg, rgba(79,70,229,0.35), rgba(99,102,241,0.2));
            color: white;
            box-shadow: inset 0 0 0 1px rgba(99,102,241,0.4);
        }
        .nav-item.active .nav-icon {
            color: #A5B4FC;
        }
        .nav-icon {
            width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.06);
            border-radius: 8px;
            font-size: 13px;
            flex-shrink: 0;
            transition: all 0.2s;
        }
        .nav-item.active .nav-icon {
            background: rgba(99,102,241,0.35);
        }

        .sidebar-footer {
            padding: 14px 12px;
            border-top: 1px solid rgba(255,255,255,0.06);
            position: relative;
            z-index: 1;
        }
        .user-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 10px;
            background: rgba(255,255,255,0.05);
        }
        .user-ava {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: white;
            flex-shrink: 0;
        }
        .user-name { color: white; font-size: 13px; font-weight: 600; }
        .user-role { color: rgba(255,255,255,0.35); font-size: 11px; }
        .logout-form { margin-left: auto; }
        .logout-btn {
            background: none; border: none;
            color: rgba(255,255,255,0.3);
            cursor: pointer; font-size: 14px; padding: 4px;
            transition: color 0.2s;
        }
        .logout-btn:hover { color: var(--danger); }

        /* ── Main ─────────────────────────── */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            background: white;
            padding: 0 32px;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .page-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; color: white;
        }
        .page-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .topbar-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--bg);
            border: 1px solid var(--border);
            color: var(--text2);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-family: 'JetBrains Mono', monospace;
        }

        .page-body {
            padding: 28px 32px;
            flex: 1;
        }

        /* ── Alerts ────────────────────────── */
        .alert {
            padding: 13px 18px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .alert-success {
            background: linear-gradient(135deg, #ECFDF5, #D1FAE5);
            color: #065F46;
            border: 1px solid #A7F3D0;
        }
        .alert-danger {
            background: linear-gradient(135deg, #FEF2F2, #FEE2E2);
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        /* ── Stat Cards ───────────────────── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 20px 22px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 80px; height: 80px;
            border-radius: 50%;
            opacity: 0.07;
            transform: translate(20px, -20px);
        }
        .stat-card.c1::before { background: var(--primary); }
        .stat-card.c2::before { background: var(--secondary); }
        .stat-card.c3::before { background: #8B5CF6; }
        .stat-card.c4::before { background: var(--success); }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }
        .stat-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-card.c1 .stat-badge { background: #EEF2FF; color: var(--primary); }
        .stat-card.c2 .stat-badge { background: #FFFBEB; color: #D97706; }
        .stat-card.c3 .stat-badge { background: #F5F3FF; color: #7C3AED; }
        .stat-card.c4 .stat-badge { background: #ECFDF5; color: #059669; }

        .stat-icon-box {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px;
        }
        .stat-card.c1 .stat-icon-box { background: #EEF2FF; color: var(--primary); }
        .stat-card.c2 .stat-icon-box { background: #FFFBEB; color: #D97706; }
        .stat-card.c3 .stat-icon-box { background: #F5F3FF; color: #7C3AED; }
        .stat-card.c4 .stat-icon-box { background: #ECFDF5; color: #059669; }

        .stat-val {
            font-size: 32px;
            font-weight: 800;
            color: var(--text);
            font-family: 'JetBrains Mono', monospace;
            line-height: 1;
            margin-bottom: 4px;
        }
        .stat-lbl {
            font-size: 12.5px;
            color: var(--text2);
            font-weight: 500;
        }

        /* ── Panel ────────────────────────── */
        .panel {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            overflow: hidden;
        }
        .panel-head {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #FAFBFF, #F8F9FE);
        }
        .panel-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .panel-title-icon {
            width: 30px; height: 30px;
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; color: white;
        }
        .panel-body { padding: 24px; }

        /* ── Buttons ──────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            border: none;
            white-space: nowrap;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            color: white;
            box-shadow: 0 4px 14px rgba(79,70,229,0.35);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(79,70,229,0.45);
        }
        .btn-outline {
            background: white;
            color: var(--text2);
            border: 1.5px solid var(--border);
        }
        .btn-outline:hover { border-color: var(--primary); color: var(--primary); }
        .btn-success {
            background: linear-gradient(135deg, #10B981, #059669);
            color: white;
            box-shadow: 0 3px 10px rgba(16,185,129,0.3);
        }
        .btn-success:hover { transform: translateY(-1px); }
        .btn-danger {
            background: linear-gradient(135deg, #EF4444, #DC2626);
            color: white;
            box-shadow: 0 3px 10px rgba(239,68,68,0.3);
        }
        .btn-danger:hover { transform: translateY(-1px); }
        .btn-warning {
            background: linear-gradient(135deg, #F59E0B, #D97706);
            color: white;
            box-shadow: 0 3px 10px rgba(245,158,11,0.3);
        }
        .btn-sm { padding: 6px 12px; font-size: 12px; }

        /* ── Search ───────────────────────── */
        .search-bar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .search-wrap {
            flex: 1;
            min-width: 240px;
            position: relative;
        }
        .search-wrap i {
            position: absolute;
            left: 13px; top: 50%;
            transform: translateY(-50%);
            color: var(--text2);
            font-size: 13px;
            pointer-events: none;
        }
        .search-wrap input { padding-left: 38px; }

        /* ── Form ─────────────────────────── */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text2);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            background: white;
            transition: all 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .is-invalid { border-color: var(--danger) !important; }
        .invalid-feedback { color: var(--danger); font-size: 12px; margin-top: 4px; }

        /* ── Table ────────────────────────── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            padding: 11px 16px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text2);
            background: #F8FAFC;
            border-bottom: 2px solid var(--border);
            text-align: left;
            white-space: nowrap;
        }
        tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #F1F5F9;
            font-size: 13px;
            vertical-align: middle;
        }
        tbody tr {
            transition: background 0.15s;
        }
        tbody tr:hover { background: #F8FAFF; }
        tbody tr:last-child td { border-bottom: none; }

        .doc-num {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            font-weight: 600;
            color: var(--primary);
            background: #EEF2FF;
            padding: 3px 9px;
            border-radius: 20px;
            white-space: nowrap;
        }
        .loc-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: linear-gradient(135deg, #EEF2FF, #E0E7FF);
            color: #3730A3;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
            font-family: 'JetBrains Mono', monospace;
            white-space: nowrap;
            border: 1px solid #C7D2FE;
        }
        .cat-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
            white-space: nowrap;
        }
        .cat-perencanaan { background: #FFFBEB; color: #D97706; border: 1px solid #FDE68A; }
        .cat-pelaporan   { background: #EFF6FF; color: #1D4ED8; border: 1px solid #BFDBFE; }
        .cat-lainnya     { background: #F5F3FF; color: #7C3AED; border: 1px solid #DDD6FE; }
        .cat-default     { background: #F1F5F9; color: #64748B; border: 1px solid #E2E8F0; }

        .status-dot {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
        }
        .dot {
            width: 7px; height: 7px;
            border-radius: 50%;
        }
        .dot-active   { background: var(--success); box-shadow: 0 0 0 2px rgba(16,185,129,0.2); }
        .dot-archived { background: var(--secondary); }

        /* ── Section Divider ─────────────── */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 24px 0 16px;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .section-divider .line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Location Cards ──────────────── */
        .loc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
            gap: 18px;
        }
        .cab-card {
            background: white;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            overflow: hidden;
            transition: all 0.25s;
            box-shadow: var(--shadow);
        }
        .cab-card:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }
        .cab-head {
            background: linear-gradient(135deg, #0F172A, #1E3A5F);
            padding: 18px 20px;
            position: relative;
            overflow: hidden;
        }
        .cab-head::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 100px; height: 100px;
            background: rgba(99,102,241,0.2);
            border-radius: 50%;
        }
        .cab-head-inner {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }
        .cab-num-icon {
            width: 42px; height: 42px;
            background: rgba(255,255,255,0.12);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: white;
        }
        .cab-num { color: white; font-size: 14px; font-weight: 700; }
        .cab-lbl { color: rgba(255,255,255,0.55); font-size: 11.5px; margin-top: 1px; }
        .cab-count {
            margin-left: auto;
            text-align: right;
        }
        .cab-count-num { color: white; font-size: 22px; font-weight: 800; font-family: 'JetBrains Mono', monospace; }
        .cab-count-lbl { color: rgba(255,255,255,0.4); font-size: 10px; }
        .cab-body { padding: 12px 16px; }
        .ord-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 0;
            border-bottom: 1px solid #F8FAFC;
        }
        .ord-item:last-child { border-bottom: none; }
        .ord-icon {
            width: 30px; height: 30px;
            background: linear-gradient(135deg, #FFFBEB, #FEF3C7);
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; color: #D97706;
            flex-shrink: 0;
        }
        .ord-num { font-size: 13px; font-weight: 600; color: var(--text); }
        .ord-lbl { font-size: 11px; color: var(--text2); }
        .ord-link {
            margin-left: auto;
            color: var(--primary);
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            display: flex; align-items: center; gap: 4px;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .ord-item:hover .ord-link { opacity: 1; }

        /* ── Pagination ──────────────────── */
        .pager {
            display: flex;
            gap: 5px;
            justify-content: flex-end;
            padding-top: 20px;
            flex-wrap: wrap;
        }
        .pager a, .pager span {
            padding: 7px 13px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            color: var(--text2);
            background: white;
            border: 1.5px solid var(--border);
            transition: all 0.2s;
        }
        .pager a:hover { border-color: var(--primary); color: var(--primary); }
        .pager .active {
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            color: white;
            border-color: transparent;
            box-shadow: 0 3px 10px rgba(79,70,229,0.3);
        }

        @media (max-width: 1024px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .form-row  { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('documents.index') }}" class="brand-wrap">
            <div class="brand-icon"><i class="fas fa-layer-group"></i></div>
            <div>
                <div class="brand-name">DOKTERA</div>
                <div class="brand-sub">Dokumen Tertata Rapi</div>
            </div>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-label">Katalog</div>
        <a href="{{ route('documents.index') }}"
           class="nav-item {{ request()->routeIs('documents.index') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-table-list"></i></span>
            Daftar Dokumen
        </a>
        <a href="{{ route('documents.create') }}"
           class="nav-item {{ request()->routeIs('documents.create') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-cloud-arrow-up"></i></span>
            Upload Dokumen
        </a>
        <a href="{{ route('documents.location') }}"
           class="nav-item {{ request()->routeIs('documents.location') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-map-location-dot"></i></span>
            Lokasi Fisik
        </a>
        <div class="nav-label" style="margin-top:10px;">Akun</div>
        <a href="{{ route('password.change') }}"
           class="nav-item {{ request()->routeIs('password.change') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-key"></i></span>
            Ganti Password
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="user-wrap">
            <div class="user-ava">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ Auth::user()->name ?? 'User' }}</div>
                <div class="user-role">Administrator</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn" title="Logout">
                    <i class="fas fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <div class="topbar-left">
            <div class="page-icon">
                <i class="fas fa-file-lines"></i>
            </div>
            <span class="page-title">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="topbar-right">
            <div class="topbar-chip">
                <i class="fas fa-calendar" style="color:var(--primary)"></i>
                {{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}
            </div>
        </div>
    </header>

    <div class="page-body">
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-circle-check"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-circle-exclamation"></i> {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>
