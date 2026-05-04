@extends('layouts.app')
@section('page_title', $page_title ?? 'คลังภาพของฉัน')

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

        .section-title {
            font-size: 1.02rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 10px;
        }

        .record-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .summary-chip {
            border-radius: 18px;
            padding: 12px 10px;
            background: #f8faff;
            border: 1px solid rgba(69, 82, 208, 0.10);
            text-align: center;
        }

        .summary-chip strong {
            display: block;
            font-size: 1rem;
            color: #1f2937;
        }

        .summary-chip span {
            display: block;
            margin-top: 3px;
            font-size: 0.82rem;
            color: #6b7280;
        }

        .record-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .record-card {
            border-radius: 20px;
            background: #ffffff;
            border: 1px solid rgba(17, 24, 39, 0.07);
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.04);
            overflow: hidden;
        }

        .record-card-top {
            padding: 14px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .record-thumb {
            width: 84px;
            height: 84px;
            border-radius: 16px;
            overflow: hidden;
            flex: 0 0 auto;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .record-thumb.is-clickable,
        .record-gallery-item.is-clickable {
            cursor: zoom-in;
        }

        .record-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .record-copy {
            min-width: 0;
            flex: 1;
        }

        .record-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 4px;
            line-height: 1.35;
        }

        .record-meta {
            font-size: 0.86rem;
            color: #6b7280;
            margin: 0 0 4px;
        }

        .record-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 8px;
        }

        .record-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
            background: #eef2ff;
            color: #4552d0;
        }

        .record-gallery {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 6px;
            padding: 0 14px 14px;
        }

        .record-gallery-item {
            display: block;
            border-radius: 12px;
            overflow: hidden;
            aspect-ratio: 1 / 1;
            background: #f3f4f6;
            text-decoration: none;
        }

        .record-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .empty-state {
            text-align: center;
            padding: 26px 14px;
        }

        .empty-state i {
            font-size: 2rem;
            color: #9ca3af;
            margin-bottom: 10px;
        }

        .empty-state p {
            margin: 0;
            color: #6b7280;
            font-size: 0.92rem;
            line-height: 1.5;
        }

        .empty-state .btn {
            margin-top: 12px;
            min-height: 44px;
            border-radius: 14px;
            font-weight: 700;
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
    <div class="mobile-shell">
        <div class="mobile-topbar">
            <button type="button" class="mobile-topbar-back" aria-label="ย้อนกลับ" onclick="window.history.back()">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </button>
            <h1 class="mobile-topbar-title">{{ $page_title ?? 'คลังภาพของฉัน' }}</h1>
            <a href="{{ route('app.notifications') }}" class="mobile-topbar-action text-decoration-none" aria-label="การแจ้งเตือน">
                <i class="fa-regular fa-bell fa-lg"></i>
            </a>
        </div>

        <div class="page-card mb-3">
            <div class="section-title">สรุปข้อมูลล่าสุด</div>
            <div class="record-summary">
                <div class="summary-chip">
                    <strong>{{ $records->count() }}</strong>
                    <span>รายการ</span>
                </div>
                <div class="summary-chip">
                    <strong>{{ $records->sum('image_total') }}</strong>
                    <span>ภาพทั้งหมด</span>
                </div>
                <div class="summary-chip">
                    <strong>{{ optional($records->first())->created_at_text ?? '-' }}</strong>
                    <span>รายการล่าสุด</span>
                </div>
            </div>
        </div>

        <div class="page-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="section-title mb-0">รายการที่บันทึกแล้ว</div>
                <a href="{{ route('app.upload') }}" class="section-link text-decoration-none" style="font-size: .92rem; color:#4169e1; font-weight:600;">ถ่าย/อัปโหลดภาพ</a>
            </div>

            @if ($records->isEmpty())
                <div class="empty-state">
                    <i class="fa-regular fa-images"></i>
                    <p>ยังไม่มีภาพที่บันทึกไว้</p>
                    <a href="{{ route('app.upload') }}" class="btn btn-primary px-4">ไปถ่าย/อัปโหลดภาพ</a>
                </div>
            @else
                <div class="record-list">
                    @foreach ($records as $record)
                        <div class="record-card">
                            <div class="record-card-top">
                                @php
                                    $previewGroup = 'record-' . $record->id;
                                    $previewUrl = $record->thumbnail_url ?? (!empty($record->paths[0]) ? Storage::url($record->paths[0]) : null);
                                @endphp
                                @if (!empty($previewUrl))
                                    <a href="{{ $previewUrl }}" class="record-thumb is-clickable js-image-open" data-full-src="{{ $previewUrl }}" data-title="{{ $record->symptoms ?? 'ภาพผิวหนัง' }}">
                                        <img src="{{ $previewUrl }}" alt="record-thumb">
                                    </a>
                                @else
                                    <div class="record-thumb">
                                        <i class="fa-regular fa-image text-muted"></i>
                                    </div>
                                @endif

                                <div class="record-copy">
                                    <p class="record-title">{{ $record->symptoms ?? '-' }}</p>
                                    <p class="record-meta">ตำแหน่ง: {{ $record->location ?? '-' }}</p>
                                    <p class="record-meta">บันทึกเมื่อ: {{ $record->created_at_text ?? '-' }}</p>
                                    @if (!empty($record->notes))
                                        <p class="record-meta">หมายเหตุ: {{ $record->notes }}</p>
                                    @endif

                                    <div class="record-badges">
                                        <span class="record-badge">
                                            <i class="fa-solid fa-camera"></i>
                                            {{ $record->capture_mode === 'camera' ? 'ถ่ายภาพ' : ($record->capture_mode === 'upload' ? 'อัปโหลดจากเครื่อง' : 'ถ่าย + อัปโหลด') }}
                                        </span>
                                        <span class="record-badge">
                                            <i class="fa-regular fa-images"></i>
                                            {{ $record->image_total ?? 0 }} ภาพ
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @if (!empty($record->paths) && is_array($record->paths))
                                <div class="record-gallery">
                                    @foreach (array_slice($record->paths, 0, 4) as $path)
                                        @php $imageUrl = Storage::url($path); @endphp
                                        <a href="{{ $imageUrl }}" class="record-gallery-item is-clickable js-image-open" data-full-src="{{ $imageUrl }}" data-title="{{ $record->symptoms ?? 'ภาพผิวหนัง' }}">
                                            <img src="{{ $imageUrl }}" alt="gallery">
                                        </a>
                                    @endforeach
                                    @if (($record->image_total ?? 0) > 4)
                                        <div class="record-gallery-item d-flex align-items-center justify-content-center bg-light text-muted fw-semibold">
                                            +{{ $record->image_total - 4 }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
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
            }, { passive: false });

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
