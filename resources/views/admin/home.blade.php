@extends('layouts.app')
@section('page_title', 'หน้าหลัก')

@section('content')
    <div class="container-fluid content-inner">
        @include('layouts.alert')

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                        <div>
                            <div class="text-primary fw-semibold mb-1">TU SkinSafe</div>
                            <h3 class="mb-1">หน้าหลักสำหรับผู้ดูข้อมูล</h3>
                            <p class="mb-0 text-muted">เข้าถึงข้อมูลผู้เข้าร่วมวิจัย รายการแบบสอบถาม และสรุปผลได้จากจุดเดียว</p>
                        </div>
                        <div class="text-md-end">
                            <div class="fw-semibold">ผู้ใช้งานปัจจุบัน</div>
                            <div class="text-muted">{{ $user->name ?? '-' }}</div>
                            <div class="badge bg-danger mt-2">Admin</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <a href="{{ route('user.index') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-danger-subtle text-danger d-inline-flex align-items-center justify-content-center" style="width:52px;height:52px;">
                                    <i class="fa-solid fa-users fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 text-dark">ข้อมูลผู้ใช้งาน</h5>
                                    <div class="text-muted">เพิ่ม แก้ไข ลบ และตรวจสอบผู้ใช้งาน</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('questionnaire.responses') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center" style="width:52px;height:52px;">
                                    <i class="fa-solid fa-clipboard-list fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 text-dark">แบบสอบถาม</h5>
                                    <div class="text-muted">ดูรายการคำตอบและรายละเอียดแต่ละรายการ</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('questionnaire.summary') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center" style="width:52px;height:52px;">
                                    <i class="fa-solid fa-chart-column fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 text-dark">สรุปแบบสอบถาม</h5>
                                    <div class="text-muted">ภาพรวมผลตอบแบบสอบถามและสถานะล่าสุด</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
