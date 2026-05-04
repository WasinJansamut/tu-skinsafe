@extends('layouts.app')
@section('page_title', $page_title ?? 'ประวัติการเข้าถึงและการแจ้งเตือน')

@section('style')
    <style>
        body { background: #f4f6fb; }
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
        .filter-wrap { display:grid; gap:10px; }
        .form-label { font-size:.86rem; font-weight:700; color:#374151; margin-bottom:6px; }
        .form-control, .form-select { min-height:44px; border-radius:14px; border-color:rgba(17,24,39,.10); }
        .action-row .btn { min-height:44px; border-radius:14px; font-weight:700; }
        .log-list { display:grid; gap:10px; }
        .log-card { border-radius:18px; border:1px solid rgba(17,24,39,.08); background:#fff; padding:12px; display:grid; gap:10px; }
        .log-head { display:flex; align-items:flex-start; justify-content:space-between; gap:10px; }
        .log-title { font-size:.94rem; font-weight:700; color:#1f2937; margin:0 0 4px; }
        .log-meta { font-size:.84rem; color:#64748b; margin:0; }
        .log-badge { display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:999px; font-size:.78rem; font-weight:700; background:rgba(69,82,208,.10); color:#4552d0; }
        .log-badge.is-unread { background:rgba(239,68,68,.12); color:#b91c1c; }
        .log-row { display:flex; gap:10px; align-items:flex-start; padding:10px 12px; border-radius:16px; background:#f8fafc; border:1px solid rgba(148,163,184,.16); }
        .log-row i { color:#4552d0; margin-top:2px; }
        .log-row span { font-size:.87rem; color:#334155; }
        .small-note { font-size:.84rem; color:#64748b; }
        .top-stats { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:8px; }
        .stat { border-radius:16px; background:#f8fafc; border:1px solid rgba(148,163,184,.16); padding:10px 12px; }
        .stat strong { display:block; font-size:1rem; color:#1f2937; }
        .stat span { font-size:.8rem; color:#64748b; }
        @media (min-width:768px){ .mobile-shell { border-left:1px solid rgba(17,24,39,.06); border-right:1px solid rgba(17,24,39,.06); } }
    </style>
@endsection

@section('content')
    @php
        $filterOptions = [
            'all' => 'ทั้งหมด',
            'upload' => 'Upload',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'consent' => 'Consent',
            'share' => 'Share',
            'access' => 'Access',
            'revoke' => 'Revoke',
        ];
    @endphp

    <div class="mobile-shell">
        <div class="mobile-topbar">
            <button type="button" class="mobile-topbar-back" aria-label="ย้อนกลับ" onclick="window.history.back()">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </button>
            <h1 class="mobile-topbar-title">{{ $page_title ?? 'ประวัติการเข้าถึงและการแจ้งเตือน' }}</h1>
            <a href="{{ route('app.notifications') }}" class="mobile-topbar-action text-decoration-none" aria-label="การแจ้งเตือน">
                <i class="fa-regular fa-bell fa-lg"></i>
            </a>
        </div>

        <div class="page-card mb-3">
            <div class="section-title">วัตถุประสงค์</div>
            <p class="lead-copy mb-0">ให้ผู้ใช้ตรวจสอบย้อนหลังว่าเกิดอะไรขึ้นกับข้อมูลของตน เช่น มีการบันทึก แชร์ เข้าดู ถอนความยินยอม หรือเปลี่ยนสิทธิ์</p>
        </div>

        <div class="page-card mb-3">
            <div class="top-stats mb-3">
                <div class="stat">
                    <strong>{{ number_format($logs->total()) }}</strong>
                    <span>รายการทั้งหมด</span>
                </div>
                <div class="stat">
                    <strong>{{ number_format($unreadCount ?? 0) }}</strong>
                    <span>ยังไม่อ่าน</span>
                </div>
                <div class="stat">
                    <strong>{{ $filterLabels[$filter] ?? 'ทั้งหมด' }}</strong>
                    <span>ตัวกรอง</span>
                </div>
            </div>

            <form method="GET" action="{{ route('app.history') }}" class="filter-wrap">
                <div>
                    <label class="form-label" for="filter">กรองตามประเภท</label>
                    <select class="form-select" id="filter" name="filter">
                        @foreach ($filterOptions as $key => $label)
                            <option value="{{ $key }}" {{ $filter === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label" for="from">วันที่เริ่มต้น</label>
                        <input type="date" class="form-control" id="from" name="from" value="{{ $from }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="to">วันที่สิ้นสุด</label>
                        <input type="date" class="form-control" id="to" name="to" value="{{ $to }}">
                    </div>
                </div>
                <div class="action-row">
                    <button type="submit" class="btn btn-primary">กรองรายการ</button>
                    <a href="{{ route('app.history') }}" class="btn btn-outline-secondary">ล้างตัวกรอง</a>
                </div>
            </form>
        </div>

        <div class="page-card mb-3">
            <div class="section-title">ประวัติการเข้าถึง</div>
            <div class="log-list">
                @forelse ($logs as $log)
                    <div class="log-card">
                        <div class="log-head">
                            <div>
                                <div class="log-title">{{ $log->description }}</div>
                                <p class="log-meta">{{ $log->created_at_text }} | {{ $log->actor_name }} ({{ $log->actor_role }})</p>
                            </div>
                            <div class="log-badge {{ $log->is_read ? '' : 'is-unread' }}">
                                <i class="fa-solid fa-circle"></i>
                                {{ strtoupper($log->action_type) }}
                            </div>
                        </div>

                        @if (!empty($log->target_type) || !empty($log->target_id))
                            <div class="log-row">
                                <i class="fa-solid fa-paperclip"></i>
                                <span>รายการที่เกี่ยวข้อง: {{ $log->target_label ?? ($log->target_type ?? '-') }}</span>
                            </div>
                        @endif

                        <div class="log-row">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>หน้า: {{ $log->page_path ?? '-' }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <a href="{{ route('app.history.show', $log->id) }}" class="btn btn-sm btn-outline-primary">ดูรายละเอียด</a>
                            @if (! $log->is_read)
                                <form method="POST" action="{{ route('app.notifications.read', $log->id) }}">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-success js-mark-read">mark notification as read</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="lead-copy mb-0">ยังไม่มีรายการ log</p>
                @endforelse
            </div>

            <div class="mt-3">
                {{ $logs->links() }}
            </div>
        </div>
    </div>

    @include('layouts.mobile-nav')

    <script>
        (function() {
            document.querySelectorAll('.js-mark-read').forEach((button) => {
                button.addEventListener('click', async function() {
                    const form = this.closest('form');
                    const result = await Swal.fire({
                        icon: 'question',
                        title: 'ทำเครื่องหมายว่าอ่านแล้ว',
                        text: 'ต้องการทำเครื่องหมายรายการนี้ว่าอ่านแล้วหรือไม่',
                        showCancelButton: true,
                        confirmButtonText: 'ทำเครื่องหมาย',
                        cancelButtonText: 'ยกเลิก',
                    });
                    if (result.isConfirmed && form) form.submit();
                });
            });
        })();
    </script>
@endsection
