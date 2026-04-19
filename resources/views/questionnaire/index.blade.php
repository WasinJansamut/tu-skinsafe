<!doctype html>
<html lang="th" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>แบบสอบถามยืนยันความต้องการของผู้ใช้ : {{ config('app.name') ?? 'NOT FOUND' }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}">
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/css/hope-ui.min.css') }}">
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/css/pro.min.css') }}">
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/css/custom.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.min.css') }}">
    <link href="{{ asset('assets/sweetalert2/css/sweetalert2.min.css') }}" rel="stylesheet" />

    <style>
        .questionnaire-shell {
            background: #f5f7fb;
            min-height: 100vh;
        }

        .section-card {
            border: 1px solid #e4e8f0;
            border-radius: 8px;
        }

        .likert-group {
            display: grid;
            grid-template-columns: repeat(5, minmax(52px, 1fr));
            gap: 8px;
        }

        .likert-option input[type="radio"] {
            display: none;
        }

        .likert-option label {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            background: #fff;
            cursor: pointer;
            font-weight: 400;
            margin: 0;
            color: #212529;
            transition: all 0.15s ease-in-out;
        }

        .form-check-label {
            font-weight: 400;
        }

        .required-mark {
            color: #dc3545;
            font-weight: 700;
        }

        .scale-box {
            color: #fff;
        }

        .scale-5 {
            border-color: #198754 !important;
            color: #198754 !important;
        }

        .scale-4 {
            border-color: #5abf69 !important;
            color: #5abf69 !important;
        }

        .scale-3 {
            border-color: #ffc107 !important;
            color: #b58100 !important;
        }

        .scale-2 {
            border-color: #fd7e14 !important;
            color: #fd7e14 !important;
        }

        .scale-1 {
            border-color: #dc3545 !important;
            color: #dc3545 !important;
        }

        .scale-box.scale-5 {
            background: #198754;
            color: #fff !important;
        }

        .scale-box.scale-4 {
            background: #5abf69;
            color: #fff !important;
        }

        .scale-box.scale-3 {
            background: #ffc107;
            color: #212529 !important;
        }

        .scale-box.scale-2 {
            background: #fd7e14;
            color: #fff !important;
        }

        .scale-box.scale-1 {
            background: #dc3545;
            color: #fff !important;
        }

        .likert-option input[type="radio"]:checked + .scale-5 {
            background: #198754;
            color: #fff !important;
        }

        .likert-option input[type="radio"]:checked + .scale-4 {
            background: #5abf69;
            color: #fff !important;
        }

        .likert-option input[type="radio"]:checked + .scale-3 {
            background: #ffc107;
            color: #212529 !important;
        }

        .likert-option input[type="radio"]:checked + .scale-2 {
            background: #fd7e14;
            color: #fff !important;
        }

        .likert-option input[type="radio"]:checked + .scale-1 {
            background: #dc3545;
            color: #fff !important;
        }

        .likert-option .scale-5:hover {
            background: #d1e7dd;
        }

        .likert-option .scale-4:hover {
            background: #d9f2dc;
        }

        .likert-option .scale-3:hover {
            background: #fff3cd;
        }

        .likert-option .scale-2:hover {
            background: #ffe5d0;
        }

        .likert-option .scale-1:hover {
            background: #f8d7da;
        }

        .likert-option input[type="radio"]:checked + label {
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.08);
        }

        .likert-help {
            display: grid;
            grid-template-columns: repeat(5, minmax(52px, 1fr));
            gap: 8px;
            margin-top: 8px;
            font-size: 12px;
            color: #6c757d;
            text-align: center;
        }

        .likert-help span {
            line-height: 1.3;
        }

        .missing-focus {
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.18);
            border-radius: 8px;
            transition: box-shadow 0.2s ease-in-out;
        }

        @media (max-width: 767.98px) {
            .likert-group {
                grid-template-columns: repeat(5, minmax(44px, 1fr));
            }

            .likert-help {
                grid-template-columns: repeat(5, minmax(44px, 1fr));
                font-size: 11px;
            }
        }
    </style>
</head>

<body>
    @include('layouts.loading')

    @php
        $scaleLabels = [
            5 => 'เห็นด้วยอย่างยิ่ง',
            4 => 'เห็นด้วย',
            3 => 'ปานกลาง',
            2 => 'ไม่เห็นด้วย',
            1 => 'ไม่เห็นด้วยอย่างยิ่ง',
        ];
    @endphp

    <div class="questionnaire-shell py-4 py-lg-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-11">
                    <div class="text-center mb-4">
                        <img class="mb-3" src="{{ asset('assets/images/logo/logo_horizontal.png') }}" height="72" alt="TU SkinSafe" loading="lazy">
                        <h1 class="h2 mb-2">แบบสอบถามยืนยันความต้องการของผู้ใช้</h1>
                        <div class="text-muted mb-1">Requirement Confirmation Questionnaire (RCQ)</div>
                        <div class="text-muted">สำหรับระบบต้นแบบจัดเก็บและแลกเปลี่ยนภาพถ่ายโรคผิวหนัง</div>
                    </div>

                    @include('layouts.alert')

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนส่งแบบสอบถาม
                        </div>
                    @endif

                    <form action="{{ route('questionnaire.store') }}" method="post" class="d-grid gap-4" novalidate>
                        @csrf

                        <div class="card section-card shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="h4 mb-2">คำชี้แจง</h2>
                                <p class="mb-2">สำหรับผู้ที่เคยป่วยโรคผิวหนัง แบบสอบถามนี้ใช้เพื่อยืนยันข้อกำหนดผู้ใช้ก่อนนำไปออกแบบระบบต้นแบบ</p>
                                <div class="fw-bold mb-2">ระดับคะแนนที่ใช้</div>
                                <div class="row g-2 text-center">
                                    @foreach ($scaleLabels as $score => $label)
                                        <div class="col-6 col-md">
                                            <div class="border rounded py-2 px-2 h-100 scale-box scale-{{ $score }}">
                                                <div class="fw-bold">{{ $score }}</div>
                                                <div class="small">{{ $label }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="card section-card shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="h4 mb-4">ส่วนที่ 1: ข้อมูลทั่วไปของผู้ตอบแบบสอบถาม</h2>
                                <div class="row g-4">
                                    <div class="col-md-4 field-block" id="field-age">
                                        <label for="age" class="form-label">1. อายุ <span class="required-mark">*</span></label>
                                        <div class="input-group">
                                            <input type="number" min="1" max="120" class="form-control @error('age') is-invalid @enderror" id="age" name="age" value="{{ old('age') }}" required>
                                            <span class="input-group-text">ปี</span>
                                        </div>
                                        @error('age')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-8 field-block" id="field-gender">
                                        <label class="form-label d-block">2. เพศ <span class="required-mark">*</span></label>
                                        <div class="d-flex flex-wrap gap-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male" {{ old('gender') === 'male' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="gender_male">ชาย</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female" {{ old('gender') === 'female' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gender_female">หญิง</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="gender_other" value="other" {{ old('gender') === 'other' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="gender_other">อื่นๆ</label>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control @error('gender_other') is-invalid @enderror" id="gender_other_text" name="gender_other" value="{{ old('gender_other') }}" placeholder="กรุณาระบุ" {{ old('gender') === 'other' ? '' : 'disabled' }}>
                                        @error('gender')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        @error('gender_other')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 field-block" id="field-education_level">
                                        <label class="form-label d-block">3. ระดับการศึกษา <span class="required-mark">*</span></label>
                                        <div class="d-grid gap-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="education_level" id="education_below" value="below_bachelor" {{ old('education_level') === 'below_bachelor' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="education_below">ต่ำกว่าปริญญาตรี</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="education_level" id="education_bachelor" value="bachelor" {{ old('education_level') === 'bachelor' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="education_bachelor">ปริญญาตรี</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="education_level" id="education_above" value="above_bachelor" {{ old('education_level') === 'above_bachelor' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="education_above">สูงกว่าปริญญาตรี</label>
                                            </div>
                                        </div>
                                        @error('education_level')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 field-block" id="field-treatment_count">
                                        <label class="form-label d-block">4. เคยเข้ารับการรักษาโรคผิวหนังมากี่ครั้ง <span class="required-mark">*</span></label>
                                        <div class="d-grid gap-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="treatment_count" id="treatment_1_2" value="1-2" {{ old('treatment_count') === '1-2' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="treatment_1_2">1-2 ครั้ง</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="treatment_count" id="treatment_3_5" value="3-5" {{ old('treatment_count') === '3-5' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="treatment_3_5">3-5 ครั้ง</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="treatment_count" id="treatment_more_5" value="more_than_5" {{ old('treatment_count') === 'more_than_5' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="treatment_more_5">มากกว่า 5 ครั้ง</label>
                                            </div>
                                        </div>
                                        @error('treatment_count')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 field-block" id="field-used_telemedicine">
                                        <label class="form-label d-block">5. เคยใช้ telemedicine หรือส่งภาพผิวหนังให้แพทย์ดูมาก่อนหรือไม่ <span class="required-mark">*</span></label>
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="used_telemedicine" id="telemedicine_yes" value="yes" {{ old('used_telemedicine') === 'yes' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="telemedicine_yes">เคย</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="used_telemedicine" id="telemedicine_no" value="no" {{ old('used_telemedicine') === 'no' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="telemedicine_no">ไม่เคย</label>
                                            </div>
                                        </div>
                                        @error('used_telemedicine')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card section-card shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="h4 mb-2">ส่วนที่ 2: แบบประเมินความเห็นด้วยต่อความต้องการของระบบ</h2>
                                <p class="text-muted mb-4">โปรดเลือกคะแนน 1 ถึง 5 สำหรับแต่ละข้อ โดย 5 คือเห็นด้วยอย่างยิ่ง และ 1 คือไม่เห็นด้วยอย่างยิ่ง</p>

                                <div class="d-grid gap-4">
                                    @foreach ($sections as $section)
                                        <div class="border rounded p-3 p-lg-4 bg-white">
                                            <div class="mb-3">
                                                <div class="fw-bold">{{ $section['title'] }}</div>
                                                <div class="small text-muted">{{ $section['subtitle'] }}</div>
                                            </div>

                                            <div class="d-grid gap-4">
                                                @foreach ($section['questions'] as $questionNumber => $questionText)
                                                    <div class="question-item" id="field-q{{ $questionNumber }}">
                                                        <label class="form-label fw-semibold d-block">
                                                            {{ $questionNumber }}. {{ $questionText }} <span class="required-mark">*</span>
                                                        </label>
                                                        <div class="likert-group">
                                                            @for ($score = 5; $score >= 1; $score--)
                                                                <div class="likert-option">
                                                                    <input
                                                                        type="radio"
                                                                        name="q{{ $questionNumber }}"
                                                                        id="q{{ $questionNumber }}_{{ $score }}"
                                                                        value="{{ $score }}"
                                                                        {{ old('q' . $questionNumber) == $score ? 'checked' : '' }}
                                                                        required
                                                                    >
                                                                    <label for="q{{ $questionNumber }}_{{ $score }}" class="scale-{{ $score }}">{{ $score }}</label>
                                                                </div>
                                                            @endfor
                                                        </div>
                                                        <div class="likert-help">
                                                            <span>เห็นด้วยอย่างยิ่ง</span>
                                                            <span>เห็นด้วย</span>
                                                            <span>ปานกลาง</span>
                                                            <span>ไม่เห็นด้วย</span>
                                                            <span>ไม่เห็นด้วยอย่างยิ่ง</span>
                                                        </div>
                                                        @error('q' . $questionNumber)
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="card section-card shadow-sm">
                            <div class="card-body p-4">
                                <h2 class="h4 mb-4">ส่วนที่ 3: ความกังวลและข้อเสนอแนะ</h2>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label for="main_concern" class="form-label">21. ท่านกังวลเรื่องใดมากที่สุด หากมีระบบเก็บและแลกเปลี่ยนข้อมูลภาพถ่ายโรคผิวหนัง</label>
                                        <textarea class="form-control" id="main_concern" name="main_concern" rows="4">{{ old('main_concern') }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="additional_features" class="form-label">22. ท่านคิดว่าระบบแบบนี้ควรมีคุณสมบัติหรือฟังก์ชันใดเพิ่มเติม</label>
                                        <textarea class="form-control" id="additional_features" name="additional_features" rows="4">{{ old('additional_features') }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="other_suggestions" class="form-label">23. ข้อเสนอแนะอื่น ๆ เพื่อปรับปรุงระบบให้เหมาะสมกับผู้ป่วย</label>
                                        <textarea class="form-control" id="other_suggestions" name="other_suggestions" rows="4">{{ old('other_suggestions') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                                <i class="fa-solid fa-arrow-left me-1"></i>
                                กลับหน้าเข้าสู่ระบบ
                            </a>
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="fa-solid fa-paper-plane me-2"></i>
                                ส่งแบบสอบถาม
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>
    <script src="{{ Helper::versionedAsset('assets/js/hope-ui.js') }}"></script>
    <script src="{{ Helper::versionedAsset('assets/js/hope-uipro.js') }}"></script>
    <script src="{{ Helper::versionedAsset('assets/js/sidebar.js') }}"></script>
    <script src="{{ asset('assets/sweetalert2/js/sweetalert2.all.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form[action="{{ route('questionnaire.store') }}"]');
            const genderRadios = document.querySelectorAll('input[name="gender"]');
            const genderOtherInput = document.getElementById('gender_other_text');

            function syncGenderOther() {
                const selected = document.querySelector('input[name="gender"]:checked');
                const enableOther = selected && selected.value === 'other';

                genderOtherInput.disabled = !enableOther;
                if (!enableOther) {
                    genderOtherInput.value = '';
                }
            }

            genderRadios.forEach(function (radio) {
                radio.addEventListener('change', syncGenderOther);
            });

            syncGenderOther();

            const fieldLabels = {
                age: 'ข้อ 1 อายุ',
                gender: 'ข้อ 2 เพศ',
                education_level: 'ข้อ 3 ระดับการศึกษา',
                treatment_count: 'ข้อ 4 เคยเข้ารับการรักษาโรคผิวหนังมากี่ครั้ง',
                used_telemedicine: 'ข้อ 5 เคยใช้ telemedicine หรือส่งภาพผิวหนังให้แพทย์ดูมาก่อนหรือไม่',
                gender_other: 'ข้อ 2 กรุณาระบุเพศ',
            };

            for (let i = 1; i <= 20; i++) {
                const labelNode = document.querySelector('label[for="q' + i + '_5"]')?.closest('div')?.previousElementSibling;
                if (labelNode) {
                    fieldLabels['q' + i] = labelNode.textContent.replace('*', '').trim();
                } else {
                    fieldLabels['q' + i] = 'ข้อ ' + i;
                }
            }

            function focusMissingField(field) {
                if (!field || !field.element) {
                    return;
                }

                document.querySelectorAll('.missing-focus').forEach(function (node) {
                    node.classList.remove('missing-focus');
                });

                const targetBlock = document.getElementById('field-' + field.name) || field.element.closest('.field-block, .question-item, .col-12') || field.element;
                targetBlock.classList.add('missing-focus');
                targetBlock.scrollIntoView({ behavior: 'smooth', block: 'center' });

                const isVisible = !!(field.element.offsetWidth || field.element.offsetHeight || field.element.getClientRects().length);
                if (isVisible) {
                    field.element.focus({ preventScroll: true });
                } else {
                    const targetLabel = targetBlock.querySelector('label[for]');
                    if (targetLabel) {
                        targetLabel.setAttribute('tabindex', '-1');
                        targetLabel.focus({ preventScroll: true });
                    }
                }
            }

            function getMissingFields() {
                const missing = [];

                const ageInput = document.getElementById('age');
                if (!ageInput.value.trim()) {
                    missing.push({ name: 'age', element: ageInput });
                }

                const selectedGender = document.querySelector('input[name="gender"]:checked');
                if (!selectedGender) {
                    missing.push({ name: 'gender', element: document.getElementById('gender_male') });
                } else if (selectedGender.value === 'other' && !genderOtherInput.value.trim()) {
                    missing.push({ name: 'gender_other', element: genderOtherInput });
                }

                const educationInput = document.querySelector('input[name="education_level"]:checked');
                if (!educationInput) {
                    missing.push({ name: 'education_level', element: document.getElementById('education_below') });
                }

                const treatmentInput = document.querySelector('input[name="treatment_count"]:checked');
                if (!treatmentInput) {
                    missing.push({ name: 'treatment_count', element: document.getElementById('treatment_1_2') });
                }

                const telemedicineInput = document.querySelector('input[name="used_telemedicine"]:checked');
                if (!telemedicineInput) {
                    missing.push({ name: 'used_telemedicine', element: document.getElementById('telemedicine_yes') });
                }

                for (let i = 1; i <= 20; i++) {
                    const selectedScore = document.querySelector('input[name="q' + i + '"]:checked');
                    if (!selectedScore) {
                        missing.push({ name: 'q' + i, element: document.getElementById('q' + i + '_5') });
                    }
                }

                return missing;
            }

            form.addEventListener('submit', function (event) {
                const missingFields = getMissingFields();

                if (!missingFields.length) {
                    return;
                }

                event.preventDefault();

                const listHtml = '<ul class="text-start ps-3 mb-0">' + missingFields
                    .map(function (item) {
                        return '<li>' + fieldLabels[item.name] + '</li>';
                    })
                    .join('') + '</ul>';

                Swal.fire({
                    icon: 'warning',
                    title: 'กรอกข้อมูลไม่ครบ',
                    html: '<div class="text-start">กรุณากรอกหรือเลือกข้อมูลต่อไปนี้ให้ครบก่อนส่งแบบสอบถาม</div>' + listHtml,
                    confirmButtonText: 'ตกลง',
                    showCloseButton: true,
                }).then(function () {
                    focusMissingField(missingFields[0]);
                });
            });
        });
    </script>
</body>

</html>
