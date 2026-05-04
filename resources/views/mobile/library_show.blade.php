@extends('layouts.app')
@section('page_title', $page_title ?? 'รายละเอียดรายการภาพ')

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

        .page-card {
            border-radius: 22px;
            background: #ffffff;
            border: 1px solid rgba(17, 24, 39, 0.07);
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.04);
            padding: 14px;
        }

        .hero-record {
            display: grid;
            gap: 12px;
        }

        .hero-record-badges {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            text-align: center;
        }

        .record-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
            background: #eef2ff;
            color: #4552d0;
        }

        .record-badge.is-shared {
            background: #ecfdf3;
            color: #16834d;
        }

        .record-badge.is-warning {
            background: #fff7ed;
            color: #c2410c;
        }

        .record-section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 10px;
        }

        .record-meta-grid {
            display: grid;
            gap: 10px;
        }

        .record-meta-item {
            border-radius: 16px;
            background: #f8faff;
            border: 1px solid rgba(69, 82, 208, 0.10);
            padding: 12px;
        }

        .record-meta-label {
            margin: 0 0 4px;
            font-size: 0.8rem;
            font-weight: 700;
            color: #4552d0;
        }

        .record-meta-value {
            margin: 0;
            color: #1f2937;
            font-size: 0.92rem;
            line-height: 1.6;
            white-space: pre-wrap;
        }

        .record-gallery {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .record-gallery-item {
            display: block;
            aspect-ratio: 1 / 1;
            border-radius: 16px;
            overflow: hidden;
            background: #f3f4f6;
            border: 1px solid rgba(17, 24, 39, 0.06);
            text-decoration: none;
        }

        .record-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .record-actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .record-action {
            min-height: 44px;
            border-radius: 14px;
            border: 1px solid rgba(17, 24, 39, 0.08);
            background: #ffffff;
            color: #1f2937;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.84rem;
            font-weight: 700;
            text-decoration: none;
        }

        .record-action--primary {
            background: #4552d0;
            color: #ffffff;
            border-color: rgba(69, 82, 208, 0.16);
        }

        .record-action--danger {
            color: #b42318;
            border-color: rgba(180, 35, 24, 0.14);
            background: #fff7f5;
        }

        .record-logs {
            border-radius: 16px;
            background: #f8faff;
            border: 1px solid rgba(69, 82, 208, 0.10);
            overflow: hidden;
        }

        .record-logs-header {
            padding: 10px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            border-bottom: 1px solid rgba(69, 82, 208, 0.08);
        }

        .record-logs-title {
            margin: 0;
            font-size: 0.88rem;
            font-weight: 700;
            color: #1f2937;
        }

        .record-log-item {
            padding: 10px 12px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .record-log-item+.record-log-item {
            border-top: 1px solid rgba(69, 82, 208, 0.08);
        }

        .record-log-icon {
            width: 30px;
            height: 30px;
            border-radius: 999px;
            background: rgba(69, 82, 208, 0.10);
            color: #4552d0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
        }

        .record-log-body {
            min-width: 0;
            flex: 1;
        }

        .record-log-title {
            margin: 0 0 2px;
            font-size: 0.84rem;
            font-weight: 700;
            color: #1f2937;
        }

        .record-log-meta {
            margin: 0;
            font-size: 0.78rem;
            color: #6b7280;
            line-height: 1.4;
        }

        .image-modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.92);
            z-index: 3000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .image-modal.is-open {
            display: flex;
        }

        .image-modal-panel {
            width: 100%;
            max-width: 430px;
            height: 100%;
            max-height: 100vh;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .image-modal-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            color: #fff;
        }

        .image-modal-title {
            font-size: 0.95rem;
            font-weight: 700;
            margin: 0;
        }

        .image-modal-actions {
            display: flex;
            gap: 8px;
        }

        .image-modal-btn {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            border: 0;
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .image-modal-stage {
            flex: 1;
            border-radius: 22px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.04);
            display: flex;
            align-items: center;
            justify-content: center;
            touch-action: none;
            user-select: none;
        }

        .image-modal-stage img {
            max-width: none;
            max-height: none;
            transform-origin: center center;
            will-change: transform;
            transition: transform 0.08s linear;
            display: block;
        }

        .image-modal-foot {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.86rem;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    @php
        $paths = is_array($record->paths ?? null) ? $record->paths : [];
        $previewUrl = $record->thumbnail_url ?? (!empty($paths[0]) ? Storage::url($paths[0]) : null);
        $shareStatusLabel = $record->id % 2 === 0 ? 'แชร์แล้ว' : 'ยังไม่แชร์';
        $captureLabel = $record->capture_mode === 'camera' ? 'ถ่ายภาพ' : ($record->capture_mode === 'upload' ? 'อัปโหลดจากเครื่อง' : 'ถ่าย + อัปโหลด');
    @endphp

    <div class="mobile-shell">
        <div class="mobile-topbar">
            <button type="button" class="mobile-topbar-back" aria-label="ย้อนกลับ" onclick="window.history.back()">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </button>
            <h1 class="mobile-topbar-title">{{ $page_title ?? 'รายละเอียดรายการภาพ' }}</h1>
            <a href="{{ route('app.notifications') }}" class="mobile-topbar-action text-decoration-none" aria-label="การแจ้งเตือน">
                <i class="fa-regular fa-bell fa-lg"></i>
            </a>
        </div>

        <div class="page-card mb-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="record-section-title mb-0">ภาพทั้งหมด</div>
                <span class="text-muted small">{{ $record->image_total ?? count($paths) }} ภาพ</span>
            </div>

            @if (!empty($paths))
                <div class="record-gallery">
                    @foreach ($paths as $path)
                        @php $imageUrl = Storage::url($path); @endphp
                        <a href="{{ $imageUrl }}" class="record-gallery-item js-image-open" data-full-src="{{ $imageUrl }}" data-title="{{ $record->symptoms ?? 'ภาพผิวหนัง' }}">
                            <img src="{{ $imageUrl }}" alt="gallery">
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="fa-regular fa-images fa-2x mb-2"></i>
                    <p class="mb-0">ไม่มีภาพประกอบในรายการนี้</p>
                </div>
            @endif
            <div class="hero-record mt-3 ">
                <div class="hero-record-badges text-center">
                    <span class="record-badge {{ $shareStatusLabel === 'แชร์แล้ว' ? 'is-shared' : 'is-warning' }}">
                        <i class="fa-solid fa-share-nodes"></i>
                        {{ $shareStatusLabel }}
                    </span>
                    <span class="record-badge" aria-label="แสดงรายละเอียดวิธีบันทึกภาพ">
                        <i class="fa-solid fa-camera"></i>
                        {{ $captureLabel }}
                    </span>
                    <span class="record-badge">
                        <i class="fa-regular fa-images"></i>
                        {{ $record->image_total ?? count($paths) }} ภาพ
                    </span>
                </div>
            </div>
        </div>

        <div class="page-card mb-3">
            <div class="record-section-title">ข้อมูลรายการนี้</div>
            <div class="record-meta-grid">
                <div class="record-meta-item">
                    <p class="record-meta-label">อาการ / โรค</p>
                    <p class="record-meta-value">{{ $record->symptoms ?? '-' }}</p>
                </div>
                <div class="record-meta-item">
                    <p class="record-meta-label">ตำแหน่งที่ถ่าย</p>
                    <p class="record-meta-value">{{ $record->location ?? '-' }}</p>
                </div>
                <div class="record-meta-item">
                    <p class="record-meta-label">หมายเหตุเพิ่มเติม</p>
                    <p class="record-meta-value">{{ !empty($record->notes) ? $record->notes : '-' }}</p>
                </div>
                <div class="record-meta-item">
                    <p class="record-meta-label">เวลาบันทึก</p>
                    <p class="record-meta-value">{{ $record->created_at_text ?? '-' }}</p>
                </div>
                <div class="record-meta-item">
                    <p class="record-meta-label">เวลาแก้ไขล่าสุด</p>
                    <p class="record-meta-value">{{ $record->updated_at_text ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="page-card mb-3">
            <div class="record-section-title">การดำเนินการ</div>
            <div class="record-actions">
                <a href="#" class="record-action">
                    <i class="fa-solid fa-pen-to-square"></i>
                    แก้ไข
                </a>
                <a href="#" class="record-action record-action--danger">
                    <i class="fa-solid fa-trash"></i>
                    ลบทั้งรายการ
                </a>
            </div>
        </div>

        <div class="page-card">
            <div class="record-logs">
                <div class="record-logs-header">
                    <p class="record-logs-title">Log การเข้าดูรายการนี้ <span class="text-muted small">(Mockup)</span></p>
                </div>
                <div class="record-log-item">
                    <div class="record-log-icon"><i class="fa-solid fa-user"></i></div>
                    <div class="record-log-body">
                        <p class="record-log-title">นพ.วรชัย เข้าดูข้อมูล</p>
                        <p class="record-log-meta">วันนี้ 10:42 น.</p>
                    </div>
                </div>
                <div class="record-log-item">
                    <div class="record-log-icon"><i class="fa-solid fa-user"></i></div>
                    <div class="record-log-body">
                        <p class="record-log-title">พญ.จันทร์ทิพย์ เข้าดูข้อมูล</p>
                        <p class="record-log-meta">วันนี้ 09:18 น.</p>
                    </div>
                </div>
                <div class="record-log-item">
                    <div class="record-log-icon"><i class="fa-solid fa-user"></i></div>
                    <div class="record-log-body">
                        <p class="record-log-title">รศ.นพ.สมชาย เข้าดูข้อมูล</p>
                        <p class="record-log-meta">เมื่อวาน 16:05 น.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.mobile-nav')

    <div id="imageModal" class="image-modal" aria-hidden="true">
        <div class="image-modal-panel">
            <div class="image-modal-toolbar">
                <p id="imageModalTitle" class="image-modal-title">ภาพเต็ม</p>
                <div class="image-modal-actions">
                    <button type="button" id="zoomOutBtn" class="image-modal-btn" aria-label="ย่อภาพ">
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <button type="button" id="zoomResetBtn" class="image-modal-btn" aria-label="รีเซ็ตภาพ">
                        <i class="fa-solid fa-rotate-left"></i>
                    </button>
                    <button type="button" id="zoomInBtn" class="image-modal-btn" aria-label="ขยายภาพ">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <button type="button" id="closeImageModalBtn" class="image-modal-btn" aria-label="ปิดภาพ">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
            <div id="imageModalStage" class="image-modal-stage">
                <img id="imageModalImg" src="" alt="preview">
            </div>
            <div class="image-modal-foot">เลื่อนเมาส์หรือใช้ปุ่ม +/- เพื่อซูมภาพ</div>
        </div>
    </div>

    <script>
        (function() {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('imageModalImg');
            const modalTitle = document.getElementById('imageModalTitle');
            const stage = document.getElementById('imageModalStage');
            const closeBtn = document.getElementById('closeImageModalBtn');
            const zoomInBtn = document.getElementById('zoomInBtn');
            const zoomOutBtn = document.getElementById('zoomOutBtn');
            const zoomResetBtn = document.getElementById('zoomResetBtn');
            const triggers = document.querySelectorAll('.js-image-open');
            let scale = 1;
            let translateX = 0;
            let translateY = 0;

            const applyTransform = () => {
                modalImg.style.transform = `translate(${translateX}px, ${translateY}px) scale(${scale})`;
            };

            const resetTransform = () => {
                scale = 1;
                translateX = 0;
                translateY = 0;
                applyTransform();
            };

            const openModal = (src, title) => {
                modalImg.src = src;
                modalTitle.textContent = title || 'ภาพเต็ม';
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
                resetTransform();
                document.body.style.overflow = 'hidden';
            };

            const closeModal = () => {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
                modalImg.src = '';
            };

            triggers.forEach((trigger) => {
                trigger.addEventListener('click', (event) => {
                    event.preventDefault();
                    openModal(trigger.dataset.fullSrc || trigger.getAttribute('href'), trigger.dataset.title);
                });
            });

            closeBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });

            zoomInBtn.addEventListener('click', () => {
                scale = Math.min(scale + 0.25, 4);
                applyTransform();
            });

            zoomOutBtn.addEventListener('click', () => {
                scale = Math.max(scale - 0.25, 1);
                if (scale === 1) {
                    translateX = 0;
                    translateY = 0;
                }
                applyTransform();
            });

            zoomResetBtn.addEventListener('click', resetTransform);

            modal.addEventListener('wheel', (event) => {
                if (!modal.classList.contains('is-open')) return;
                event.preventDefault();
                scale = event.deltaY < 0 ? Math.min(scale + 0.12, 4) : Math.max(scale - 0.12, 1);
                if (scale === 1) {
                    translateX = 0;
                    translateY = 0;
                }
                applyTransform();
            }, {
                passive: false
            });

            let startX = 0;
            let startY = 0;
            let dragging = false;

            stage.addEventListener('pointerdown', (event) => {
                if (scale <= 1) return;
                dragging = true;
                startX = event.clientX - translateX;
                startY = event.clientY - translateY;
                stage.setPointerCapture(event.pointerId);
            });

            stage.addEventListener('pointermove', (event) => {
                if (!dragging) return;
                translateX = event.clientX - startX;
                translateY = event.clientY - startY;
                applyTransform();
            });

            stage.addEventListener('pointerup', () => {
                dragging = false;
            });

            window.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && modal.classList.contains('is-open')) {
                    closeModal();
                }
            });
        })();
    </script>
@endsection
