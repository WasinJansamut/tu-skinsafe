@extends('layouts.app')
@section('page_title', $page_title ?? 'สิทธิ์การเข้าถึงข้อมูล')

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
            padding: 76px 14px 104px;
            background: linear-gradient(180deg, #ffffff 0%, #f7f8fc 26%, #f4f6fb 100%);
            box-shadow: 0 0 0 1px rgba(17, 24, 39, 0.03);
        }

        .mobile-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 14px 10px;
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
            font-size: 1.02rem;
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
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 10px;
        }

        .lead-copy {
            font-size: 0.92rem;
            color: #4b5563;
            line-height: 1.65;
            margin: 0;
        }

        .status-banner {
            border-radius: 18px;
            padding: 12px 14px;
            border: 1px solid rgba(17, 24, 39, 0.08);
            background: #f8faff;
            color: #334155;
            margin-bottom: 12px;
        }

        .status-banner.is-consented {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: rgba(37, 99, 235, 0.14);
        }

        .status-banner.is-not-given {
            background: #f3f4f6;
            color: #6b7280;
            border-color: rgba(148, 163, 184, 0.2);
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 40px;
            padding: 8px 12px;
            border-radius: 999px;
            border: 1px solid rgba(17, 24, 39, 0.08);
            background: #fff;
            color: #374151;
            font-weight: 700;
            font-size: 0.9rem;
            width: fit-content;
        }

        .status-chip.is-consented {
            background: rgba(34, 197, 94, 0.14);
            color: #166534;
        }

        .status-chip.is-not-given {
            background: rgba(148, 163, 184, 0.12);
            color: #475569;
        }

        .permission-card {
            border-radius: 18px;
            border: 1px solid rgba(17, 24, 39, 0.08);
            background: #fff;
            padding: 12px;
            display: grid;
            gap: 10px;
        }

        .permission-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .permission-title {
            font-size: 0.94rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 4px;
        }

        .permission-meta {
            font-size: 0.86rem;
            color: #64748b;
            margin: 0;
        }

        .permission-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .permission-badge.is-active {
            background: rgba(34, 197, 94, 0.14);
            color: #166534;
        }

        .permission-badge.is-revoked {
            background: rgba(244, 63, 94, 0.12);
            color: #9f1239;
        }

        .permission-grid {
            display: grid;
            gap: 8px;
        }

        .permission-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 16px;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.16);
        }

        .permission-row i {
            color: #4552d0;
        }

        .permission-row span {
            font-size: 0.87rem;
            color: #334155;
        }

        .form-label {
            font-size: 0.86rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            min-height: 44px;
            border-radius: 14px;
            border-color: rgba(17, 24, 39, 0.10);
        }

        .action-row {
            display: grid;
            gap: 10px;
        }

        .action-row .btn {
            min-height: 48px;
            border-radius: 14px;
            font-weight: 700;
        }

        .permission-list {
            display: grid;
            gap: 10px;
        }

        .small-note {
            font-size: 0.84rem;
            color: #64748b;
        }

        @media (min-width: 768px) {
            .mobile-shell {
                border-left: 1px solid rgba(17, 24, 39, 0.06);
                border-right: 1px solid rgba(17, 24, 39, 0.06);
            }
        }
    </style>
@endsection

@section('content')
    @php
        $statusLabel = match ($consentStatus) {
            'consented' => 'ให้ความยินยอมแล้ว',
            default => 'ยังไม่ได้ให้ความยินยอม',
        };
    @endphp

    <div class="mobile-shell">
        <div class="mobile-topbar">
            <button type="button" class="mobile-topbar-back" aria-label="ย้อนกลับ" onclick="window.history.back()">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </button>
            <h1 class="mobile-topbar-title">{{ $page_title ?? 'สิทธิ์การเข้าถึงข้อมูล' }}</h1>
            <a href="{{ route('app.notifications') }}" class="mobile-topbar-action text-decoration-none" aria-label="การแจ้งเตือน">
                <i class="fa-regular fa-bell fa-lg"></i>
            </a>
        </div>

        <div class="page-card mb-3">
            <div class="status-banner {{ $consentStatus === 'consented' ? 'is-consented' : 'is-not-given' }}">
                <div class="fw-bold mb-1">สถานะความยินยอมก่อนกำหนดสิทธิ์</div>
                <div>{{ $statusLabel }}</div>
            </div>
        </div>

        <div class="page-card mb-3">
            <div class="section-title">เพิ่มผู้ได้รับสิทธิ์</div>
            <p class="lead-copy mb-3">กำหนดผู้รับสิทธิ์แบบ View Only และตรวจสอบ consent ก่อนบันทึก</p>

            <form id="accessForm" method="POST" action="{{ route('app.access.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="image_id">เลือกภาพหรือชุดข้อมูล</label>
                    <select class="form-select" id="image_id" name="image_id" {{ $consentStatus !== 'consented' ? 'disabled' : 'required' }}>
                        <option value="">-- เลือกรายการ --</option>
                        @foreach ($availableImages as $image)
                            <option value="{{ $image->id }}" {{ old('image_id') == $image->id ? 'selected' : '' }}>
                                {{ $image->display_label }} ({{ $image->created_at_text }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="grantee_name">ชื่อผู้รับสิทธิ์</label>
                    <input type="text" class="form-control" id="grantee_name" name="grantee_name" value="{{ old('grantee_name') }}" placeholder="ระบุชื่อผู้ได้รับสิทธิ์" {{ $consentStatus !== 'consented' ? 'disabled' : 'required' }}>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="grantee_role">ประเภทผู้ได้รับสิทธิ์</label>
                    <select class="form-select" id="grantee_role" name="grantee_role" {{ $consentStatus !== 'consented' ? 'disabled' : 'required' }}>
                        <option value="">-- เลือกประเภท --</option>
                        <option value="doctor" {{ old('grantee_role') === 'doctor' ? 'selected' : '' }}>แพทย์</option>
                        <option value="researcher" {{ old('grantee_role') === 'researcher' ? 'selected' : '' }}>นักวิจัย</option>
                        <option value="other" {{ old('grantee_role') === 'other' ? 'selected' : '' }}>อื่น ๆ</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="purpose">วัตถุประสงค์</label>
                    <textarea class="form-control" id="purpose" name="purpose" rows="3" placeholder="เช่น เพื่อประกอบการวินิจฉัย" {{ $consentStatus !== 'consented' ? 'disabled' : 'required' }}>{{ old('purpose', $selectedPurpose === 'research' ? 'เพื่อการวิจัย' : 'เพื่อประกอบการวินิจฉัย') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="permission_note">ความคิดเห็น / คำแนะนำ</label>
                    <textarea class="form-control" id="permission_note" name="permission_note" rows="2" placeholder="ข้อความเพิ่มเติม (ถ้ามี)" {{ $consentStatus !== 'consented' ? 'disabled' : '' }}>{{ old('permission_note') }}</textarea>
                </div>

                <div class="small-note mb-3">ระดับสิทธิ์ถูกกำหนดเป็น <strong>View Only</strong> อัตโนมัติ</div>

                <div class="action-row">
                    @if ($consentStatus !== 'consented')
                        <button type="button" class="btn btn-secondary" disabled>กรุณาให้ความยินยอมก่อน</button>
                    @else
                        <button type="submit" class="btn btn-primary">บันทึกสิทธิ์การเข้าถึง</button>
                    @endif
                </div>
            </form>
        </div>

        <div class="page-card mb-3">
            <div class="section-title">รายชื่อผู้ได้รับสิทธิ์</div>
            @if ($permissions->isEmpty())
                <p class="lead-copy mb-0">ยังไม่มีรายการสิทธิ์การเข้าถึงข้อมูล</p>
            @else
                <div class="permission-list">
                    @foreach ($permissions as $permission)
                        <div class="permission-card">
                            <div class="permission-head">
                                <div>
                                    <div class="permission-title">{{ $permission->grantee_name }}</div>
                                    <p class="permission-meta">ประเภท: {{ $permission->grantee_role_label ?? '-' }}</p>
                                    <p class="permission-meta">วัตถุประสงค์: {{ $permission->purpose ?? '-' }}</p>
                                </div>
                                <span class="permission-badge {{ $permission->status === 'active' ? 'is-active' : 'is-revoked' }}">
                                    {{ $permission->status === 'active' ? 'active' : 'revoked' }}
                                </span>
                            </div>

                            <div class="permission-grid">
                                <div class="permission-row">
                                    <i class="fa-regular fa-images"></i>
                                    <span>{{ $permission->image_label }} | {{ $permission->image_total }} ภาพ</span>
                                </div>
                                <div class="permission-row">
                                    <i class="fa-solid fa-shield-halved"></i>
                                    <span>ระดับสิทธิ์: {{ $permission->permission_level_label ?? $permission->permission_level }}</span>
                                </div>
                                <div class="permission-row">
                                    <i class="fa-regular fa-calendar"></i>
                                    <span>วันที่ให้สิทธิ์: {{ $permission->created_at_text }}</span>
                                </div>
                                @if ($permission->revoked_at_text)
                                    <div class="permission-row">
                                        <i class="fa-solid fa-ban"></i>
                                        <span>วันที่ยกเลิก: {{ $permission->revoked_at_text }}</span>
                                    </div>
                                @endif
                                <div class="permission-row">
                                    <i class="fa-solid fa-circle-info"></i>
                                    <span>สถานะปัจจุบัน: {{ $permission->status_label ?? $permission->status }}</span>
                                </div>
                            </div>

                            @if ($permission->status === 'active')
                                <form method="POST" action="{{ route('app.access.revoke', $permission->permission_id ?? $permission->id) }}">
                                    @csrf
                                    <button type="button" class="btn btn-outline-danger w-100 js-revoke-access">ยกเลิกสิทธิ์</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="page-card mb-3">
            <div class="section-title">ดูรายละเอียดสิทธิ์</div>
            <p class="lead-copy mb-0">แสดงว่าผู้ใดมีสิทธิ์ดูภาพใด วันที่เริ่มต้น และสถานะปัจจุบันของแต่ละรายการ</p>
        </div>
    </div>

    @include('layouts.mobile-nav')

    <script>
        (function() {
            const accessForm = document.getElementById('accessForm');
            const revokeButtons = document.querySelectorAll('.js-revoke-access');

            if (accessForm) {
                accessForm.addEventListener('submit', async function(event) {
                    if (!accessForm.reportValidity()) {
                        return;
                    }

                    event.preventDefault();

                    const result = await Swal.fire({
                        icon: 'question',
                        title: 'ยืนยันการบันทึกสิทธิ์',
                        text: 'ระบบจะบันทึกสิทธิ์แบบ View Only',
                        showCancelButton: true,
                        confirmButtonText: 'บันทึก',
                        cancelButtonText: 'ยกเลิก',
                    });

                    if (result.isConfirmed) {
                        accessForm.submit();
                    }
                });
            }

            revokeButtons.forEach((button) => {
                button.addEventListener('click', async function() {
                    const form = this.closest('form');
                    const result = await Swal.fire({
                        icon: 'warning',
                        title: 'ยกเลิกสิทธิ์',
                        text: 'ยืนยันการยกเลิกสิทธิ์นี้หรือไม่',
                        showCancelButton: true,
                        confirmButtonText: 'ยกเลิกสิทธิ์',
                        cancelButtonText: 'ยกเลิก',
                        confirmButtonColor: '#dc2626',
                    });

                    if (result.isConfirmed && form) {
                        form.submit();
                    }
                });
            });
        })();
    </script>
@endsection
