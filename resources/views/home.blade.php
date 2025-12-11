@extends('layouts.app')
@section('page_title', 'หน้าหลัก')
@section('content')
    <div class="conatiner-fluid content-inner">
        @include('layouts.alert')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bold">หน้าหลัก</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-4">
                            <strong>Prototype:</strong> ระบบนี้เป็นต้นแบบสำหรับงานวิจัยเท่านั้น ยังไม่ใช่ระบบจริง และไม่มีการจัดเก็บข้อมูลส่วนตัวใดๆทั้งสิ้น
                        </div>
                        <div class="row g-3">

                            <!-- ถ่ายภาพผิวหนัง -->
                            <div class="col-6 col-md-3">
                                <a href="{{ url('#') }}" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 hover-card">
                                        <div class="card-body text-center">
                                            <div class="icon iq-icon-box rounded-circle bg-primary text-white mb-3">
                                                <!-- SVG: Camera -->
                                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 7H7L9 4H15L17 7H20C21.1 7 22 7.9 22 9V19C22 20.1 21.1 21 20 21H4C2.9 21 2 20.1 2 19V9C2 7.9 2.9 7 4 7Z"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <circle cx="12" cy="14" r="4" stroke="currentColor" stroke-width="2" />
                                                    <circle cx="18" cy="10" r="1" fill="currentColor" />
                                                </svg>
                                            </div>
                                            <h5 class="fw-bold">ถ่ายภาพผิวหนัง</h5>
                                            <p class="text-muted small d-none d-md-block">บันทึกภาพเพื่อส่งให้แพทย์วิเคราะห์</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- ดูข้อมูลเดิม -->
                            <div class="col-6 col-md-3">
                                <a href="{{ url('#') }}" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 hover-card">
                                        <div class="card-body text-center">
                                            <div class="icon iq-icon-box rounded-circle bg-success text-white mb-3">
                                                <!-- SVG: Collection / Folder -->
                                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3 6C3 4.9 3.9 4 5 4H10L12 6H19C20.1 6 21 6.9 21 8V18C21 19.1 20.1 20 19 20H5C3.9 20 3 19.1 3 18V6Z"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M3 10H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                </svg>
                                            </div>
                                            <h5 class="fw-bold">ดูข้อมูลเดิม</h5>
                                            <p class="text-muted small d-none d-md-block">เรียกดูข้อมูลประวัติการส่งภาพ</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- แชร์ข้อมูล -->
                            <div class="col-6 col-md-3">
                                <a href="{{ url('#') }}" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 hover-card">
                                        <div class="card-body text-center">
                                            <div class="icon iq-icon-box rounded-circle bg-info text-white mb-3">
                                                <!-- SVG: Share -->
                                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="18" cy="5" r="3" stroke="currentColor" stroke-width="2" />
                                                    <circle cx="6" cy="12" r="3" stroke="currentColor" stroke-width="2" />
                                                    <circle cx="18" cy="19" r="3" stroke="currentColor" stroke-width="2" />
                                                    <path d="M8.5 13.5L15.5 17.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                    <path d="M15.5 6.5L8.5 10.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                </svg>
                                            </div>
                                            <h5 class="fw-bold">แชร์ข้อมูล</h5>
                                            <p class="text-muted small d-none d-md-block">แชร์ข้อมูลให้แพทย์หรือหน่วยบริการ</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- คูปองสิทธิพิเศษ -->
                            <div class="col-6 col-md-3">
                                <a href="{{ url('#') }}" class="text-decoration-none">
                                    <div class="card shadow-sm h-100 hover-card">
                                        <div class="card-body text-center">
                                            <div class="icon iq-icon-box rounded-circle bg-warning text-dark mb-3">
                                                <!-- SVG: Ticket -->
                                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3 7H21V10C19.5 10 18.5 11.2 18.5 12C18.5 12.8 19.5 14 21 14V17H3V14C4.5 14 5.5 12.8 5.5 12C5.5 11.2 4.5 10 3 10V7Z"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <line x1="12" y1="7" x2="12" y2="17" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                </svg>
                                            </div>
                                            <h5 class="fw-bold">คูปอง</h5>
                                            <p class="text-muted small d-none d-md-block">สิทธิพิเศษและโปรโมชั่นจากโครงการ</p>
                                        </div>
                                    </div>
                                </a>
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
