@extends('layouts.app')
@section('page_title', $page_title ?? 'แนะนำภาพรวมของระบบต้นแบบ')

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
            font-size: 1.05rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .mobile-topbar-action,
        .mobile-topbar-back {
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

        .video-card {
            border-radius: 22px;
            background: #ffffff;
            border: 1px solid rgba(17, 24, 39, 0.07);
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.04);
            overflow: hidden;
        }

        .video-header {
            padding: 14px 14px 0;
        }

        .video-title {
            font-size: 1.02rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 4px;
        }

        .video-subtitle {
            font-size: 0.88rem;
            color: #6b7280;
            margin: 0 0 12px;
            line-height: 1.45;
        }

        .video-frame {
            padding: 0 14px 14px;
        }

        .video-frame-inner {
            border-radius: 18px;
            overflow: hidden;
            background: #0b1020;
            aspect-ratio: 4 / 5;
        }

        .video-frame-inner video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .video-actions {
            margin-top: 12px;
            padding: 0 14px 14px;
        }

        .video-button {
            width: 100%;
            min-height: 48px;
            border-radius: 16px;
            border: 1px solid transparent;
            font-size: 0.96rem;
            font-weight: 700;
            background: #4552d0;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .video-button--done {
            background: #f0fdf4;
            color: #166534;
            border-color: rgba(34, 197, 94, 0.18);
        }

        .video-note {
            margin-top: 12px;
            padding: 12px 14px;
            border-radius: 16px;
            background: #f8faff;
            border: 1px solid rgba(76, 89, 255, 0.08);
            color: #4b5563;
            font-size: 0.88rem;
            line-height: 1.45;
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
        }
    </style>
@endsection

@section('content')
    <div class="mobile-shell">
        <div class="mobile-topbar">
            <button type="button" class="mobile-topbar-back" aria-label="ย้อนกลับ" onclick="window.history.back()">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </button>
            <h1 class="mobile-topbar-title">{{ $page_title ?? 'แนะนำภาพรวมของระบบต้นแบบ' }}</h1>
            <a href="{{ route('app.notifications') }}" class="mobile-topbar-action text-decoration-none" aria-label="การแจ้งเตือน">
                <i class="fa-regular fa-bell fa-lg"></i>
            </a>
        </div>

        <div class="video-card">
            <div class="video-header">
                <p class="video-title">{{ $page_subtitle ?? 'แนะนำภาพรวมของระบบต้นแบบและฟังก์ชันพื้นฐาน' }}</p>
                <p class="video-subtitle">
                    VDO ความยาว 1 นาที
                    <span class="fw-semibold text-dark   mt-1">
                        จบแล้วกดปุ่ม "รับทราบแล้ว" เพื่อบันทึกสถานะภารกิจนี้
                    </span>
                </p>
            </div>

            <div class="video-frame">
                <div class="video-frame-inner">
                    <video controls playsinline preload="metadata">
                        <source src="{{ $video_url }}" type="video/mp4">
                    </video>
                </div>
            </div>

            <div class="video-actions">
                @if (!empty($overview_completed))
                    <div class="video-button video-button--done">
                        <i class="fa-solid fa-circle-check"></i>
                        ทำแล้ว
                    </div>
                @else
                    <form action="{{ route('app.system_overview.complete') }}" method="post" class="m-0">
                        @csrf
                        <button type="submit" class="video-button">
                            <i class="fa-solid fa-check"></i>
                            รับทราบแล้ว
                        </button>
                    </form>
                @endif

                <div class="video-note">
                    เมื่อรับทราบแล้ว ระบบจะบันทึกสถานะภารกิจนี้ และจะเปลี่ยนเป็นสีเขียวบนหน้าหลักของผู้เข้าร่วม
                </div>
            </div>
        </div>
    </div>

    <nav class="bottom-nav" aria-label="เมนูด้านล่าง">
        <div class="bottom-nav-inner">
            <a href="{{ route('home') }}" class="bottom-nav-item {{ request()->routeIs('home') ? 'is-active' : '' }}">
                <span class="bottom-nav-icon"><i class="fa-solid fa-house"></i></span>
                <span>หน้าหลัก</span>
            </a>
            <a href="{{ route('app.upload') }}" class="bottom-nav-item {{ request()->routeIs('app.upload') ? 'is-active' : '' }}">
                <span class="bottom-nav-icon"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                <span>ถ่าย/อัปโหลดภาพ</span>
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
