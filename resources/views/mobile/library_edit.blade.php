@extends('layouts.app')
@section('page_title', $page_title ?? 'แก้ไขข้อมูลภาพ')

@section('style')
    <style>
        body { background:#f4f6fb; }
        .sidebar,.iq-navbar,.iq-navbar-header,.footer { display:none !important; }
        .main-content { margin-left:0 !important; padding-top:0 !important; min-height:100vh; background:#f4f6fb; }
        .content-inner { padding:0 !important; }
        .mobile-shell { width:100%; max-width:430px; min-height:100vh; margin:0 auto; padding:76px 14px 100px; background:linear-gradient(180deg,#fff 0%,#f7f8fc 28%,#f4f6fb 100%); box-shadow:0 0 0 1px rgba(17,24,39,.03); }
        .mobile-topbar { display:flex; align-items:center; justify-content:space-between; gap:12px; padding:12px 14px 10px; margin:0; position:fixed; top:0; left:50%; transform:translateX(-50%); width:min(430px,100%); border-radius:0 0 20px 20px; z-index:1040; background:rgba(255,255,255,.96); box-shadow:0 6px 18px rgba(17,24,39,.06); backdrop-filter:blur(18px); -webkit-backdrop-filter:blur(18px); }
        .mobile-topbar-title { flex:1; text-align:center; font-size:1.05rem; font-weight:700; color:#1f2937; margin:0; }
        .mobile-topbar-action,.mobile-topbar-back { width:42px; height:42px; border-radius:14px; border:1px solid rgba(17,24,39,.08); background:rgba(255,255,255,.9); display:inline-flex; align-items:center; justify-content:center; color:#111827; flex:0 0 auto; }
        .page-card { border-radius:22px; background:#fff; border:1px solid rgba(17,24,39,.07); box-shadow:0 8px 24px rgba(17,24,39,.04); padding:14px; }
        .section-title { font-size:1.02rem; font-weight:700; color:#1f2937; margin:0 0 10px; }
        .record-thumb { width:100%; aspect-ratio:4 / 3; border-radius:18px; overflow:hidden; background:#eef2ff; display:flex; align-items:center; justify-content:center; margin-bottom:12px; }
        .record-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
        .record-badge { display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:999px; font-size:.8rem; font-weight:700; background:#eef2ff; color:#4552d0; margin-bottom:12px; }
        .record-badge.is-shared { background:#ecfdf3; color:#16834d; }
        .record-badge.is-warning { background:#fff7ed; color:#c2410c; }
        .form-label { font-size:.9rem; font-weight:700; color:#1f2937; margin-bottom:6px; }
        .form-control { border-radius:14px; min-height:44px; }
        textarea.form-control { min-height:92px; }
        .btn-save { min-height:46px; border-radius:14px; font-weight:700; }
        .hint { font-size:.84rem; color:#6b7280; line-height:1.5; }
    </style>
@endsection

@section('content')
    <div class="mobile-shell">
        <div class="mobile-topbar">
            <button type="button" class="mobile-topbar-back" aria-label="ย้อนกลับ" onclick="window.history.back()">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </button>
            <h1 class="mobile-topbar-title">{{ $page_title ?? 'แก้ไขข้อมูลภาพ' }}</h1>
            <a href="{{ route('app.notifications') }}" class="mobile-topbar-action text-decoration-none" aria-label="การแจ้งเตือน">
                <i class="fa-regular fa-bell fa-lg"></i>
            </a>
        </div>

        <div class="page-card mb-3">
            <div class="section-title">ข้อมูลภาพต้นฉบับ</div>
            @if (!empty($record->thumbnail_url))
                <div class="record-thumb">
                    <img src="{{ $record->thumbnail_url }}" alt="preview">
                </div>
            @endif
            <div class="record-badge {{ $record->share_status_class ?? 'is-warning' }}">
                <i class="fa-solid fa-share-nodes"></i>
                {{ $record->share_status_label ?? 'ยังไม่แชร์' }}
            </div>
            <p class="hint mb-0">แก้ไขได้เฉพาะข้อมูลประกอบภาพ ไฟล์ภาพต้นฉบับจะไม่ถูกเปลี่ยน</p>
        </div>

        <div class="page-card">
            <div class="section-title">แก้ไขข้อมูลภาพ</div>

            <form method="POST" action="{{ route('app.library.update', $record->id) }}" id="libraryEditForm">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label" for="symptoms">อาการ / โรค</label>
                    <input type="text" name="symptoms" id="symptoms" class="form-control @error('symptoms') is-invalid @enderror" value="{{ old('symptoms', $record->symptoms ?? '') }}" required>
                    @error('symptoms')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="location">ตำแหน่งที่ถ่าย</label>
                    <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $record->location ?? '') }}" required>
                    @error('location')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="notes">หมายเหตุเพิ่มเติม</label>
                    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="4">{{ old('notes', $record->notes ?? '') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-save js-confirm-save">
                    บันทึกการแก้ไข
                </button>
            </form>
        </div>
    </div>

    @include('layouts.mobile-nav')

    <script>
        (function() {
            const form = document.getElementById('libraryEditForm');
            const saveButton = document.querySelector('.js-confirm-save');
            if (!form || !saveButton) return;

            saveButton.addEventListener('click', async function(event) {
                event.preventDefault();
                const result = await Swal.fire({
                    icon: 'question',
                    title: 'บันทึกการแก้ไข',
                    text: 'ต้องการบันทึกการแก้ไขข้อมูลภาพนี้หรือไม่',
                    showCancelButton: true,
                    confirmButtonText: 'บันทึก',
                    cancelButtonText: 'ยกเลิก',
                });

                if (result.isConfirmed) {
                    form.submit();
                }
            });
        })();
    </script>
@endsection
