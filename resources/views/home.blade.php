@extends('layouts.app')
@section('page_title', 'หน้าหลัก')
@section('content')
    <div class="conatiner-fluid content-inner">
        @include('layouts.alert')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bold mb-1">หน้าหลัก (Home)</h3>
                        <p class="mb-0 text-muted">ต้นแบบการใช้งานแบบแยกพอร์ทัลผู้ป่วยและแพทย์</p>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-4">
                            <strong>Prototype:</strong> ระบบนี้เป็นต้นแบบสำหรับงานวิจัยเท่านั้น ยังไม่ใช่ระบบจริง และไม่มีการจัดเก็บข้อมูลส่วนตัวใดๆทั้งสิ้น
                        </div>
                        <div class="mb-4">
                            <h4 class="fw-bold mb-1">พอร์ทัลผู้ป่วย (Patient Portal)</h4>
                            <p class="text-muted mb-3">ผู้ป่วยสามารถอัปโหลดภาพ ตรวจดูผล และควบคุมสิทธิ์การเข้าถึงข้อมูล</p>
                            <div class="row g-3">
                                <div class="col-12 col-md-6 col-xl-3">
                                    <a href="{{ url('#') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100 hover-card">
                                            <div class="card-body text-center">
                                                <div class="icon iq-icon-box rounded-circle bg-primary text-white mb-3">
                                                    <i class="fa-solid fa-camera fa-xl"></i>
                                                </div>
                                                <h5 class="fw-bold mb-1">อัปโหลดภาพ</h5>
                                                <p class="mb-0 text-muted">Upload Image</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 col-xl-3">
                                    <a href="{{ url('#') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100 hover-card">
                                            <div class="card-body text-center">
                                                <div class="icon iq-icon-box rounded-circle bg-success text-white mb-3">
                                                    <i class="fa-solid fa-file-medical fa-xl"></i>
                                                </div>
                                                <h5 class="fw-bold mb-1">ดูผลการวินิจฉัย</h5>
                                                <p class="mb-0 text-muted">View Diagnosis</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 col-xl-3">
                                    <a href="{{ url('#') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100 hover-card">
                                            <div class="card-body text-center">
                                                <div class="icon iq-icon-box rounded-circle bg-warning text-dark mb-3">
                                                    <i class="fa-solid fa-user-shield fa-xl"></i>
                                                </div>
                                                <h5 class="fw-bold mb-1">ตั้งค่าความยินยอม</h5>
                                                <p class="mb-0 text-muted">Consent Settings</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 col-xl-3">
                                    <a href="{{ url('#') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100 hover-card">
                                            <div class="card-body text-center">
                                                <div class="icon iq-icon-box rounded-circle bg-info text-white mb-3">
                                                    <i class="fa-solid fa-clock-rotate-left fa-xl"></i>
                                                </div>
                                                <h5 class="fw-bold mb-1">บันทึกการเข้าถึง</h5>
                                                <p class="mb-0 text-muted">Access Log</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-1">
                            <h4 class="fw-bold mb-1">พอร์ทัลแพทย์ (Doctor Portal)</h4>
                            <p class="text-muted mb-3">แพทย์สามารถจัดการเคส ตรวจภาพ วินิจฉัย และขอสิทธิ์เข้าถึงข้อมูลเพิ่มเติม</p>
                            <div class="row g-3">
                                <div class="col-12 col-md-6 col-xl-4">
                                    <a href="{{ url('#') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100 hover-card">
                                            <div class="card-body text-center">
                                                <div class="icon iq-icon-box rounded-circle bg-secondary text-white mb-3">
                                                    <i class="fa-solid fa-folder-open fa-xl"></i>
                                                </div>
                                                <h5 class="fw-bold mb-1">เคสผู้ป่วย</h5>
                                                <p class="mb-0 text-muted">Patient Cases</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 col-xl-4">
                                    <a href="{{ url('#') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100 hover-card">
                                            <div class="card-body text-center">
                                                <div class="icon iq-icon-box rounded-circle bg-primary text-white mb-3">
                                                    <i class="fa-solid fa-images fa-xl"></i>
                                                </div>
                                                <h5 class="fw-bold mb-1">ดูภาพผิวหนัง</h5>
                                                <p class="mb-0 text-muted">View Skin Images</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 col-xl-4">
                                    <a href="{{ url('#') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100 hover-card">
                                            <div class="card-body text-center">
                                                <div class="icon iq-icon-box rounded-circle bg-success text-white mb-3">
                                                    <i class="fa-solid fa-stethoscope fa-xl"></i>
                                                </div>
                                                <h5 class="fw-bold mb-1">วินิจฉัยและบันทึก</h5>
                                                <p class="mb-0 text-muted">Diagnosis &amp; Notes</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 col-xl-6">
                                    <a href="{{ url('#') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100 hover-card">
                                            <div class="card-body text-center">
                                                <div class="icon iq-icon-box rounded-circle bg-warning text-dark mb-3">
                                                    <i class="fa-solid fa-key fa-xl"></i>
                                                </div>
                                                <h5 class="fw-bold mb-1">ขอสิทธิ์เข้าถึงข้อมูล</h5>
                                                <p class="mb-0 text-muted">Request Access</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 col-xl-6">
                                    <a href="{{ url('#') }}" class="text-decoration-none">
                                        <div class="card shadow-sm h-100 hover-card">
                                            <div class="card-body text-center">
                                                <div class="icon iq-icon-box rounded-circle bg-info text-white mb-3">
                                                    <i class="fa-solid fa-file-shield fa-xl"></i>
                                                </div>
                                                <h5 class="fw-bold mb-1">ประวัติการเข้าถึง</h5>
                                                <p class="mb-0 text-muted">Access History</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <style>
                            .hover-card {
                                transition: 0.2s;
                            }

                            .hover-card:hover {
                                transform: translateY(-4px);
                                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
                            }

                            .icon.iq-icon-box {
                                width: 90px;
                                height: 90px;
                                border-radius: 50% !important;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                margin: 0 auto;
                            }
                        </style>
                        <div class="text-center text-muted small mt-4 mb-2">
                            ระบบต้นแบบนี้เป็นส่วนหนึ่งของงานวิจัยเรื่อง
                            “กรอบพัฒนาระบบจัดเก็บและแลกเปลี่ยนข้อมูลภาพถ่ายโรคผิวหนังเพื่อสนับสนุนการแพทย์ทางไกล” โดย นายวศิลป์ จันทร์สมุทร
                            ภาควิชาวิทยาการคอมพิวเตอร์ คณะวิทยาศาสตร์ มหาวิทยาลัยธรรมศาสตร์

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
