@extends('layouts.app')
@section('page_title', $page_title ?? 'หน้าหลัก')

@section('style')
    <style>
        body {
            background: #f4f6fb;
        }

        .sidebar,
        .iq-navbar,
        .iq-navbar-header,
        .footer {
            display: none !important;
        }

        .main-content {
            margin-left: 0 !important;
            padding-top: 0 !important;
            min-height: 100vh;
            background: #f4f6fb;
        }

        .content-inner {
            padding: 0 !important;
        }

        .mobile-shell {
            width: 100%;
            max-width: 430px;
            min-height: 100vh;
            margin: 0 auto;
            padding: 76px 14px 100px;
            background: linear-gradient(180deg, #ffffff 0%, #f7f8fc 28%, #f4f6fb 100%);
            box-shadow: 0 0 0 1px rgba(17, 24, 39, 0.03);
        }

        .mobile-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 14px 10px;
            margin: 0;
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: min(430px, 100%);
            border-radius: 0 0 20px 20px;
            z-index: 1040;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 6px 18px rgba(17, 24, 39, 0.06);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .mobile-topbar-title {
            flex: 1;
            text-align: center;
            font-size: 1.35rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .mobile-topbar-action {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            border: 1px solid rgba(17, 24, 39, 0.08);
            background: rgba(255, 255, 255, 0.9);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #111827;
            flex: 0 0 auto;
        }

        .hero-card {
            border: 1px solid rgba(76, 89, 255, 0.08);
            border-radius: 28px;
            background: linear-gradient(180deg, #eef2ff 0%, #f8faff 100%);
            padding: 20px 16px 18px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(17, 24, 39, 0.05);
        }

        .hero-icon {
            width: 80%;
            height: 88px;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4552d0;
            overflow: hidden;
        }

        .hero-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }



        .hero-title {
            font-size: 1.42rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .hero-subtitle {
            font-size: 1.02rem;
            line-height: 1.5;
            color: #374151;
            margin: 0;
        }

        .section-card {
            padding: 16px 14px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 1.06rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .section-link {
            font-size: 0.92rem;
            color: #4169e1;
            text-decoration: none;
            font-weight: 600;
        }

        .list-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 0;
        }

        .list-item+.list-item {
            border-top: 1px solid rgba(17, 24, 39, 0.06);
        }

        .list-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            background: rgba(69, 82, 208, 0.10);
            color: #4552d0;
            flex: 0 0 auto;
        }

        .list-body {
            flex: 1;
            min-width: 0;
        }

        .list-title {
            font-size: 0.98rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 4px;
            line-height: 1.35;
        }

        .list-meta {
            font-size: 0.88rem;
            color: #6b7280;
            margin: 0;
        }

        .list-state {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
            background: #eefaf2;
            color: #16834d;
            white-space: nowrap;
            flex: 0 0 auto;
        }

        .bottom-nav {
            position: fixed;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: min(430px, 100%);
            border-top: 1px solid rgba(17, 24, 39, 0.08);
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(18px);
            box-shadow: 0 -10px 28px rgba(17, 24, 39, 0.08);
            padding: 8px 10px 10px;
            z-index: 1030;
        }

        .bottom-nav-inner {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 4px;
        }

        .bottom-nav-item {
            appearance: none;
            border: 0;
            background: transparent;
            color: #8a8f98;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 6px 2px 2px;
            text-decoration: none;
            font-size: 0.72rem;
            font-weight: 600;
            line-height: 1.1;
        }

        .bottom-nav-item i {
            font-size: 1.15rem;
        }

        .bottom-nav-item.is-active {
            color: #4552d0;
        }

        .bottom-nav-icon {
            width: 36px;
            height: 36px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.15s ease;
        }

        .bottom-nav-item.is-active .bottom-nav-icon {
            background: rgba(69, 82, 208, 0.12);
            color: #4552d0;
        }

        .page-spacer {
            height: 12px;
        }
    </style>
@endsection

@section('content')
    <div class="mobile-shell">
        <div class="mobile-topbar">
            <div style="width:42px;"></div>
            <h1 class="mobile-topbar-title">{{ $page_title ?? 'หน้าหลัก' }}</h1>
            <a href="{{ route('app.notifications') }}" class="mobile-topbar-action text-decoration-none" aria-label="การแจ้งเตือน">
                <i class="fa-regular fa-bell fa-lg"></i>
            </a>
        </div>

        {{-- <div class="hero-card mb-3">
            <div class="hero-title">{{ $hero_title ?? ($page_title ?? 'หน้าหลัก') }}</div>
            <p class="hero-subtitle">{{ $hero_text ?? ($page_subtitle ?? '') }}</p>
        </div> --}}

        @if (request()->routeIs('app.about'))
            <div class="hero-card mb-3">
                <div class="hero-icon">
                    <img src="{{ asset('assets/images/logo/logo_horizontal_transparent.png') }}" alt="TU SkinSafe">
                </div>
                <div class="hero-title">ระบบต้นแบบ</div>
                <p class="hero-subtitle">จัดเก็บและส่งต่อภาพถ่ายโรคผิวหนัง</p>
            </div>
        @endif


        <div class="section-card mb-3">
            <div class="section-header">
                <h2 class="section-title">รายการหลัก</h2>
                <a href="#" class="section-link">{{ $primary_label ?? 'ดำเนินการ' }}</a>
            </div>

            @foreach ($items ?? [] as $item)
                <div class="list-item">
                    <div class="list-icon">
                        <i class="fa-solid fa-circle-dot"></i>
                    </div>
                    <div class="list-body">
                        <p class="list-title">{{ $item['title'] ?? '' }}</p>
                        <p class="list-meta">{{ $item['meta'] ?? '' }}</p>
                    </div>
                    @if (!empty($item['state']))
                        <div class="list-state">
                            <i class="fa-solid fa-circle"></i>
                            {{ $item['state'] }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="page-spacer"></div>
    </div>

    <nav class="bottom-nav" aria-label="เมนูด้านล่าง">
        <div class="bottom-nav-inner">
            <a href="{{ route('home') }}" class="bottom-nav-item {{ request()->routeIs('home') ? 'is-active' : '' }}">
                <span class="bottom-nav-icon"><i class="fa-solid fa-house"></i></span>
                <span>หน้าหลัก</span>
            </a>
            <a href="{{ route('app.upload') }}" class="bottom-nav-item {{ request()->routeIs('app.upload') ? 'is-active' : '' }}">
                <span class="bottom-nav-icon"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                <span>อัปโหลด</span>
            </a>
            <a href="{{ route('app.library') }}" class="bottom-nav-item {{ request()->routeIs('app.library') ? 'is-active' : '' }}">
                <span class="bottom-nav-icon"><i class="fa-regular fa-folder-open"></i></span>
                <span>คลังภาพ</span>
            </a>
            <a href="{{ route('app.consent') }}" class="bottom-nav-item {{ request()->routeIs('app.consent') ? 'is-active' : '' }}">
                <span class="bottom-nav-icon"><i class="fa-solid fa-users"></i></span>
                <span>การแชร์</span>
            </a>
            <a href="{{ route('app.history') }}" class="bottom-nav-item {{ request()->routeIs('app.history') ? 'is-active' : '' }}">
                <span class="bottom-nav-icon"><i class="fa-regular fa-clock"></i></span>
                <span>ประวัติ</span>
            </a>
        </div>
    </nav>
@endsection
