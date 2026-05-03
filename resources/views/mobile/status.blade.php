@extends('layouts.app')
@section('page_title', $page_title ?? 'ข้อมูลสถานะผู้เข้าร่วม')

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

        .mobile-shell a {
            color: inherit;
            text-decoration: none;
        }

        .page-card {
            border-radius: 22px;
            background: #ffffff;
            border: 1px solid rgba(17, 24, 39, 0.07);
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.04);
            padding: 16px 14px;
        }

        .profile-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
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
            font-size: 0.82rem;
            font-weight: 700;
            color: #4552d0;
            margin: 0 0 2px;
        }

        .profile-name {
            font-size: 1.04rem;
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

        .status-section + .status-section {
            margin-top: 12px;
        }

        .status-section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 10px;
        }

        .status-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            padding: 11px 0;
        }

        .status-row + .status-row {
            border-top: 1px solid rgba(17, 24, 39, 0.06);
        }

        .status-label {
            min-width: 0;
            flex: 1;
        }

        .status-title {
            font-size: 0.96rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 4px;
            line-height: 1.35;
        }

        .status-desc {
            font-size: 0.86rem;
            color: #6b7280;
            margin: 0;
            line-height: 1.4;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 700;
            white-space: nowrap;
            flex: 0 0 auto;
        }

        .status-badge--success {
            background: #f0fdf4;
            color: #166534;
        }

        .status-badge--warning {
            background: #fff9f0;
            color: #b54708;
        }

        .status-badge--danger {
            background: #fff5f5;
            color: #b42318;
        }

        .status-note {
            margin-top: 10px;
            padding: 10px 12px;
            border-radius: 16px;
            background: #f8faff;
            border: 1px solid rgba(76, 89, 255, 0.08);
            color: #4b5563;
            font-size: 0.88rem;
            line-height: 1.45;
        }

        .status-actions {
            display: grid;
            gap: 10px;
            margin-top: 12px;
        }

        .status-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            min-height: 48px;
            border-radius: 16px;
            border: 1px solid transparent;
            font-size: 0.94rem;
            font-weight: 700;
            text-decoration: none;
        }

        .status-action--call {
            background: #f0fdf4;
            color: #166534;
            border-color: rgba(34, 197, 94, 0.18);
        }

        .status-action--logout {
            background: #fff5f5;
            color: #b42318;
            border-color: rgba(239, 68, 68, 0.18);
        }

        .status-action i {
            font-size: 0.95rem;
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
    </style>
@endsection

@section('content')
    @php
        $currentUser = $current_user ?? auth()->user();
        $testStatus = trim((string) ($currentUser->test_status ?? ''));
        $evaluationStatus = trim((string) ($currentUser->evaluation_status ?? ''));
        $hasTestStatus = $testStatus !== '';
        $hasEvaluationStatus = $evaluationStatus !== '';

        if ($hasTestStatus && $hasEvaluationStatus) {
            $assessmentStateClass = 'status-badge--success';
            $assessmentStateLabel = 'ผ่านแล้ว';
        } elseif ($hasTestStatus || $hasEvaluationStatus) {
            $assessmentStateClass = 'status-badge--warning';
            $assessmentStateLabel = 'ทำได้บางส่วน';
        } else {
            $assessmentStateClass = 'status-badge--danger';
            $assessmentStateLabel = 'ยังไม่ผ่าน';
        }

        $paymentStatusText = trim((string) (data_get($currentUser, 'status_payto_research_participant') ?? ''));
        $compensationChannelText = trim((string) (data_get($currentUser, 'compensation_channel') ?? ''));
        $paymentRaw = trim((string) (data_get($currentUser, 'payment_status') ?? data_get($currentUser, 'payment_paid_at') ?? ''));

        if ($compensationChannelText === 'ไม่รับค่าตอบแทน') {
            $paymentStateClass = 'status-badge--success';
            $paymentStateLabel = 'ไม่ขอรับค่าตอบแทน';
        } elseif ($paymentStatusText === 'ชำระแล้ว' || $paymentRaw !== '') {
            $paymentStateClass = 'status-badge--success';
            $paymentStateLabel = 'ชำระแล้ว';
        } else {
            $paymentStateClass = 'status-badge--danger';
            $paymentStateLabel = 'ยังไม่ชำระ';
        }
    @endphp

    <div class="mobile-shell">
        <div class="mobile-topbar">
            <button type="button" class="mobile-topbar-back" aria-label="ย้อนกลับ" onclick="window.history.back()">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </button>
            <h1 class="mobile-topbar-title">{{ $page_title ?? 'ข้อมูลสถานะผู้เข้าร่วม' }}</h1>
            <a href="{{ route('app.notifications') }}" class="mobile-topbar-action text-decoration-none" aria-label="การแจ้งเตือน">
                <i class="fa-regular fa-bell fa-lg"></i>
            </a>
        </div>

        <div class="page-card mb-3">
            <div class="profile-card-header">
                <div class="profile-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="profile-copy">
                    <p class="profile-label">ข้อมูลผู้เข้าร่วม</p>
                    <p class="profile-name">คุณ{{ $currentUser->name ?? 'ผู้ใช้งาน' }}</p>
                    <p class="profile-meta">{{ $currentUser->username ?? '-' }}</p>
                    @if (!empty($currentUser->compensation_channel))
                        <p class="profile-meta">{{ $currentUser->compensation_channel }}</p>
                    @endif
                </div>
            </div>

            <div class="status-section">
                <h2 class="status-section-title">แบบทดสอบ-แบบประเมิน</h2>

                <div class="status-row">
                    <div class="status-label">
                        <p class="status-title">ทดสอบระบบต้นแบบ</p>
                        <p class="status-desc">{{ $currentUser->test_status ?? 'ยังไม่มีข้อมูล' }}</p>
                    </div>
                    <div class="status-badge {{ $assessmentStateClass }}">
                        <i class="fa-solid fa-circle"></i>
                        {{ $assessmentStateLabel }}
                    </div>
                </div>

                <div class="status-row">
                    <div class="status-label">
                        <p class="status-title">ทำแบบประเมิน</p>
                        <p class="status-desc">{{ $currentUser->evaluation_status ?? 'ยังไม่มีข้อมูล' }}</p>
                    </div>
                    <div class="status-badge {{ $assessmentStateClass }}">
                        <i class="fa-solid fa-circle"></i>
                        {{ $assessmentStateLabel }}
                    </div>
                </div>

                <div class="status-note">
                    สรุปรวม: {{ $assessmentStateLabel }}
                </div>
            </div>

            <div class="status-section">
                <h2 class="status-section-title">การชำระเงิน</h2>

                <div class="status-row">
                    <div class="status-label">
                        <p class="status-title">ช่องทางการจ่ายค่าตอบแทน</p>
                        <p class="status-desc">
                            {{ $compensationChannelText !== '' ? $compensationChannelText : 'ยังไม่ได้ระบุ' }}
                        </p>
                    </div>
                    <div class="status-badge {{ $paymentStateClass }}">
                        <i class="fa-solid fa-circle"></i>
                        {{ $paymentStateLabel }}
                    </div>
                </div>
            </div>

            <div class="status-actions">
                <a href="tel:0800808714" class="status-action status-action--call">
                    <i class="fa-solid fa-phone"></i>
                    ติดต่อผู้วิจัย
                </a>

                <form action="{{ route('logout') }}" method="post" class="m-0">
                    @csrf
                    <button type="submit" class="status-action status-action--logout">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        ออกจากระบบ
                    </button>
                </form>
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
                <span>อัปโหลด</span>
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
