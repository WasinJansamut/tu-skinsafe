@extends('layouts.app')
@section('page_title', 'ดูข้อมูลแบบสอบถาม')
@section('content')
    <div class="conatiner-fluid content-inner">
        @php
            $genderLabel = match ($response->gender) {
                'male' => 'ชาย',
                'female' => 'หญิง',
                default => 'อื่นๆ' . ($response->gender_other ? ' (' . $response->gender_other . ')' : ''),
            };

            $educationLabel = match ($response->education_level) {
                'below_bachelor' => 'ต่ำกว่าปริญญาตรี',
                'bachelor' => 'ปริญญาตรี',
                default => 'สูงกว่าปริญญาตรี',
            };

            $treatmentLabel = match ($response->treatment_count) {
                '1-2' => '1-2 ครั้ง',
                '3-5' => '3-5 ครั้ง',
                default => 'มากกว่า 5 ครั้ง',
            };
        @endphp

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="px-4 pt-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">หน้าหลัก</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('questionnaire.responses') }}">ข้อมูลแบบสอบถาม</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Record #{{ $response->id }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h3 class="mb-0">รายละเอียดแบบสอบถาม #{{ $response->id }}</h3>
                        <a href="{{ route('questionnaire.responses') }}" class="btn btn-dark">
                            <i class="fa-solid fa-arrow-left me-1"></i>
                            กลับไปรายการ
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">วันที่ตอบ</div>
                                    <div class="fw-semibold">{{ \Carbon\Carbon::parse($response->created_at)->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">อายุ</div>
                                    <div class="fw-semibold">{{ $response->age }} ปี</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">เพศ</div>
                                    <div class="fw-semibold">{{ $genderLabel }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">เคยใช้ telemedicine</div>
                                    <div class="fw-semibold">{{ $response->used_telemedicine ? 'เคย' : 'ไม่เคย' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">ระดับการศึกษา</div>
                                    <div class="fw-semibold">{{ $educationLabel }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">จำนวนครั้งที่เคยรักษาโรคผิวหนัง</div>
                                    <div class="fw-semibold">{{ $treatmentLabel }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">IP Address</div>
                                    <div class="fw-semibold">{{ $response->respondent_ip ?: '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-4">
                            @foreach ($sections as $section)
                                <div class="border rounded p-3 bg-white">
                                    <div class="mb-3">
                                        <div class="fw-bold">{{ $section['title'] }}</div>
                                        <div class="small text-muted">{{ $section['subtitle'] }}</div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 70%;">รายการประเมิน</th>
                                                    <th class="text-center" style="width: 30%;">คะแนน</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($section['questions'] as $questionNumber => $questionText)
                                                    <tr>
                                                        <td>{{ $questionNumber }}. {{ $questionText }}</td>
                                                        <td class="text-center fw-semibold">{{ $response->{'q' . $questionNumber} }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach

                            <div class="border rounded p-3 bg-white">
                                <div class="fw-bold mb-3">ส่วนที่ 3: ความกังวลและข้อเสนอแนะ</div>
                                <div class="mb-3">
                                    <div class="text-muted small">21. ความกังวลหลัก</div>
                                    <div>{{ $response->main_concern ?: '-' }}</div>
                                </div>
                                <div class="mb-3">
                                    <div class="text-muted small">22. คุณสมบัติหรือฟังก์ชันเพิ่มเติม</div>
                                    <div>{{ $response->additional_features ?: '-' }}</div>
                                </div>
                                <div>
                                    <div class="text-muted small">23. ข้อเสนอแนะอื่น ๆ</div>
                                    <div>{{ $response->other_suggestions ?: '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
