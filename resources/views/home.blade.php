@extends('layouts.app')
@section('page_title', 'หน้าหลัก')
@section('content')
    @php
        $mainMenus = [
            [
                'title' => 'หน้าหลัก / ภาพรวมของฉัน',
                'subtitle' => 'Home / My Overview',
                'description' => 'ดูภาพรวมการใช้งานและสถานะข้อมูลของคุณ',
                'icon' => 'fa-solid fa-house',
                'bg' => 'bg-primary text-white',
                'url' => route('home'),
            ],
            [
                'title' => 'อัปโหลดภาพ',
                'subtitle' => 'Upload Image',
                'description' => 'อัปโหลดภาพถ่ายผิวหนังเข้าสู่ระบบ',
                'icon' => 'fa-solid fa-camera',
                'bg' => 'bg-success text-white',
                'url' => url('#'),
            ],
            [
                'title' => 'คลังภาพของฉัน',
                'subtitle' => 'My Image Library',
                'description' => 'ดูรายการภาพที่คุณเคยอัปโหลดทั้งหมด',
                'icon' => 'fa-solid fa-images',
                'bg' => 'bg-info text-white',
                'url' => url('#'),
            ],
            [
                'title' => 'การยินยอมและการแชร์ข้อมูล',
                'subtitle' => 'Consent & Data Sharing',
                'description' => 'จัดการความยินยอมในการใช้และแชร์ข้อมูล',
                'icon' => 'fa-solid fa-handshake-angle',
                'bg' => 'bg-warning text-dark',
                'url' => url('#'),
            ],
            [
                'title' => 'สิทธิ์การเข้าถึงข้อมูล',
                'subtitle' => 'Data Access Permissions',
                'description' => 'กำหนดสิทธิ์ว่าใครสามารถเข้าถึงข้อมูลได้',
                'icon' => 'fa-solid fa-user-shield',
                'bg' => 'bg-secondary text-white',
                'url' => url('#'),
            ],
            [
                'title' => 'ประวัติการเข้าถึงและการแจ้งเตือน',
                'subtitle' => 'Access History & Notifications',
                'description' => 'ติดตามการเข้าถึงข้อมูลและการแจ้งเตือนล่าสุด',
                'icon' => 'fa-solid fa-clock-rotate-left',
                'bg' => 'bg-danger text-white',
                'url' => url('#'),
            ],
        ];
    @endphp
    <div class="conatiner-fluid content-inner">
        @include('layouts.alert')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="fw-bold mb-1">หน้าหลัก (Home)</h3>
                        <p class="mb-0 text-muted">เมนูหลักสำหรับผู้ใช้งานหลังเข้าสู่ระบบ</p>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-4">
                            <strong>Prototype:</strong> ระบบนี้เป็นต้นแบบสำหรับงานวิจัยเท่านั้น ยังไม่ใช่ระบบจริง และไม่มีการจัดเก็บข้อมูลส่วนตัวใดๆทั้งสิ้น
                        </div>
                        <div class="mb-4">
                            <h4 class="fw-bold mb-1">เมนูหลัก 6 รายการ</h4>
                            <p class="text-muted mb-3">ออกแบบตามข้อเสนอแนะจากผู้ตอบแบบสอบถาม โดยเน้นเมนูที่เข้าใจง่ายและตรงกับการใช้งานหลัก</p>
                            <div class="row g-3">
                                @foreach ($mainMenus as $menu)
                                    <div class="col-12 col-md-6 col-xl-4">
                                        <a href="{{ $menu['url'] }}" class="text-decoration-none">
                                            <div class="card shadow-sm h-100 hover-card">
                                                <div class="card-body text-center p-4">
                                                    <div class="icon iq-icon-box rounded-circle {{ $menu['bg'] }} mb-3">
                                                        <i class="{{ $menu['icon'] }} fa-xl"></i>
                                                    </div>
                                                    <h5 class="fw-bold mb-1">{{ $menu['title'] }}</h5>
                                                    <p class="mb-2 text-muted">{{ $menu['subtitle'] }}</p>
                                                    <p class="mb-0 small text-muted">{{ $menu['description'] }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
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
