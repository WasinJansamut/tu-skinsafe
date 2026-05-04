@extends('layouts.app')
@section('page_title', $page_title ?? 'รายละเอียดประวัติ')

@section('style')
    <style>
        body { background:#f4f6fb; }
        .sidebar, .iq-navbar, .iq-navbar-header, .footer { display:none !important; }
        .main-content { margin-left:0 !important; padding-top:0 !important; min-height:100vh; background:#f4f6fb; }
        .content-inner { padding:0 !important; }
        .mobile-shell { width:100%; max-width:430px; min-height:100vh; margin:0 auto; padding:76px 14px 104px; background:linear-gradient(180deg,#fff 0%,#f7f8fc 26%,#f4f6fb 100%); box-shadow:0 0 0 1px rgba(17,24,39,.03); }
        .mobile-topbar { display:flex; align-items:center; justify-content:space-between; gap:12px; padding:12px 14px 10px; position:fixed; top:0; left:50%; transform:translateX(-50%); width:min(430px,100%); border-radius:0 0 20px 20px; z-index:1040; background:rgba(255,255,255,.96); box-shadow:0 6px 18px rgba(17,24,39,.06); backdrop-filter:blur(18px); -webkit-backdrop-filter:blur(18px); }
        .mobile-topbar-title { flex:1; text-align:center; font-size:1.02rem; font-weight:700; color:#1f2937; margin:0; }
        .mobile-topbar-action, .mobile-topbar-back { width:42px; height:42px; border-radius:14px; border:1px solid rgba(17,24,39,.08); background:rgba(255,255,255,.9); display:inline-flex; align-items:center; justify-content:center; color:#111827; flex:0 0 auto; }
        .page-card { border-radius:22px; background:#fff; border:1px solid rgba(17,24,39,.07); box-shadow:0 8px 24px rgba(17,24,39,.04); padding:14px; }
        .section-title { font-size:1rem; font-weight:700; color:#1f2937; margin:0 0 10px; }
        .lead-copy { font-size:.92rem; color:#4b5563; line-height:1.65; margin:0; }
        .detail-grid { display:grid; gap:8px; }
        .detail-row { display:flex; gap:10px; align-items:flex-start; padding:10px 12px; border-radius:16px; background:#f8fafc; border:1px solid rgba(148,163,184,.16); }
        .detail-row i { color:#4552d0; margin-top:2px; }
        .detail-row span { font-size:.87rem; color:#334155; }
        .badge-state { display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:999px; font-size:.78rem; font-weight:700; }
        .badge-state.is-read { background:rgba(34,197,94,.14); color:#166534; }
        .badge-state.is-unread { background:rgba(239,68,68,.12); color:#b91c1c; }
        .action-row { display:grid; gap:10px; }
        .action-row .btn { min-height:44px; border-radius:14px; font-weight:700; }
        @media (min-width:768px){ .mobile-shell { border-left:1px solid rgba(17,24,39,.06); border-right:1px solid rgba(17,24,39,.06); } }
    </style>
@endsection

@section('content')
    <div class="mobile-shell">
        <div class="mobile-topbar">
            <button type="button" class="mobile-topbar-back" aria-label="ย้อนกลับ" onclick="window.history.back()">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </button>
            <h1 class="mobile-topbar-title">{{ $page_title ?? 'รายละเอียดประวัติ' }}</h1>
            <a href="{{ route('app.notifications') }}" class="mobile-topbar-action text-decoration-none" aria-label="การแจ้งเตือน">
                <i class="fa-regular fa-bell fa-lg"></i>
            </a>
        </div>

        <div class="page-card mb-3">
            <div class="section-title">{{ $log->description }}</div>
            <div class="mb-2">
                <span class="badge-state {{ $log->is_read ? 'is-read' : 'is-unread' }}">
                    <i class="fa-solid fa-circle"></i>
                    {{ $log->is_read ? 'อ่านแล้ว' : 'ยังไม่อ่าน' }}
                </span>
            </div>
            <p class="lead-copy mb-0">{{ $log->created_at_text }} | {{ $log->actor_name }} ({{ $log->actor_role }})</p>
        </div>

        <div class="page-card mb-3">
            <div class="section-title">รายละเอียดเหตุการณ์</div>
            <div class="detail-grid">
                <div class="detail-row">
                    <i class="fa-regular fa-calendar"></i>
                    <span>วันที่และเวลา: {{ $log->created_at_text }}</span>
                </div>
                <div class="detail-row">
                    <i class="fa-solid fa-user"></i>
                    <span>ผู้ดำเนินการ: {{ $log->actor_name }} ({{ $log->actor_role }})</span>
                </div>
                <div class="detail-row">
                    <i class="fa-solid fa-tag"></i>
                    <span>ประเภทเหตุการณ์: {{ strtoupper($log->action_type) }}</span>
                </div>
                <div class="detail-row">
                    <i class="fa-solid fa-align-left"></i>
                    <span>รายละเอียดเหตุการณ์: {{ $log->description }}</span>
                </div>
                <div class="detail-row">
                    <i class="fa-solid fa-link"></i>
                    <span>ภาพที่เกี่ยวข้อง: {{ $log->target_label ?? ($log->target_type ?? '-') }}</span>
                </div>
                <div class="detail-row">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>หน้า: {{ $log->page_path ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="page-card mb-3">
            <div class="section-title">ข้อมูลดิบ</div>
            <pre class="mb-0 small" style="white-space:pre-wrap; word-break:break-word; color:#475569;">{{ json_encode($log->details_array ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>

        <div class="action-row">
            @if (! $log->is_read)
                <form method="POST" action="{{ route('app.notifications.read', $log->id) }}">
                    @csrf
                    <button type="button" class="btn btn-success w-100 js-mark-read-detail">mark notification as read</button>
                </form>
            @endif
            <a href="{{ route('app.history') }}" class="btn btn-outline-primary">กลับไปหน้าประวัติ</a>
        </div>
    </div>

    @include('layouts.mobile-nav')

    <script>
        (function() {
            const btn = document.querySelector('.js-mark-read-detail');
            if (!btn) return;

            btn.addEventListener('click', async function() {
                const form = this.closest('form');
                const result = await Swal.fire({
                    icon: 'question',
                    title: 'ทำเครื่องหมายว่าอ่านแล้ว',
                    text: 'ยืนยันการทำเครื่องหมายรายการนี้ว่าอ่านแล้วหรือไม่',
                    showCancelButton: true,
                    confirmButtonText: 'ทำเครื่องหมาย',
                    cancelButtonText: 'ยกเลิก',
                });
                if (result.isConfirmed && form) form.submit();
            });
        })();
    </script>
@endsection
