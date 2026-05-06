@extends('layouts.app')
@section('page_title', $page_title ?? 'การยินยอมและการแชร์ข้อมูล')

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

        .status-banner.is-not-given {
            background: #f3f4f6;
            color: #6b7280;
            border-color: rgba(148, 163, 184, 0.2);
        }

        .status-banner.is-consented {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: rgba(37, 99, 235, 0.14);
        }

        .status-banner.is-withdrawn {
            background: #fff1f2;
            color: #be123c;
            border-color: rgba(244, 63, 94, 0.14);
        }

        .status-grid {
            display: grid;
            gap: 8px;
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

        .status-chip.is-withdrawn {
            background: rgba(244, 63, 94, 0.12);
            color: #9f1239;
        }

        .purpose-list {
            display: grid;
            gap: 8px;
        }

        .purpose-item {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding: 10px 12px;
            border-radius: 16px;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.16);
        }

        .purpose-item i {
            color: #4552d0;
            margin-top: 2px;
        }

        .purpose-item strong {
            display: block;
            color: #1f2937;
            font-size: 0.92rem;
            margin-bottom: 2px;
        }

        .purpose-item span {
            display: block;
            color: #64748b;
            font-size: 0.86rem;
            line-height: 1.55;
        }

        .consent-check {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 12px;
            border-radius: 16px;
            border: 1px solid rgba(17, 24, 39, 0.08);
            background: #fff;
        }

        .consent-check input {
            margin-top: 4px;
            width: 18px;
            height: 18px;
            accent-color: #4552d0;
        }

        .consent-check strong {
            display: block;
            color: #1f2937;
            font-size: 0.92rem;
            margin-bottom: 2px;
        }

        .consent-check span {
            display: block;
            color: #64748b;
            font-size: 0.86rem;
            line-height: 1.55;
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
            'withdrawn' => 'ถอนความยินยอมแล้ว',
            default => 'ยังไม่ได้ให้ความยินยอม',
        };

        $statusClass = match ($consentStatus) {
            'consented' => 'is-consented',
            'withdrawn' => 'is-withdrawn',
            default => 'is-not-given',
        };

        $saveDisabled = $consentStatus === 'consented';
        $withdrawDisabled = $consentStatus !== 'consented';
    @endphp

    <div class="mobile-shell">
        <div class="mobile-topbar">
            <button type="button" class="mobile-topbar-back" aria-label="ย้อนกลับ" onclick="window.history.back()">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </button>
            <h1 class="mobile-topbar-title">{{ $page_title ?? 'การยินยอมและการแชร์ข้อมูล' }}</h1>
            <a href="{{ route('app.notifications') }}" class="mobile-topbar-action text-decoration-none" aria-label="การแจ้งเตือน">
                <i class="fa-regular fa-bell fa-lg"></i>
            </a>
        </div>

        <div class="page-card mb-3">
            <div class="status-banner {{ $statusClass }}">
                <div class="fw-bold mb-1">สถานะความยินยอมปัจจุบัน</div>
                <div>{{ $statusLabel }}</div>
            </div>

            <div class="status-grid">
                <div class="status-chip {{ $statusClass }}">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ $statusLabel }}
                </div>
                @if ($consentGivenAtText)
                    <div class="small-note">วันที่ให้ความยินยอมล่าสุด: {{ $consentGivenAtText }}</div>
                @endif
                @if ($consentWithdrawnAtText)
                    <div class="small-note">วันที่ถอนความยินยอมล่าสุด: {{ $consentWithdrawnAtText }}</div>
                @endif
                @if (!empty($consentRecord?->consent_note))
                    <div class="small-note">หมายเหตุ: {{ $consentRecord->consent_note }}</div>
                @endif
            </div>
        </div>

        <div class="page-card mb-3">
            <div class="section-title">วัตถุประสงค์</div>
            <p class="lead-copy mb-3">
                ให้ผู้ใช้รับทราบวัตถุประสงค์การใช้ข้อมูล ให้ความยินยอม ถอนความยินยอม และแชร์ภาพให้แพทย์หรือเพื่อการวิจัย
            </p>
            <div class="purpose-list">
                <div class="purpose-item">
                    <i class="fa-solid fa-database"></i>
                    <div>
                        <strong>เพื่อจัดเก็บภาพโรคผิวหนัง</strong>
                        <span>ใช้จัดเก็บภาพและข้อมูลประกอบภายในระบบต้นแบบ</span>
                    </div>
                </div>
                <div class="purpose-item">
                    <i class="fa-solid fa-stethoscope"></i>
                    <div>
                        <strong>เพื่อใช้ประกอบการดูแลรักษา</strong>
                        <span>สนับสนุนการพิจารณาทางคลินิกและการติดตามอาการ</span>
                    </div>
                </div>
                <div class="purpose-item">
                    <i class="fa-solid fa-user-doctor"></i>
                    <div>
                        <strong>เพื่อส่งต่อให้แพทย์ตามที่ผู้ใช้อนุญาต</strong>
                        <span>กำหนดได้ตามสิทธิ์การเข้าถึงข้อมูลของผู้เข้าร่วม</span>
                    </div>
                </div>
                <div class="purpose-item">
                    <i class="fa-solid fa-flask"></i>
                    <div>
                        <strong>เพื่อการวิจัย เฉพาะกรณีที่ผู้ใช้เลือกอนุญาต</strong>
                        <span>ใช้เฉพาะข้อมูลที่ได้รับอนุญาตและไม่ระบุตัวตนตามเงื่อนไขโครงการ</span>
                    </div>
                </div>
            </div>
        </div>

        <form id="consentForm" method="POST" action="{{ route('app.consent.store') }}">
            @csrf
            <div class="page-card mb-3">
                <div class="section-title">ให้ความยินยอม</div>
                <p class="lead-copy mb-3">กรุณาติ๊กยินยอมให้จัดเก็บข้อมูลภาพเป็นข้อบังคับ ข้ออื่นเลือกได้ตามความเหมาะสม</p>

                <div class="d-grid gap-2">
                    <label class="consent-check">
                        <input type="checkbox" name="consent_storage" value="1" {{ old('consent_storage', $consentRecord?->consent_storage ?? 0) ? 'checked' : '' }} {{ $saveDisabled ? 'disabled' : 'required' }}>
                        <div>
                            <strong>ยินยอมให้จัดเก็บข้อมูลภาพ <span class="text-danger">*</span></strong>
                            <span>อนุญาตให้ระบบบันทึกและจัดเก็บภาพโรคผิวหนังของท่าน</span>
                        </div>
                    </label>

                    <label class="consent-check">
                        <input type="checkbox" name="consent_treatment" value="1" {{ old('consent_treatment', $consentRecord?->consent_treatment ?? 0) ? 'checked' : '' }} {{ $saveDisabled ? 'disabled' : '' }}>
                        <div>
                            <strong>ยินยอมให้ใช้ข้อมูลเพื่อประกอบการดูแลรักษา</strong>
                            <span>อนุญาตให้ใช้ภาพและข้อมูลประกอบเพื่อช่วยการดูแลรักษา</span>
                        </div>
                    </label>

                    <label class="consent-check">
                        <input type="checkbox" name="consent_doctor" value="1" {{ old('consent_doctor', $consentRecord ? ($consentRecord->consent_storage && $consentRecord->consent_treatment) : 0) ? 'checked' : '' }} {{ $saveDisabled ? 'disabled' : '' }}>
                        <div>
                            <strong>ยินยอมให้แชร์ข้อมูลให้แพทย์ที่ตนกำหนด</strong>
                            <span>ข้อมูลจะถูกส่งต่อเฉพาะผู้ที่ผู้ใช้อนุญาต</span>
                        </div>
                    </label>

                    <label class="consent-check">
                        <input type="checkbox" name="consent_research" value="1" {{ old('consent_research', $consentRecord?->consent_research ?? 0) ? 'checked' : '' }} {{ $saveDisabled ? 'disabled' : '' }}>
                        <div>
                            <strong>ยินยอมให้ใช้ข้อมูลเพื่อการวิจัยโดยไม่ระบุตัวตน</strong>
                            <span>เป็นทางเลือกเพิ่มเติม หากท่านประสงค์ให้ข้อมูลถูกใช้เพื่อการวิจัย</span>
                        </div>
                    </label>
                </div>

                <div class="mt-3">
                    <label class="form-label" for="consent_note">หมายเหตุ / เงื่อนไขเพิ่มเติม</label>
                    <textarea class="form-control" id="consent_note" name="consent_note" rows="3" {{ $saveDisabled ? 'disabled' : '' }} placeholder="ระบุรายละเอียดเพิ่มเติมได้">{{ old('consent_note', $consentRecord?->consent_note) }}</textarea>
                </div>

                <div class="action-row mt-3">
                    @if ($saveDisabled)
                        <button type="button" class="btn btn-success" disabled>บันทึกความยินยอมแล้ว</button>
                    @else
                        <button type="submit" class="btn btn-primary">บันทึกความยินยอม</button>
                    @endif
                </div>
            </div>
        </form>

        <div class="page-card mb-3">
            <div class="section-title">แชร์ข้อมูล</div>
            <p class="lead-copy mb-3">
                เลือกแนวทางแชร์ภาพสำหรับแพทย์หรือเพื่อการวิจัย แล้วไปกำหนดสิทธิ์การเข้าถึงข้อมูลต่อในหน้าถัดไป
            </p>

            <div class="d-grid gap-2">
                <a href="{{ route('app.access', ['purpose' => 'doctor']) }}" class="btn btn-outline-primary js-consent-share" data-target="{{ route('app.access', ['purpose' => 'doctor']) }}" data-consent-status="{{ $consentStatus }}">
                    แชร์ให้แพทย์
                </a>
                <a href="{{ route('app.access', ['purpose' => 'research']) }}" class="btn btn-outline-primary js-consent-share" data-target="{{ route('app.access', ['purpose' => 'research']) }}" data-consent-status="{{ $consentStatus }}">
                    แชร์เพื่อการวิจัย
                </a>
            </div>
            <div class="small-note mt-2">
                ถ้ายังไม่ได้ให้ความยินยอม ระบบจะให้ดำเนินการยินยอมก่อน
            </div>
        </div>

        <div class="page-card mb-3">
            <div class="section-title">ถอนความยินยอม</div>
            <p class="lead-copy mb-3">
                การถอนความยินยอมจะระงับการใช้งานข้อมูลที่เกี่ยวข้องและบันทึกเหตุการณ์ไว้ในระบบ
            </p>

            <form id="withdrawForm" method="POST" action="{{ route('app.consent.withdraw') }}">
                @csrf
                <input type="hidden" name="consent_note" id="withdrawConsentNote" value="{{ old('consent_note', $consentRecord?->consent_note) }}">
                <button type="button" class="btn btn-outline-danger w-100" id="withdrawBtn" {{ $withdrawDisabled ? 'disabled' : '' }}>
                    ถอนความยินยอม
                </button>
            </form>
        </div>
    </div>

    @include('layouts.mobile-nav')

    <script>
        (function() {
            const consentForm = document.getElementById('consentForm');
            const withdrawBtn = document.getElementById('withdrawBtn');
            const withdrawForm = document.getElementById('withdrawForm');
            const withdrawConsentNote = document.getElementById('withdrawConsentNote');
            const consentNote = document.getElementById('consent_note');
            const shareButtons = document.querySelectorAll('.js-consent-share');

            if (consentForm) {
                consentForm.addEventListener('submit', async function(event) {
                    if (!consentForm.reportValidity()) {
                        return;
                    }

                    event.preventDefault();

                    const result = await Swal.fire({
                        icon: 'question',
                        title: 'ยืนยันการบันทึกความยินยอม',
                        text: 'ตรวจสอบรายการที่ให้ความยินยอมให้ครบถ้วนก่อนบันทึก',
                        showCancelButton: true,
                        confirmButtonText: 'บันทึก',
                        cancelButtonText: 'ยกเลิก',
                        allowOutsideClick: false,
                        allowEscapeKey: true,
                    });

                    if (result.isConfirmed) {
                        consentForm.submit();
                    }
                });
            }

            if (withdrawBtn && withdrawForm) {
                withdrawBtn.addEventListener('click', async function() {
                    const result = await Swal.fire({
                        icon: 'warning',
                        title: 'ถอนความยินยอม',
                        text: 'ยืนยันการถอนความยินยอมของข้อมูลนี้หรือไม่',
                        showCancelButton: true,
                        confirmButtonText: 'ถอนความยินยอม',
                        cancelButtonText: 'ยกเลิก',
                        confirmButtonColor: '#dc2626',
                        allowOutsideClick: false,
                        allowEscapeKey: true,
                    });

                    if (result.isConfirmed) {
                        if (withdrawConsentNote && consentNote) {
                            withdrawConsentNote.value = consentNote.value;
                        }
                        withdrawForm.submit();
                    }
                });
            }

            shareButtons.forEach((button) => {
                button.addEventListener('click', function(event) {
                    const consentStatus = this.getAttribute('data-consent-status');
                    const target = this.getAttribute('data-target');

                    if (consentStatus !== 'consented') {
                        event.preventDefault();
                        Swal.fire({
                            icon: 'info',
                            title: 'กรุณาให้ความยินยอมก่อน',
                            text: 'ถ้าต้องการแชร์ข้อมูล กรุณาบันทึกความยินยอมก่อน',
                        });
                        return;
                    }

                    event.preventDefault();
                    window.location.href = target;
                });
            });
        })();
    </script>
@endsection
