@extends('layouts.app')
@section('page_title', 'ดูข้อมูลแบบประเมิน')

@section('content')
    <div class="conatiner-fluid content-inner">
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
                                    <a href="{{ route('evaluation.responses') }}">คำตอบแบบประเมิน</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Record #{{ $response->id }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h3 class="mb-0">รายละเอียดแบบประเมิน #{{ $response->id }}</h3>
                        <a href="{{ route('evaluation.responses') }}" class="btn btn-dark">
                            <i class="fa-solid fa-arrow-left me-1"></i>
                            กลับไปรายการ
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">วันที่ตอบ</div>
                                    <div class="fw-semibold">{{ $response->submitted_at_text }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">อายุ</div>
                                    <div class="fw-semibold">{{ $general['age'] ?? '-' }} ปี</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">เพศ</div>
                                    <div class="fw-semibold">{{ $response->gender_label ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">เคยใช้ telemedicine</div>
                                    <div class="fw-semibold">{{ $response->telemedicine_label ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">ระดับการศึกษา</div>
                                    <div class="fw-semibold">{{ $response->education_label ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">จำนวนครั้งที่เคยรักษาโรคผิวหนัง</div>
                                    <div class="fw-semibold">{{ $response->treatment_label ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="text-muted small">คำตอบเพศอื่นๆ</div>
                                    <div class="fw-semibold">{{ $general['gender_other'] ?? '-' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-4">
                            <div class="border rounded p-3 bg-white">
                                <div class="fw-bold mb-3">ส่วนที่ 2: แบบประเมินผลการใช้งานระบบต้นแบบ</div>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0 align-middle">
                                        <thead>
                                            <tr>
                                                <th style="width: 70%;">รายการประเมิน</th>
                                                <th class="text-center" style="width: 30%;">คะแนน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $number => $text)
                                                <tr>
                                                    <td>{{ $number }}. {{ $text }}</td>
                                                    <td class="text-center fw-semibold">{{ $scale[$number] ?? $scale[(string) $number] ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="border rounded p-3 bg-white">
                                <div class="fw-bold mb-3">ส่วนที่ 3: คำถามทั่วไปและข้อเสนอแนะ</div>
                                <div class="mb-3">
                                    <div class="text-muted small">1. ส่วนใดของระบบที่ท่านคิดว่าใช้งานง่ายหรือมีประโยชน์มากที่สุด</div>
                                    <div>{{ $open['section3_1'] ?? '-' }}</div>
                                </div>
                                <div class="mb-3">
                                    <div class="text-muted small">2. ส่วนใดของระบบที่ท่านคิดว่ายังใช้งานยากหรือควรปรับปรุง</div>
                                    <div>{{ $open['section3_2'] ?? '-' }}</div>
                                </div>
                                <div class="mb-3">
                                    <div class="text-muted small">3. ท่านมีความกังวลเพิ่มเติมเกี่ยวกับการจัดเก็บหรือการแชร์ภาพโรคผิวหนังหรือไม่</div>
                                    <div>{{ $open['section3_3'] ?? '-' }}</div>
                                </div>
                                <div>
                                    <div class="text-muted small">4. ท่านมีข้อเสนอแนะเพิ่มเติมต่อการพัฒนาระบบต้นแบบหรือไม่</div>
                                    <div>{{ $open['section3_4'] ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
