@extends('layouts.app')
@section('page_title', $page_title ?? 'ถ่าย/อัปโหลดภาพ')

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

        .upload-chooser {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .upload-action {
            min-height: 112px;
            border-radius: 18px;
            border: 1px solid rgba(69, 82, 208, 0.14);
            background: linear-gradient(180deg, #f8faff 0%, #eef2ff 100%);
            color: #4552d0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 700;
        }

        .upload-action i {
            font-size: 1.45rem;
        }

        .shoot-tip-btn {
            display: none;
            width: 100%;
            min-height: 42px;
            border-radius: 14px;
            border: 1px solid rgba(69, 82, 208, 0.16);
            background: rgba(69, 82, 208, 0.06);
            color: #4552d0;
            font-weight: 700;
            gap: 8px;
        }

        .shoot-tip-btn.is-open {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .camera-box {
            margin-top: 12px;
            border-radius: 18px;
            overflow: hidden;
            background: #0b1020;
            aspect-ratio: 4 / 5;
            display: none;
            position: relative;
        }

        .camera-box.is-open {
            display: block;
        }

        .camera-box video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .camera-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
            padding: 14px;
        }

        .camera-overlay-top {
            display: none;
            align-items: flex-start;
            justify-content: center;
        }

        .camera-overlay-top.is-open {
            display: flex;
        }

        .camera-overlay-top .camera-top-tip {
            pointer-events: none;
            max-width: 92%;
            margin: 0;
            padding: 8px 10px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(255, 255, 255, 0.28);
            color: #1f2937;
            font-size: 0.82rem;
            line-height: 1.4;
            font-weight: 700;
            text-align: center;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.14);
        }

        .camera-overlay-center {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 14px;
        }

        .camera-guide {
            position: relative;
            width: 82%;
            aspect-ratio: 4 / 5;
            border-radius: 18px;
            border: 2px solid rgba(255, 255, 255, 0.88);
            box-shadow:
                0 0 0 999px rgba(0, 0, 0, 0.12),
                inset 0 0 0 1px rgba(255, 255, 255, 0.16);
        }

        .camera-guide::before,
        .camera-guide::after {
            content: "";
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.35);
        }

        .camera-guide::before {
            top: 0;
            bottom: 0;
            width: 1px;
        }

        .camera-guide::after {
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            transform: translateY(-50%);
        }

        .camera-hint {
            position: absolute;
            left: 12px;
            right: 12px;
            bottom: 12px;
            text-align: center;
            font-size: 0.88rem;
            line-height: 1.45;
            color: #111827;
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(17, 24, 39, 0.10);
            padding: 9px 10px;
            border-radius: 14px;
            z-index: 2;
            font-weight: 700;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.18);
        }

        .camera-hint.is-good {
            color: #166534;
            background: rgba(220, 252, 231, 0.98);
            border-color: rgba(34, 197, 94, 0.28);
        }

        .camera-hint.is-dim {
            color: #1d4ed8;
            background: rgba(219, 234, 254, 0.98);
            border-color: rgba(59, 130, 246, 0.28);
        }

        .camera-hint.is-bright {
            color: #c2410c;
            background: rgba(254, 243, 199, 0.98);
            border-color: rgba(249, 115, 22, 0.28);
        }

        .camera-close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 38px;
            height: 38px;
            border-radius: 999px;
            border: 0;
            background: rgba(15, 23, 42, 0.72);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.2);
        }

        .camera-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            display: none;
        }

        .camera-actions.is-open {
            display: flex;
        }

        .camera-actions .btn {
            flex: 1;
            min-height: 44px;
            border-radius: 14px;
            font-weight: 700;
        }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
        }

        .preview-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .preview-image-wrap {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            aspect-ratio: 1 / 1;
            background: #eef2ff;
            border: 1px solid rgba(69, 82, 208, 0.12);
        }

        .preview-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .preview-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 28px;
            border-radius: 999px;
            font-size: 0.76rem;
            font-weight: 700;
            padding: 4px 8px;
            border: 1px solid transparent;
        }

        .preview-status.is-good {
            color: #166534;
            background: rgba(220, 252, 231, 0.98);
            border-color: rgba(34, 197, 94, 0.24);
        }

        .preview-status.is-dim {
            color: #1d4ed8;
            background: rgba(219, 234, 254, 0.98);
            border-color: rgba(59, 130, 246, 0.24);
        }

        .preview-status.is-bright {
            color: #c2410c;
            background: rgba(254, 243, 199, 0.98);
            border-color: rgba(249, 115, 22, 0.24);
        }

        .preview-status.is-loading {
            color: #6b7280;
            background: rgba(248, 250, 252, 0.98);
            border-color: rgba(148, 163, 184, 0.22);
        }

        .preview-remove {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 26px;
            height: 26px;
            border-radius: 999px;
            border: 0;
            background: rgba(17, 24, 39, 0.72);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .form-label {
            font-size: 0.92rem;
            font-weight: 700;
            color: #1f2937;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            min-height: 46px;
        }

        textarea.form-control {
            min-height: 110px;
        }

        .save-button {
            width: 100%;
            min-height: 50px;
            border-radius: 16px;
            border: 0;
            background: linear-gradient(180deg, #2f7d32 0%, #1f6f22 100%);
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
        }

        .save-button:disabled {
            opacity: 0.7;
        }

        .hint {
            margin-top: 10px;
            padding: 10px 12px;
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
        }
    </style>
@endsection

@section('content')
    <div class="mobile-shell">
        <div class="mobile-topbar">
            <button type="button" class="mobile-topbar-back" aria-label="ย้อนกลับ" onclick="window.history.back()">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </button>
            <h1 class="mobile-topbar-title">{{ $page_title ?? 'ถ่าย/อัปโหลดภาพ' }}</h1>
            <a href="{{ route('app.notifications') }}" class="mobile-topbar-action text-decoration-none" aria-label="การแจ้งเตือน">
                <i class="fa-regular fa-bell fa-lg"></i>
            </a>
        </div>

        <form id="skinUploadForm" class="page-card">
            @csrf
            <input type="file" id="uploadFileInput" accept="image/*" multiple hidden>

            <div class="section-title">เพิ่มภาพใหม่</div>

            <div class="upload-chooser mb-3">
                <button type="button" id="openCameraBtn" class="upload-action">
                    <i class="fa-solid fa-camera-retro"></i>
                    <span>ถ่ายภาพ</span>
                </button>
                <button type="button" id="openUploadBtn" class="upload-action">
                    <i class="fa-regular fa-images"></i>
                    <span>อัปโหลดจากเครื่อง</span>
                </button>
            </div>

            <button type="button" id="shootTipBtn" class="shoot-tip-btn mb-3">
                <i class="fa-solid fa-circle-info"></i>
                คำแนะนำการถ่ายภาพ
            </button>

            <div id="cameraBox" class="camera-box mb-3">
                <video id="cameraVideo" autoplay playsinline muted></video>
                <button type="button" id="cameraCloseOverlayBtn" class="camera-close-btn" aria-label="ปิดกล้อง">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div id="cameraOverlayTop" class="camera-overlay camera-overlay-top">
                    <div class="camera-top-tip">
                        จัดภาพให้รอยโรคอยู่กลางกรอบ และเว้นระยะพอดีก่อนถ่าย
                    </div>
                </div>
                <div class="camera-overlay camera-overlay-center">
                    <div class="camera-guide"></div>
                </div>
                <div id="cameraHint" class="camera-hint">พร้อมใช้งาน</div>
            </div>
            <div id="cameraActions" class="camera-actions mb-3">
                <button type="button" id="captureBtn" class="btn btn-primary" disabled>
                    <i class="fa-solid fa-circle-dot me-1"></i>
                    ถ่ายภาพ
                </button>
            </div>

            <div class="mb-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="section-title mb-0">Preview ภาพ</div>
                    <span class="text-muted small" id="imageCountText">0 ภาพ</span>
                </div>
                <div id="previewGrid" class="preview-grid"></div>
                {{-- <div class="hint">รองรับการถ่ายหลายภาพจากกล้องในหน้าเว็บ และอัปโหลดหลายภาพจากเครื่องได้พร้อมกัน</div> --}}
            </div>

            <div class="mb-3">
                <label class="form-label" for="symptoms">อาการ / โรค <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="symptoms" name="symptoms" placeholder="เช่น ผื่นแดง คัน เจ็บ" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="location">ตำแหน่งที่ถ่าย <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="location" name="location" placeholder="เช่น แขนซ้าย หน้าอก หลังหู" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="notes">หมายเหตุเพิ่มเติม</label>
                <textarea class="form-control" id="notes" name="notes" placeholder="หมายเหตุอื่น ๆ (ถ้ามี)"></textarea>
            </div>

            <button type="submit" id="submitUploadBtn" class="save-button">
                บันทึก
            </button>
        </form>
    </div>

    @include('layouts.mobile-nav')

    <script>
        (function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const form = document.getElementById('skinUploadForm');
            const openCameraBtn = document.getElementById('openCameraBtn');
            const openUploadBtn = document.getElementById('openUploadBtn');
            const shootTipBtn = document.getElementById('shootTipBtn');
            const uploadFileInput = document.getElementById('uploadFileInput');
            const cameraBox = document.getElementById('cameraBox');
            const cameraVideo = document.getElementById('cameraVideo');
            const cameraCloseOverlayBtn = document.getElementById('cameraCloseOverlayBtn');
            const cameraOverlayTop = document.getElementById('cameraOverlayTop');
            const cameraActions = document.getElementById('cameraActions');
            const captureBtn = document.getElementById('captureBtn');
            const cameraHint = document.getElementById('cameraHint');
            const previewGrid = document.getElementById('previewGrid');
            const imageCountText = document.getElementById('imageCountText');
            const submitBtn = document.getElementById('submitUploadBtn');
            const targetAspect = 4 / 5;

            let cameraStream = null;
            let mode = null;
            let capturedFiles = [];
            let audioContext = null;
            let brightnessTimer = null;

            const syncMode = (incomingMode) => {
                if (!mode) {
                    mode = incomingMode;
                    return;
                }

                if (mode !== incomingMode) {
                    mode = 'mixed';
                }
            };

            const renderPreview = () => {
                previewGrid.innerHTML = '';
                imageCountText.textContent = `${capturedFiles.length} ภาพ`;

                if (!capturedFiles.length) {
                    previewGrid.innerHTML = '<div class="text-muted small">ยังไม่มีภาพที่เลือก</div>';
                    return;
                }

                capturedFiles.forEach((item, index) => {
                    const wrap = document.createElement('div');
                    wrap.className = 'preview-item';

                    const imageWrap = document.createElement('div');
                    imageWrap.className = 'preview-image-wrap';

                    const img = document.createElement('img');
                    img.src = item.url;
                    img.alt = `preview-${index + 1}`;

                    const remove = document.createElement('button');
                    remove.type = 'button';
                    remove.className = 'preview-remove';
                    remove.innerHTML = '<i class="fa-solid fa-xmark"></i>';
                    remove.addEventListener('click', () => {
                        URL.revokeObjectURL(item.url);
                        capturedFiles.splice(index, 1);
                        renderPreview();
                    });

                    const status = document.createElement('div');
                    status.className = 'preview-status';
                    const analyzed = Object.prototype.hasOwnProperty.call(item, 'analysisState')
                        ? item.analysisState
                        : { label: 'กำลังตรวจ...', className: 'is-loading' };
                    if (analyzed && analyzed.label) {
                        status.textContent = analyzed.label;
                        status.classList.add(analyzed.className);
                        status.style.cursor = 'pointer';
                        status.addEventListener('click', () => {
                            const helpTitle = analyzed.label === 'ภาพมืดไป'
                                ? 'ภาพมืดไป'
                                : 'ภาพสว่างไป';
                            const helpText = analyzed.label === 'ภาพมืดไป'
                                ? 'ระบบตรวจความสว่างเฉลี่ยของพิกเซลจากภาพที่เลือก ถ้าค่าความสว่างเฉลี่ยต่ำกว่าช่วงที่กำหนด ภาพจะถูกจัดว่า "ภาพมืดไป"'
                                : 'ระบบตรวจความสว่างเฉลี่ยของพิกเซลจากภาพที่เลือก ถ้าค่าความสว่างเฉลี่ยสูงกว่าช่วงที่กำหนด ภาพจะถูกจัดว่า "ภาพสว่างไป"';

                            Swal.fire({
                                icon: 'info',
                                title: helpTitle,
                                html: `
                                    <div style="text-align:left; font-size:0.95rem; line-height:1.65;">
                                        <div style="margin-bottom:10px;">${helpText}</div>
                                        <div style="margin-bottom:10px;">คำนวณจากค่าเฉลี่ยความสว่างของพิกเซลในภาพพรีวิว</div>
                                        <div style="margin-bottom:10px;">ถ้าค่าอยู่ในช่วงกลาง ระบบจะไม่แสดงข้อความเพิ่มเติม</div>
                                    </div>
                                `,
                                confirmButtonText: 'เข้าใจแล้ว',
                                width: 360,
                            });
                        });
                    }

                    imageWrap.appendChild(img);
                    imageWrap.appendChild(remove);
                    wrap.appendChild(imageWrap);
                    if (analyzed && analyzed.label) {
                        wrap.appendChild(status);
                    }
                    previewGrid.appendChild(wrap);
                });
            };

            const analyzeImageFile = (item) => {
                return new Promise((resolve) => {
                    const image = new Image();
                    image.onload = () => {
                        const canvas = document.createElement('canvas');
                        const sampleWidth = 48;
                        const sampleHeight = 60;
                        canvas.width = sampleWidth;
                        canvas.height = sampleHeight;

                        const ctx = canvas.getContext('2d', {
                            willReadFrequently: true
                        });
                        ctx.drawImage(image, 0, 0, sampleWidth, sampleHeight);

                        const imageData = ctx.getImageData(0, 0, sampleWidth, sampleHeight).data;
                        let total = 0;

                        for (let i = 0; i < imageData.length; i += 4) {
                            total += (imageData[i] + imageData[i + 1] + imageData[i + 2]) / 3;
                        }

                        const avgBrightness = total / (imageData.length / 4);
                        resolve(getPreviewBrightnessState(avgBrightness));
                    };

                    image.onerror = () => resolve({
                        key: 'unknown',
                        label: null,
                        className: null,
                    });

                    image.src = item.url;
                });
            };

            const addFiles = (files, incomingMode = 'upload') => {
                Array.from(files || []).forEach((file) => {
                    const url = URL.createObjectURL(file);
                    const item = {
                        file,
                        url,
                        source: incomingMode,
                        analysisState: {
                            label: 'กำลังตรวจ...',
                            className: 'is-loading',
                        },
                    };
                    capturedFiles.push(item);
                    analyzeImageFile(item).then((state) => {
                        item.analysisState = state ?? { label: null, className: null };
                        renderPreview();
                    });
                });
                syncMode(incomingMode);
                renderPreview();
            };

            const playShutterSound = () => {
                try {
                    const ContextClass = window.AudioContext || window.webkitAudioContext;
                    if (!ContextClass) return;

                    if (!audioContext) {
                        audioContext = new ContextClass();
                    }

                    if (audioContext.state === 'suspended') {
                        audioContext.resume();
                    }

                    const currentTime = audioContext.currentTime;
                    const gainNode = audioContext.createGain();
                    const oscillator = audioContext.createOscillator();

                    gainNode.gain.setValueAtTime(0.0001, currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.25, currentTime + 0.01);
                    gainNode.gain.exponentialRampToValueAtTime(0.0001, currentTime + 0.12);

                    oscillator.type = 'square';
                    oscillator.frequency.setValueAtTime(1850, currentTime);
                    oscillator.frequency.exponentialRampToValueAtTime(900, currentTime + 0.06);

                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);
                    oscillator.start(currentTime);
                    oscillator.stop(currentTime + 0.14);
                } catch (error) {
                    // No-op if audio cannot play.
                }
            };

            const getPreviewBrightnessState = (avg) => {
                if (avg < 78) return {
                    key: 'dim',
                    label: 'ภาพมืดไป',
                    className: 'is-dim'
                };
                if (avg > 185) return {
                    key: 'bright',
                    label: 'ภาพสว่างไป',
                    className: 'is-bright'
                };
                return null;
            };

            const getCameraBrightnessState = (avg) => {
                if (avg < 78) return {
                    key: 'dim',
                    label: 'ภาพมืดไป',
                    className: 'is-dim'
                };
                if (avg > 185) return {
                    key: 'bright',
                    label: 'ภาพสว่างไป',
                    className: 'is-bright'
                };
                return {
                    key: 'good',
                    label: 'ความสว่างภาพ : ปกติ',
                    className: 'is-good'
                };
            };

            const analyzeCameraFrame = () => {
                if (!cameraStream || !cameraVideo.videoWidth || !cameraVideo.videoHeight) return;

                const canvas = document.createElement('canvas');
                const sampleWidth = 48;
                const sampleHeight = 60;
                canvas.width = sampleWidth;
                canvas.height = sampleHeight;

                const ctx = canvas.getContext('2d', {
                    willReadFrequently: true
                });
                ctx.drawImage(cameraVideo, 0, 0, sampleWidth, sampleHeight);

                const imageData = ctx.getImageData(0, 0, sampleWidth, sampleHeight).data;
                let total = 0;

                for (let i = 0; i < imageData.length; i += 4) {
                    total += (imageData[i] + imageData[i + 1] + imageData[i + 2]) / 3;
                }

                const avgBrightness = total / (imageData.length / 4);
                const state = getCameraBrightnessState(avgBrightness);

                cameraHint.classList.remove('is-good', 'is-dim', 'is-bright');
                if (state) {
                    cameraHint.textContent = state.label;
                    cameraHint.classList.add(state.className);
                } else {
                    cameraHint.textContent = '';
                }
            };

            const startBrightnessMonitoring = () => {
                stopBrightnessMonitoring();
                brightnessTimer = window.setInterval(analyzeCameraFrame, 500);
                analyzeCameraFrame();
            };

            const stopBrightnessMonitoring = () => {
                if (brightnessTimer) {
                    window.clearInterval(brightnessTimer);
                    brightnessTimer = null;
                }
                cameraHint.textContent = 'พร้อมใช้งาน';
                cameraHint.classList.remove('is-good', 'is-dim', 'is-bright');
            };

            const capturePhoto = () => {
                const videoWidth = cameraVideo.videoWidth || 1280;
                const videoHeight = cameraVideo.videoHeight || 1600;
                const videoAspect = videoWidth / videoHeight;

                let sourceX = 0;
                let sourceY = 0;
                let sourceWidth = videoWidth;
                let sourceHeight = videoHeight;

                if (videoAspect > targetAspect) {
                    sourceWidth = Math.round(videoHeight * targetAspect);
                    sourceX = Math.round((videoWidth - sourceWidth) / 2);
                } else if (videoAspect < targetAspect) {
                    sourceHeight = Math.round(videoWidth / targetAspect);
                    sourceY = Math.round((videoHeight - sourceHeight) / 2);
                }

                const canvas = document.createElement('canvas');
                canvas.width = 1280;
                canvas.height = Math.round(canvas.width / targetAspect);

                const ctx = canvas.getContext('2d');
                ctx.drawImage(
                    cameraVideo,
                    sourceX,
                    sourceY,
                    sourceWidth,
                    sourceHeight,
                    0,
                    0,
                    canvas.width,
                    canvas.height
                );

                canvas.toBlob((blob) => {
                    if (!blob) return;
                    const file = new File([blob], `skin-${Date.now()}.jpg`, {
                        type: 'image/jpeg'
                    });
                    addFiles([file], 'camera');
                }, 'image/jpeg', 0.92);
            };

            const stopCamera = () => {
                if (cameraStream) {
                    cameraStream.getTracks().forEach((track) => track.stop());
                    cameraStream = null;
                }
                cameraBox.classList.remove('is-open');
                shootTipBtn.classList.remove('is-open');
                cameraOverlayTop.classList.remove('is-open');
                cameraActions.classList.remove('is-open');
                captureBtn.disabled = true;
                cameraCloseOverlayBtn.disabled = true;
                stopBrightnessMonitoring();
            };

            const openCamera = async () => {
                try {
                    cameraStream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: {
                                ideal: 'environment'
                            }
                        },
                        audio: false
                    });

                    cameraVideo.srcObject = cameraStream;
                    cameraBox.classList.add('is-open');
                    shootTipBtn.classList.add('is-open');
                    cameraOverlayTop.classList.add('is-open');
                    cameraActions.classList.add('is-open');
                    captureBtn.disabled = false;
                    cameraCloseOverlayBtn.disabled = false;
                    cameraHint.textContent = 'กำลังวิเคราะห์แสง...';
                    syncMode('camera');
                    const kickOffMonitoring = () => {
                        if (cameraVideo.videoWidth && cameraVideo.videoHeight) {
                            startBrightnessMonitoring();
                            return;
                        }

                        window.requestAnimationFrame(kickOffMonitoring);
                    };

                    window.requestAnimationFrame(kickOffMonitoring);
                } catch (error) {
                    alert('ไม่สามารถเปิดกล้องได้ กรุณาอนุญาตการเข้าถึงกล้อง');
                }
            };

            openCameraBtn.addEventListener('click', openCamera);
            openUploadBtn.addEventListener('click', () => uploadFileInput.click());
            shootTipBtn.addEventListener('click', () => {
                Swal.fire({
                    icon: 'info',
                    title: 'คำแนะนำการถ่ายภาพ',
                    html: `
                        <div style="text-align:left; font-size:0.95rem; line-height:1.6;">
                            <div style="margin-bottom:10px;">1. ให้แสงพอ ไม่ย้อนแสง และไม่มืดเกินไป</div>
                            <div style="margin-bottom:10px;">2. จัดรอยโรคให้อยู่กลางกรอบ 4:5</div>
                            <div style="margin-bottom:10px;">3. จับเครื่องให้นิ่ง และเว้นระยะพอดี ไม่ชิดหรือไกลเกินไป</div>
                            <div style="margin-bottom:10px;">4. หากต้องการเก็บรายละเอียด ให้ถ่ายเพิ่มหลายมุมได้</div>
                        </div>
                    `,
                    confirmButtonText: 'เข้าใจแล้ว',
                    width: 360,
                });
            });
            uploadFileInput.addEventListener('change', (event) => {
                addFiles(event.target.files, 'upload');
                event.target.value = '';
            });

            captureBtn.addEventListener('click', async () => {
                if (!cameraStream) return;
                playShutterSound();
                capturePhoto();
            });

            cameraCloseOverlayBtn.addEventListener('click', stopCamera);

            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                if (!capturedFiles.length) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณาเลือกภาพ',
                        text: 'ต้องเพิ่มภาพอย่างน้อย 1 ภาพก่อนบันทึก',
                        confirmButtonText: 'ตกลง'
                    });
                    return;
                }

                const symptoms = document.getElementById('symptoms').value.trim();
                const location = document.getElementById('location').value.trim();

                if (!symptoms) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณากรอกอาการ / โรค',
                        confirmButtonText: 'ตกลง'
                    });
                    return;
                }

                const formData = new FormData();
                formData.append('_token', csrfToken);
                formData.append('capture_mode', mode || 'upload');
                formData.append('symptoms', symptoms);
                formData.append('location', location);
                formData.append('notes', document.getElementById('notes').value.trim());

                capturedFiles.forEach((item) => {
                    formData.append('images[]', item.file);
                });

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> กำลังบันทึก';

                try {
                    const confirmResult = await Swal.fire({
                        icon: 'question',
                        title: 'ยืนยันการบันทึก',
                        text: 'ต้องการบันทึกภาพและข้อมูลที่กรอกไว้ใช่หรือไม่',
                        showCancelButton: true,
                        confirmButtonText: 'บันทึก',
                        cancelButtonText: 'ยกเลิก',
                    });

                    if (!confirmResult.isConfirmed) {
                        return;
                    }

                    const response = await fetch('{{ route('app.upload.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    const payload = await response.json();

                    if (!response.ok) {
                        throw payload;
                    }

                    window.location.href = payload.redirect_url || '{{ route('app.library') }}';
                } catch (error) {
                    const message = error?.message || 'ไม่สามารถบันทึกภาพได้';
                    Swal.fire({
                        icon: 'error',
                        title: 'บันทึกไม่สำเร็จ',
                        text: message,
                        confirmButtonText: 'ตกลง'
                    });
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'บันทึก';
                }
            });

            renderPreview();

            window.addEventListener('beforeunload', stopCamera);
            window.addEventListener('beforeunload', () => {
                capturedFiles.forEach((item) => URL.revokeObjectURL(item.url));
            });
        })();
    </script>

    @include('layouts.mobile-nav')
@endsection
