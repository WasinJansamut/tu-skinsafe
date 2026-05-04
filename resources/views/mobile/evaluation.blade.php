@extends('layouts.app')
@section('page_title', $page_title ?? 'แบบประเมินผลการใช้งานระบบต้นแบบ')

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
            padding: 76px 14px 108px;
            background: linear-gradient(180deg, #ffffff 0%, #f7f8fc 28%, #f4f6fb 100%);
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

        .status-banner.is-disabled {
            background: #f3f4f6;
            color: #6b7280;
            border-color: rgba(148, 163, 184, 0.2);
        }

        .status-banner.is-ready {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: rgba(37, 99, 235, 0.14);
        }

        .status-banner.is-done {
            background: #f0fdf4;
            color: #166534;
            border-color: rgba(34, 197, 94, 0.18);
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

        .form-control:disabled,
        .form-select:disabled,
        .form-check-input:disabled {
            opacity: 1;
            background-color: #f3f4f6;
        }

        .gender-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
        }

        .gender-choice {
            position: relative;
        }

        .gender-choice input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .gender-choice span {
            min-height: 72px;
            border-radius: 16px;
            border: 1px solid rgba(17, 24, 39, 0.08);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 8px;
            text-align: center;
            font-size: 0.85rem;
            font-weight: 700;
            color: #475569;
            background: #ffffff;
        }

        .gender-choice i {
            font-size: 1.1rem;
        }

        .gender-choice--male span {
            color: #4552d0;
        }

        .gender-choice--female span {
            color: #c2410c;
        }

        .gender-choice--other span {
            color: #166534;
        }

        .gender-choice input:checked + span {
            border-color: rgba(69, 82, 208, 0.22);
            box-shadow: 0 0 0 2px rgba(69, 82, 208, 0.08);
            filter: saturate(1.15) brightness(0.96);
            transform: translateY(-1px);
        }

        .gender-choice--male input:checked + span {
            background: rgba(69, 82, 208, 0.16);
            color: #1e3a8a;
        }

        .gender-choice--female input:checked + span {
            background: rgba(240, 138, 36, 0.18);
            color: #9a3412;
        }

        .gender-choice--other input:checked + span {
            background: rgba(34, 197, 94, 0.18);
            color: #14532d;
        }

        .scale-table {
            display: grid;
            gap: 10px;
        }

        .scale-item {
            border-radius: 16px;
            border: 1px solid rgba(17, 24, 39, 0.06);
            background: #ffffff;
            padding: 12px;
        }

        .scale-question {
            font-size: 0.88rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 10px;
            line-height: 1.5;
        }

        .scale-options {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 6px;
        }

        .scale-choice {
            position: relative;
        }

        .scale-choice input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .scale-choice span {
            display: block;
            text-align: center;
            border-radius: 12px;
            border: 1px solid rgba(17, 24, 39, 0.08);
            padding: 10px 0;
            font-size: 0.84rem;
            font-weight: 700;
            color: #475569;
            background: #ffffff;
        }

        .scale-choice:nth-child(1) span {
            color: #166534;
        }

        .scale-choice:nth-child(2) span {
            color: #166534;
        }

        .scale-choice:nth-child(3) span {
            color: #b45309;
        }

        .scale-choice:nth-child(4) span {
            color: #c2410c;
        }

        .scale-choice:nth-child(5) span {
            color: #b91c1c;
        }

        .scale-choice input:checked + span {
            transform: translateY(-1px);
            box-shadow: 0 0 0 2px rgba(69, 82, 208, 0.10);
            border-color: rgba(69, 82, 208, 0.24);
        }

        .scale-choice:nth-child(1) input:checked + span {
            background: rgba(34, 197, 94, 0.18);
            color: #14532d;
        }

        .scale-choice:nth-child(2) input:checked + span {
            background: rgba(34, 197, 94, 0.14);
            color: #14532d;
        }

        .scale-choice:nth-child(3) input:checked + span {
            background: rgba(245, 158, 11, 0.18);
            color: #92400e;
        }

        .scale-choice:nth-child(4) input:checked + span {
            background: rgba(249, 115, 22, 0.18);
            color: #9a3412;
        }

        .scale-choice:nth-child(5) input:checked + span {
            background: rgba(239, 68, 68, 0.18);
            color: #991b1b;
        }

        .text-block {
            min-height: 112px;
            resize: vertical;
        }

        .submit-card {
            padding: 0;
            background: transparent;
            border: 0;
            box-shadow: none;
        }

        .submit-card .btn {
            min-height: 48px;
            border-radius: 14px;
            font-weight: 700;
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
    </style>
@endsection

@section('content')
    @php
        $items = [
            'หน้าหลักของระบบช่วยให้เข้าใจภาพรวมของข้อมูลได้ชัดเจน',
            'ฟังก์ชันถ่ายภาพหรืออัปโหลดภาพใช้งานได้ง่ายและเหมาะสม',
            'การกรอกข้อมูลประกอบภาพ เช่น อาการ ตำแหน่ง หรือหมายเหตุ มีความชัดเจน',
            'คลังภาพของฉันช่วยให้ตรวจสอบภาพย้อนหลังได้สะดวก',
            'การดู แก้ไข หรือลบข้อมูลภาพสามารถเข้าใจได้ง่าย',
            'หน้าการยินยอมและการแชร์ข้อมูลแสดงวัตถุประสงค์การใช้ข้อมูลได้ชัดเจน',
            'ระบบช่วยให้รู้สึกว่าสามารถควบคุมการให้หรือถอนความยินยอมได้',
            'หน้าสิทธิ์การเข้าถึงข้อมูลช่วยให้เข้าใจว่าใครสามารถเข้าถึงข้อมูลของตนได้',
            'การกำหนดสิทธิ์แบบดูข้อมูลเท่านั้นมีความเหมาะสมกับข้อมูลภาพทางการแพทย์',
            'หน้าประวัติการเข้าถึงและการแจ้งเตือนช่วยให้ตรวจสอบการใช้ข้อมูลย้อนหลังได้',
            'ระบบทำให้เกิดความเชื่อมั่นต่อการคุ้มครองข้อมูลส่วนบุคคล',
            'ระบบมีรูปแบบหน้าจอที่ใช้งานง่าย เหมาะกับการใช้งานผ่านสมาร์ทโฟน',
            'ฟังก์ชันหลักของระบบมีความเหมาะสมกับการจัดเก็บและส่งต่อภาพถ่ายโรคผิวหนัง',
            'โดยรวมแล้วระบบต้นแบบมีประโยชน์ต่อการติดตามหรือจัดการข้อมูลภาพโรคผิวหนัง',
            'โดยรวมแล้วท่านพึงพอใจต่อระบบต้นแบบ',
        ];
        $disabled = $completed;
    @endphp

    <div class="mobile-shell">
        <div class="mobile-topbar">
            <button type="button" class="mobile-topbar-back" aria-label="ย้อนกลับ" onclick="window.history.back()">
                <i class="fa-solid fa-arrow-left fa-lg"></i>
            </button>
            <h1 class="mobile-topbar-title">{{ $page_title ?? 'แบบประเมินผลการใช้งานระบบต้นแบบ' }}</h1>
            <a href="{{ route('app.notifications') }}" class="mobile-topbar-action text-decoration-none" aria-label="การแจ้งเตือน">
                <i class="fa-regular fa-bell fa-lg"></i>
            </a>
        </div>

        <div class="page-card mb-3">
            @if (! $ready)
                <div class="status-banner is-disabled">
                    เปิดให้ทำแบบประเมินชั่วคราว กรุณาใช้งานระบบให้ครบทุกฟังก์ชั่นก่อนส่งแบบประเมิน
                </div>
            @elseif ($completed)
                <div class="status-banner is-done">
                    ทำแบบประเมินครบถ้วนแล้ว
                </div>
            @else
                <div class="status-banner is-ready">
                    พร้อมทำแบบประเมินผลการใช้งานระบบต้นแบบ
                </div>
            @endif

            <p class="lead-copy mb-0">
                แบบประเมินนี้แบ่งเป็น 3 ส่วน ได้แก่ ข้อมูลทั่วไป, การประเมินการใช้งานระบบ และข้อเสนอแนะเพิ่มเติม
            </p>
        </div>

        @if ($completed && !empty($evaluationResponse))
            @php
                $general = $evaluationResponse->general_answers ?? [];
                $open = $evaluationResponse->open_answers ?? [];
                $scaleAverage = $evaluationSummary['scale_average'] ?? null;
            @endphp

            <div class="page-card mb-3">
                <div class="section-title">ผลการประเมินที่บันทึกแล้ว</div>

                <div class="d-grid gap-2">
                    <div class="permission-row">
                        <i class="fa-solid fa-user"></i>
                        <span>อายุ {{ $general['age'] ?? '-' }} ปี</span>
                    </div>
                    <div class="permission-row">
                        <i class="fa-solid fa-venus-mars"></i>
                        <span>เพศ {{ match ($general['gender'] ?? null) {
                            'male' => 'ชาย',
                            'female' => 'หญิง',
                            'other' => ! empty($general['gender_other']) ? $general['gender_other'] : 'อื่นๆ',
                            default => '-',
                        } }}</span>
                    </div>
                    <div class="permission-row">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>ระดับการศึกษา {{ match ($general['education'] ?? null) {
                            'below_bachelor' => 'ต่ำกว่าปริญญาตรี',
                            'bachelor' => 'ปริญญาตรี',
                            'higher' => 'สูงกว่าปริญญาตรี',
                            default => '-',
                        } }}</span>
                    </div>
                    <div class="permission-row">
                        <i class="fa-solid fa-star"></i>
                        <span>คะแนนเฉลี่ยแบบประเมิน {{ $scaleAverage !== null ? number_format($scaleAverage, 2) . ' / 5' : '-' }}</span>
                    </div>
                    <div class="permission-row">
                        <i class="fa-solid fa-comment-dots"></i>
                        <span>ข้อเสนอแนะที่บันทึกแล้ว {{ !empty($open['section3_4']) ? 'มี' : 'ไม่มี' }}</span>
                    </div>
                </div>
            </div>
        @endif

        <form id="evaluationForm" method="POST" action="{{ route('app.evaluation.store') }}">
            @csrf

            <div class="page-card mb-3">
                <div class="section-title">ส่วนที่ 1: ข้อมูลทั่วไปของผู้ตอบแบบประเมิน</div>

                <div class="mb-3">
                    <label class="form-label" for="age">อายุ</label>
                    <input type="number" min="1" max="120" class="form-control" id="age" name="age" value="{{ old('age') }}" {{ $disabled ? 'disabled' : 'required' }}>
                </div>

                <div class="mb-3">
                    <label class="form-label">เพศ</label>
                    <div class="gender-grid">
                        <label class="gender-choice gender-choice--male">
                            <input type="radio" name="gender" value="male" {{ old('gender') === 'male' ? 'checked' : '' }} {{ $disabled ? 'disabled' : '' }}>
                            <span><i class="fa-solid fa-mars"></i> ชาย</span>
                        </label>
                        <label class="gender-choice gender-choice--female">
                            <input type="radio" name="gender" value="female" {{ old('gender') === 'female' ? 'checked' : '' }} {{ $disabled ? 'disabled' : '' }}>
                            <span><i class="fa-solid fa-venus"></i> หญิง</span>
                        </label>
                        <label class="gender-choice gender-choice--other">
                            <input type="radio" name="gender" value="other" {{ old('gender') === 'other' ? 'checked' : '' }} {{ $disabled ? 'disabled' : '' }}>
                            <span><i class="fa-solid fa-genderless"></i> อื่นๆ</span>
                        </label>
                    </div>
                    <input type="text" class="form-control mt-2" name="gender_other" placeholder="ระบุอื่นๆ" value="{{ old('gender_other') }}" {{ $disabled ? 'disabled' : '' }}>
                </div>

                <div class="mb-3">
                    <label class="form-label">ระดับการศึกษา</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ([
                            'below_bachelor' => 'ต่ำกว่าปริญญาตรี',
                            'bachelor' => 'ปริญญาตรี',
                            'higher' => 'สูงกว่าปริญญาตรี',
                        ] as $value => $label)
                            <label class="btn btn-outline-primary rounded-pill px-3">
                                <input type="radio" class="form-check-input me-1" name="education" value="{{ $value }}" {{ old('education') === $value ? 'checked' : '' }} {{ $disabled ? 'disabled' : '' }}>
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">เคยเข้ารับการรักษาโรคผิวหนังมากี่ครั้ง?</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ([
                            '1_2' => '1–2 ครั้ง',
                            '3_5' => '3–5 ครั้ง',
                            'more_5' => 'มากกว่า 5 ครั้ง',
                        ] as $value => $label)
                            <label class="btn btn-outline-primary rounded-pill px-3">
                                <input type="radio" class="form-check-input me-1" name="treatment_count" value="{{ $value }}" {{ old('treatment_count') === $value ? 'checked' : '' }} {{ $disabled ? 'disabled' : '' }}>
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="form-label">เคยใช้ telemedicine หรือเคยส่งภาพให้แพทย์ผ่านช่องทางออนไลน์หรือไม่</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ([
                            'yes' => 'เคย',
                            'no' => 'ไม่เคย',
                        ] as $value => $label)
                            <label class="btn btn-outline-primary rounded-pill px-3">
                                <input type="radio" class="form-check-input me-1" name="telemedicine_experience" value="{{ $value }}" {{ old('telemedicine_experience') === $value ? 'checked' : '' }} {{ $disabled ? 'disabled' : '' }}>
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="page-card mb-3">
                <div class="section-title">ส่วนที่ 2: แบบประเมินผลการใช้งานระบบต้นแบบ</div>
                <p class="lead-copy mb-3">โปรดให้คะแนนระดับความคิดเห็นจาก 5 = มากที่สุด ถึง 1 = น้อยที่สุด</p>

                <div class="scale-table">
                    @foreach ($items as $index => $item)
                        <div class="scale-item">
                            <p class="scale-question">{{ $index + 1 }}. {{ $item }}</p>
                            <div class="scale-options">
                                @foreach ([5, 4, 3, 2, 1] as $score)
                                    <label class="scale-choice">
                                        <input type="radio" name="scale_answers[{{ $index + 1 }}]" value="{{ $score }}" {{ old('scale_answers.' . ($index + 1)) == $score ? 'checked' : '' }} {{ $disabled ? 'disabled' : 'required' }}>
                                        <span>{{ $score }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="page-card mb-3">
                <div class="section-title">ส่วนที่ 3: คำถามทั่วไปและข้อเสนอแนะ</div>

                <div class="mb-3">
                    <label class="form-label">1. ส่วนใดของระบบที่ท่านคิดว่าใช้งานง่ายหรือมีประโยชน์มากที่สุด</label>
                    <textarea class="form-control text-block" name="section3_1" {{ $disabled ? 'disabled' : '' }}>{{ old('section3_1') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">2. ส่วนใดของระบบที่ท่านคิดว่ายังใช้งานยากหรือควรปรับปรุง</label>
                    <textarea class="form-control text-block" name="section3_2" {{ $disabled ? 'disabled' : '' }}>{{ old('section3_2') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">3. ท่านมีความกังวลเพิ่มเติมเกี่ยวกับการจัดเก็บหรือการแชร์ภาพโรคผิวหนังหรือไม่</label>
                    <textarea class="form-control text-block" name="section3_3" {{ $disabled ? 'disabled' : '' }}>{{ old('section3_3') }}</textarea>
                </div>

                <div>
                    <label class="form-label">4. ท่านมีข้อเสนอแนะเพิ่มเติมต่อการพัฒนาระบบต้นแบบหรือไม่</label>
                    <textarea class="form-control text-block" name="section3_4" {{ $disabled ? 'disabled' : '' }}>{{ old('section3_4') }}</textarea>
                </div>
            </div>

            <div class="page-card submit-card mb-4">
                @if ($completed)
                    <button type="button" class="btn btn-success w-100" disabled>ทำแบบประเมินครบถ้วนแล้ว</button>
                @elseif (! $ready)
                    <button type="submit" class="btn btn-secondary w-100">บันทึกแบบประเมิน</button>
                @else
                    <button type="submit" class="btn btn-primary w-100">บันทึกแบบประเมิน</button>
                @endif
            </div>
        </form>
    </div>

    @include('layouts.mobile-nav')

    <script>
        (function() {
            const form = document.getElementById('evaluationForm');
            if (!form) return;

            form.addEventListener('submit', async function(event) {
                const submitter = event.submitter;
                if (submitter && submitter.disabled) {
                    event.preventDefault();
                    return;
                }

                event.preventDefault();

                const result = await Swal.fire({
                    icon: 'question',
                    title: 'ยืนยันการบันทึกแบบประเมิน',
                    text: 'ตรวจสอบข้อมูลให้ครบถ้วนก่อนบันทึก',
                    showCancelButton: true,
                    confirmButtonText: 'บันทึก',
                    cancelButtonText: 'ยกเลิก',
                    allowOutsideClick: false,
                    allowEscapeKey: true,
                });

                if (result.isConfirmed) {
                    form.submit();
                }
            });
        })();
    </script>
@endsection
