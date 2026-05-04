@extends('layouts.app')
@section('page_title', $page_title ?? 'การแจ้งเตือน')

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
        .notification-list { display:grid; gap:10px; }
        .notification-card { border-radius:18px; border:1px solid rgba(17,24,39,.08); background:#fff; padding:12px; display:grid; gap:10px; }
        .notification-head { display:flex; align-items:flex-start; justify-content:space-between; gap:10px; }
        .notification-title { font-size:.94rem; font-weight:700; color:#1f2937; margin:0 0 4px; }
        .notification-meta { font-size:.84rem; color:#64748b; margin:0; }
        .notification-badge { display:inline-flex; align-items:center; gap:6px; padding:6px 10px; border-radius:999px; font-size:.78rem; font-weight:700; }
        .notification-badge.is-unread { background:rgba(239,68,68,.12); color:#b91c1c; }
        .notification-badge.is-read { background:rgba(34,197,94,.14); color:#166534; }
        .notification-row { display:flex; gap:10px; align-items:flex-start; padding:10px 12px; border-radius:16px; background:#f8fafc; border:1px solid rgba(148,163,184,.16); }
        .notification-row i { color:#4552d0; margin-top:2px; }
        .notification-row span { font-size:.87rem; color:#334155; }
        .action-row { display:grid; gap:10px; }
        .action-row .btn { min-height:44px; border-radius:14px; font-weight:700; }
        .small-note { font-size:.84rem; color:#64748b; }
        @media (min-width:768px){ .mobile-shell { border-left:1px solid rgba(17,24,39,.06); border-right:1px solid rgba(17,24,39,.06); } }
    </style>
@endsection

@section('content')
    <div class="mobile-shell">
        <div class="mobile-topbar">
            <button type="button" class="mobile-topbar-back" aria-label="ย้อนกลับ" onclick="window.history.back()">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </button>
            <h1 class="mobile-topbar-title">{{ $page_title ?? 'การแจ้งเตือน' }}</h1>
            <a href="{{ route('app.history') }}" class="mobile-topbar-action text-decoration-none" aria-label="ประวัติ">
                <i class="fa-solid fa-clock-rotate-left fa-lg"></i>
            </a>
        </div>

        <div class="page-card mb-3">
            <div class="section-title">วัตถุประสงค์</div>
            <p class="lead-copy mb-0">มีการแชร์ข้อมูล มีการเข้าถึงข้อมูล มีการถอนความยินยอม มีการยกเลิกสิทธิ์ และมีการลบภาพ</p>
        </div>

        <div class="page-card mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="section-title mb-0">การแจ้งเตือน</div>
                <div class="small-note">ยังไม่อ่าน {{ number_format($unreadCount) }} รายการ</div>
            </div>

            <div class="notification-list">
                @forelse ($notifications as $notification)
                    <div class="notification-card">
                        <div class="notification-head">
                            <div>
                                <div class="notification-title">{{ $notification->description }}</div>
                                <p class="notification-meta">{{ $notification->created_at_text }} | {{ $notification->actor_name }} ({{ $notification->actor_role }})</p>
                            </div>
                            <div class="notification-badge {{ $notification->is_read ? 'is-read' : 'is-unread' }}">
                                <i class="fa-solid fa-circle"></i>
                                {{ $notification->is_read ? 'read' : 'unread' }}
                            </div>
                        </div>

                        <div class="notification-row">
                            <i class="fa-solid fa-bell"></i>
                            <span>{{ strtoupper($notification->action_type) }} | {{ $notification->page_path ?? '-' }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <a href="{{ route('app.history.show', $notification->id) }}" class="btn btn-sm btn-outline-primary">ดูรายละเอียด</a>
                            @if (! $notification->is_read)
                                <form method="POST" action="{{ route('app.notifications.read', $notification->id) }}">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-success js-mark-read">mark notification as read</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="lead-copy mb-0">ยังไม่มีการแจ้งเตือน</p>
                @endforelse
            </div>

            <div class="mt-3">
                {{ $notifications->links() }}
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
