@extends('layouts.app')
@section('page_title', 'หน้าหลัก')

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
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .mobile-topbar-title {
            flex: 1;
            text-align: center;
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: 0;
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
            font-size: 1.0rem;
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

        .profile-card {
            position: relative;
            border-radius: 22px;
            background: #ffffff;
            border: 1px solid rgba(17, 24, 39, 0.07);
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.04);
            padding: 12px 46px 12px 14px;
        }

        .profile-card--link {
            display: block;
            color: inherit;
            text-decoration: none;
            transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
        }

        .profile-card--link:hover {
            color: inherit;
            transform: translateY(-1px);
            box-shadow: 0 10px 26px rgba(17, 24, 39, 0.06);
            border-color: rgba(69, 82, 208, 0.18);
        }

        .profile-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 0;
        }

        .profile-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(69, 82, 208, 0.12);
            color: #4552d0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex: 0 0 auto;
        }

        .profile-copy {
            min-width: 0;
            flex: 1;
        }

        .profile-label {
            font-size: 1.02rem;
            font-weight: 700;
            color: #4552d0;
            margin: 0 0 2px;
        }

        .profile-name {
            font-size: 1.02rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            line-height: 1.35;
        }

        .profile-meta {
            font-size: 0.88rem;
            color: #6b7280;
            margin: 2px 0 0;
            line-height: 1.4;
            word-break: break-word;
        }

        .profile-summary-icon {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 48px;
            height: 48px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #4552d0;
            flex: 0 0 auto;
            background: rgba(69, 82, 208, 0.10);
        }

        .profile-summary-icon i {
            font-size: 0.95rem;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .menu-card {
            min-height: 162px;
            border-radius: 24px;
            background: #ffffff;
            border: 1px solid rgba(17, 24, 39, 0.07);
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.05);
            padding: 18px 14px 16px;
            text-align: center;
            color: inherit;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .menu-card:hover {
            color: inherit;
        }

        .menu-icon-wrap {
            width: 66px;
            height: 66px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
        }

        .menu-title {
            font-size: 1.08rem;
            font-weight: 600;
            line-height: 1.35;
            color: #1f2937;
            margin: 0;
        }

        .menu-card--full {
            grid-column: 1 / -1;
            min-height: 84px;
            padding: 16px 18px;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            text-align: left;
        }

        .menu-card--full .menu-copy {
            flex: 1;
        }

        .menu-card--full .menu-title {
            font-size: 1.08rem;
            margin-bottom: 4px;
        }

        .menu-card--full .menu-lead {
            margin: 0;
            color: #6b7280;
            font-size: 0.92rem;
        }

        .section-card {
            border-radius: 22px;
            background: #ffffff;
            border: 1px solid rgba(17, 24, 39, 0.07);
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.04);
            padding: 16px 14px 10px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 1.08rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .section-link {
            font-size: 0.95rem;
            color: #4169e1;
            text-decoration: none;
            font-weight: 600;
            flex: 0 0 auto;
        }

        .notice-item,
        .share-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 0;
        }

        .notice-item+.notice-item,
        .share-item+.share-item {
            border-top: 1px solid rgba(17, 24, 39, 0.06);
        }

        .notice-badge,
        .share-badge {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
        }

        .notice-body,
        .share-body {
            min-width: 0;
            flex: 1;
        }

        .notice-title,
        .share-title {
            font-size: 0.98rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 4px;
            line-height: 1.35;
        }

        .notice-meta,
        .share-meta {
            font-size: 0.88rem;
            color: #6b7280;
            margin: 0;
        }

        .share-state {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.82rem;
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

        .bottom-nav-item.is-active .bottom-nav-icon {
            background: rgba(69, 82, 208, 0.12);
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

        .page-spacer {
            height: 12px;
        }

        @media (min-width: 768px) {
            .mobile-shell {
                border-left: 1px solid rgba(17, 24, 39, 0.06);
                border-right: 1px solid rgba(17, 24, 39, 0.06);
            }
        }

        @media (max-width: 767.98px) {

            .iq-navbar-header,
            .iq-navbar-header .iq-header-img,
            .iq-navbar-header .iq-header-img img {
                height: 140px !important;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $quickMenus = [
            [
                'title' => 'อัปโหลดภาพ',
                'icon' => 'fa-cloud-arrow-up',
                'color' => '#4459dd',
                'bg' => 'rgba(69, 89, 221, 0.10)',
                'url' => route('app.upload'),
            ],
            [
                'title' => 'คลังภาพของฉัน',
                'icon' => 'fa-folder-open',
                'color' => '#3f7d3f',
                'bg' => 'rgba(145, 214, 121, 0.20)',
                'url' => route('app.library'),
            ],
            [
                'title' => 'การยินยอมและการแชร์ข้อมูล',
                'icon' => 'fa-user-group',
                'color' => '#f07a1d',
                'bg' => 'rgba(247, 190, 137, 0.24)',
                'url' => route('app.consent'),
            ],
            [
                'title' => 'สิทธิ์การเข้าถึงข้อมูล',
                'icon' => 'fa-lock',
                'color' => '#7d52dd',
                'bg' => 'rgba(169, 134, 240, 0.20)',
                'url' => route('app.access'),
            ],
            [
                'title' => 'ประวัติการเข้าถึงและการแจ้งเตือน',
                'icon' => 'fa-clock',
                'color' => '#e54f8a',
                'bg' => 'rgba(243, 153, 184, 0.24)',
                'url' => route('app.history'),
            ],
            [
                'title' => 'เกี่ยวกับผู้ทำวิจัย',
                'icon' => 'fa-circle-info',
                'color' => '#1c8ea0',
                'bg' => 'rgba(150, 223, 228, 0.24)',
                'url' => route('app.about'),
            ],
        ];

        $consentCard = [
            'title' => 'แบบฟอร์มยืนยัน/ยอมรับการเข้าร่วม',
            'icon' => 'fa-circle-user',
            'lead' => 'อ่านคำชี้แจงและยืนยันก่อนเข้าร่วมวิจัย',
            'url' => route('app.consent'),
        ];

        $notifications = [
            [
                'title' => 'นพ.วรชัย เข้าดูข้อมูลของคุณ',
                'meta' => '10 นาทีที่แล้ว',
                'icon' => 'fa-user-doctor',
                'color' => '#3d4bd8',
                'bg' => 'rgba(61, 75, 216, 0.12)',
            ],
            [
                'title' => 'พญ.จันทร์ทิพย์ ขอแชร์ข้อมูล',
                'meta' => '1 ชั่วโมงที่แล้ว',
                'icon' => 'fa-share-from-square',
                'color' => '#f08a24',
                'bg' => 'rgba(240, 138, 36, 0.14)',
            ],
            [
                'title' => 'การยินยอมการแชร์จะหมดอายุในอีก 7 วัน',
                'meta' => '2 ชั่วโมงที่แล้ว',
                'icon' => 'fa-triangle-exclamation',
                'color' => '#c07a11',
                'bg' => 'rgba(255, 200, 87, 0.20)',
            ],
        ];

        $shareStatus = [
            [
                'title' => 'นพ.วรชัย แพทย์ผิวหนัง',
                'meta' => 'แชร์เมื่อ 12 พ.ค. 2567',
                'state' => 'กำลังแชร์',
            ],
            [
                'title' => 'พญ.จันทร์ทิพย์ ผิวหนัง',
                'meta' => 'แชร์เมื่อ 10 พ.ค. 2567',
                'state' => 'กำลังแชร์',
            ],
            [
                'title' => 'รศ.นพ.สมชาย ศัลยกรรมผิวหนัง',
                'meta' => 'แชร์เมื่อ 08 พ.ค. 2567',
                'state' => 'กำลังแชร์',
            ],
        ];
    @endphp

    <div class="mobile-shell">
        <div class="mobile-topbar">
            <div style="width:42px;"></div>
            <h1 class="mobile-topbar-title">หน้าหลัก</h1>
            <a href="{{ route('app.notifications') }}" class="mobile-topbar-action text-decoration-none" aria-label="การแจ้งเตือน">
                <i class="fa-regular fa-bell fa-lg"></i>
            </a>
        </div>

        <div class="hero-card mb-3">
            <div class="hero-icon">
                <img src="{{ asset('assets/images/logo/logo_horizontal_transparent.png') }}" alt="TU SkinSafe">
            </div>
            <div class="hero-title">ระบบต้นแบบจัดเก็บและส่งต่อภาพถ่ายโรคผิวหนัง</div>
            {{-- <p class="hero-subtitle"></p> --}}
        </div>

        @php
            $currentUser = auth()->user();
        @endphp

        <a href="{{ route('app.status') }}" class="profile-card profile-card--link mb-3">
            <span class="profile-summary-icon" aria-hidden="true">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <div class="profile-card-header">
                <div class="profile-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="profile-copy">
                    <span class="profile-label">สวัสดี </span> <span class="profile-name">คุณ{{ $currentUser->name ?? 'ผู้ใช้งาน' }}</span>
                    <p class="profile-meta">
                        ขอบคุณสำหรับการเข้าร่วมการวิจัยครั้งนี้
                    </p>
                </div>
            </div>
        </a>

        <div class="menu-grid mb-3">
            @foreach ($quickMenus as $menu)
                <a href="{{ $menu['url'] }}" class="menu-card {{ $menu['full'] ?? false ? 'menu-card--full' : '' }}">
                    <div class="menu-icon-wrap" style="background: {{ $menu['bg'] }}; color: {{ $menu['color'] }}">
                        <i class="fa-solid {{ $menu['icon'] }}"></i>
                    </div>
                    <div class="menu-copy">
                        <p class="menu-title">{{ $menu['title'] }}</p>
                        @if (!empty($menu['lead']))
                            <p class="menu-lead">{{ $menu['lead'] }}</p>
                        @endif
                    </div>
                    @if (($menu['full'] ?? false) === true)
                        <i class="fa-solid fa-chevron-right text-muted fs-5"></i>
                    @endif
                </a>
            @endforeach
        </div>

        <a href="{{ $consentCard['url'] }}" class="menu-card menu-card--full mb-3">
            <div class="menu-icon-wrap" style="background: rgba(84, 113, 255, 0.10); color: #4552d0">
                <i class="fa-solid {{ $consentCard['icon'] }}"></i>
            </div>
            <div class="menu-copy">
                <p class="menu-title">{{ $consentCard['title'] }}</p>
                <p class="menu-lead">{{ $consentCard['lead'] }}</p>
            </div>
            <i class="fa-solid fa-chevron-right text-muted fs-5"></i>
        </a>

        <div class="section-card mb-2">
            <div class="section-header">
                <h2 class="section-title">การแจ้งเตือน</h2>
                <a href="{{ route('app.notifications') }}" class="section-link">ดูทั้งหมด</a>
            </div>

            @foreach ($notifications as $notification)
                <div class="notice-item">
                    <div class="notice-badge" style="background: {{ $notification['bg'] }}; color: {{ $notification['color'] }}">
                        <i class="fa-solid {{ $notification['icon'] }}"></i>
                    </div>
                    <div class="notice-body">
                        <p class="notice-title">{{ $notification['title'] }}</p>
                        <p class="notice-meta">{{ $notification['meta'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="section-card mb-3">
            <div class="section-header">
                <h2 class="section-title">สถานะการแชร์ข้อมูลล่าสุด</h2>
                <a href="{{ route('app.shares') }}" class="section-link">ดูทั้งหมด</a>
            </div>

            @foreach ($shareStatus as $share)
                <div class="share-item">
                    <div class="share-badge" style="background: rgba(77, 87, 217, 0.10); color: #4552d0">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="share-body">
                        <p class="share-title">{{ $share['title'] }}</p>
                        <p class="share-meta">{{ $share['meta'] }}</p>
                    </div>
                    <div class="share-state">
                        <i class="fa-solid fa-circle"></i>
                        {{ $share['state'] }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="page-spacer"></div>
    </div>

    <nav class="bottom-nav" aria-label="เมนูด้านล่าง">
        <div class="bottom-nav-inner">
            <a href="{{ route('home') }}" class="bottom-nav-item is-active">
                <span class="bottom-nav-icon"><i class="fa-solid fa-house"></i></span>
                <span>หน้าหลัก</span>
            </a>
            <a href="{{ route('app.upload') }}" class="bottom-nav-item">
                <span class="bottom-nav-icon"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                <span>อัปโหลด</span>
            </a>
            <a href="{{ route('app.library') }}" class="bottom-nav-item">
                <span class="bottom-nav-icon"><i class="fa-regular fa-folder-open"></i></span>
                <span>คลังภาพ</span>
            </a>
            <a href="{{ route('app.consent') }}" class="bottom-nav-item">
                <span class="bottom-nav-icon"><i class="fa-solid fa-users"></i></span>
                <span>การแชร์</span>
            </a>
            <a href="{{ route('app.history') }}" class="bottom-nav-item">
                <span class="bottom-nav-icon"><i class="fa-regular fa-clock"></i></span>
                <span>ประวัติ</span>
            </a>
        </div>
    </nav>
@endsection
