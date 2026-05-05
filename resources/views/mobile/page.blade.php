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

        .page-card {
            border-radius: 22px;
            background: #ffffff;
            border: 1px solid rgba(17, 24, 39, 0.07);
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.04);
            padding: 14px;
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

        .list-item--link {
            color: inherit;
            text-decoration: none;
        }

        .list-item--clickable {
            cursor: pointer;
            transition: background-color 0.15s ease, transform 0.15s ease;
        }

        .list-item--clickable:hover {
            transform: translateY(-1px);
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

        .list-icon--custom {
            background: var(--list-bg, rgba(69, 82, 208, 0.10));
            color: var(--list-color, #4552d0);
        }

        .list-item--stacked {
            align-items: flex-start;
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

        .list-state.is-revoked {
            background: #fff7ed;
            color: #c2410c;
        }

        .list-call {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 10px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
            background: rgba(34, 197, 94, 0.14);
            color: #166534;
            flex: 0 0 auto;
            white-space: nowrap;
        }

        .list-view-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 10px;
            border-radius: 999px;
            border: 1px solid rgba(69, 82, 208, 0.14);
            background: rgba(69, 82, 208, 0.08);
            color: #4552d0;
            font-size: 0.8rem;
            font-weight: 700;
            white-space: nowrap;
            flex: 0 0 auto;
        }

        .lightbox {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.82);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            padding: 16px;
        }

        .lightbox.is-open {
            display: flex;
        }

        .lightbox-panel {
            position: relative;
            width: min(92vw, 520px);
            max-height: 88vh;
            background: #0f172a;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
        }

        .lightbox-image {
            width: 100%;
            max-height: 88vh;
            object-fit: contain;
            display: block;
            background: #fff;
        }

        .lightbox-close {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            border: 0;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.72);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
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
            <button type="button" class="mobile-topbar-back" aria-label="ย้อนกลับ" onclick="window.history.back()">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </button>
            <h1 class="mobile-topbar-title">{{ $page_title ?? 'หน้าหลัก' }}</h1>
            <a href="{{ route('app.notifications') }}" class="mobile-topbar-action text-decoration-none" aria-label="การแจ้งเตือน">
                <i class="fa-regular fa-bell fa-lg"></i>
            </a>
        </div>

        <div class="page-card mb-3">
            @if (request()->routeIs('app.about'))
                <div class="hero-card mb-3">
                    <div class="hero-icon">
                        <img src="{{ asset('assets/images/logo/logo_horizontal_transparent.png') }}" alt="TU SkinSafe">
                    </div>
                    <div class="hero-title">ระบบต้นแบบจัดเก็บและส่งต่อภาพถ่ายโรคผิวหนัง</div>

                </div>
            @endif

            <div class="section-card">
                @foreach ($items ?? [] as $item)
                    @php
                        $isPhoneLink = !empty($item['phone_url']);
                        $isEmailLink = !empty($item['email_url']);
                        $itemTag = $isPhoneLink || $isEmailLink ? 'a' : 'div';
                    @endphp
                    <{{ $itemTag }}
                        class="list-item {{ !empty($item['meta']) && !empty($item['title']) ? 'list-item--stacked' : '' }} {{ !empty($item['image_url']) ? 'list-item--clickable' : '' }} {{ $isPhoneLink || $isEmailLink ? 'list-item--link' : '' }}"
                        @if ($isPhoneLink) href="{{ $item['phone_url'] }}"
                            aria-label="{{ $item['phone_label'] ?? 'โทร' }}"
                        @elseif ($isEmailLink)
                            href="{{ $item['email_url'] }}"
                            aria-label="{{ $item['email_label'] ?? 'ส่งอีเมล' }}" @endif
                        @if (!empty($item['image_url'])) role="button"
                            tabindex="0"
                            data-lightbox-image="{{ $item['image_url'] }}"
                            data-lightbox-alt="{{ $item['image_alt'] ?? ($item['title'] ?? 'image') }}" @endif>
                        <div class="list-icon {{ !empty($item['icon']) ? 'list-icon--custom' : '' }}"
                            @if (!empty($item['bg']) || !empty($item['color'])) style="{{ !empty($item['bg']) ? '--list-bg: ' . $item['bg'] . ';' : '' }}{{ !empty($item['color']) ? ' --list-color: ' . $item['color'] . ';' : '' }}" @endif>
                            <i class="fa-solid {{ $item['icon'] ?? 'fa-circle-dot' }}"></i>
                        </div>
                        <div class="list-body">
                            <p class="list-title">{{ $item['title'] ?? '' }}</p>
                            <p class="list-meta">{{ $item['meta'] ?? '' }}</p>
                        </div>
                        @if ($isPhoneLink)
                            <div class="list-call">
                                <i class="fa-solid fa-phone-volume"></i>
                                {{ $item['phone_label'] ?? 'โทร' }}
                            </div>
                        @elseif ($isEmailLink)
                            <div class="list-call">
                                <i class="fa-solid fa-paper-plane"></i>
                                {{ $item['email_label'] ?? 'ส่งอีเมล' }}
                            </div>
                        @endif
                        @if (!empty($item['state']))
                            <div class="list-state {{ $item['state_class'] ?? '' }}">
                                <i class="fa-solid fa-circle"></i>
                                {{ $item['state'] }}
                            </div>
                        @endif
                        @if (!empty($item['image_url']))
                            <button
                                type="button"
                                class="list-view-btn"
                                data-lightbox-image="{{ $item['image_url'] }}"
                                data-lightbox-alt="{{ $item['image_alt'] ?? ($item['title'] ?? 'image') }}">
                                <i class="fa-regular fa-image"></i>
                                {{-- ดู --}}
                            </button>
                        @endif
                        </{{ $itemTag }}>
                @endforeach
            </div>
        </div>

        <div class="page-spacer"></div>
    </div>

    <div id="lightbox" class="lightbox" aria-hidden="true">
        <div class="lightbox-panel" role="dialog" aria-modal="true" aria-label="ภาพใบรับรอง">
            <button type="button" class="lightbox-close" id="lightboxClose" aria-label="ปิด">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <img id="lightboxImage" class="lightbox-image" alt="">
        </div>
    </div>

    @include('layouts.mobile-nav')

    <script>
        (function() {
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightboxImage');
            const lightboxClose = document.getElementById('lightboxClose');

            const openLightbox = (src, alt) => {
                if (!lightbox || !lightboxImage || !src) return;
                lightboxImage.src = src;
                lightboxImage.alt = alt || 'ภาพ';
                lightbox.classList.add('is-open');
                lightbox.setAttribute('aria-hidden', 'false');
            };

            const closeLightbox = () => {
                if (!lightbox || !lightboxImage) return;
                lightbox.classList.remove('is-open');
                lightbox.setAttribute('aria-hidden', 'true');
                lightboxImage.src = '';
            };

            document.querySelectorAll('[data-lightbox-image]').forEach((item) => {
                const src = item.getAttribute('data-lightbox-image');
                const alt = item.getAttribute('data-lightbox-alt');
                item.addEventListener('click', () => openLightbox(src, alt));
                item.addEventListener('keydown', (event) => {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        openLightbox(src, alt);
                    }
                });
            });

            lightboxClose?.addEventListener('click', closeLightbox);
            lightbox?.addEventListener('click', (event) => {
                if (event.target === lightbox) closeLightbox();
            });
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') closeLightbox();
            });
        })();
    </script>
@endsection
