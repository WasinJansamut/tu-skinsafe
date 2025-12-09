@extends('layouts.app')
@section('page_title', 'แก้ไขโปรไฟล์')
@section('content')
    <div class="conatiner-fluid content-inner">
        @include('layouts.alert')
        <div class="alert alert-left alert-info alert-dismissible fade show mb-3" role="alert">
            <div class="fs-4">
                <i class="fa-solid fa-circle-check me-1 fs-3"></i>
                <span>หมายเหตุ</span>
            </div>
            <div>แก้ไขได้เฉพาะรหัสผ่านและรูปภาพประจำตัวเท่านั้น</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                            <div class="d-flex flex-wrap align-items-center">
                                <div class="profile-img position-relative me-3 mb-3 mb-lg-0 profile-logo profile-logo1">
                                    @php
                                        $profileImage = Helper::checkImageExists($user->profile_image);
                                    @endphp
                                    <a href="{{ $profileImage }}" data-lightbox="{{ $user->id }}">
                                        <img src="{{ $profileImage }}"
                                            class="theme-color-default-img img-fluid rounded-pill avatar-100">
                                    </a>
                                </div>
                                <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                                    <h4 class="me-2 h4">
                                        [{{ $user->employee_id ?? '' }}]
                                        {{ $user->name ?? '' }}
                                    </h4>
                                    <span></span>
                                    <span class="badge rounded-pill bg-secondary-subtle">
                                        [{{ $user->_branch->code ?? '' }}]
                                        {{ $user->_department->name_th ?? '' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('user.my_profile_update') }}" method="post" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-lg-3 form-group">
                                    <label for="employee_id">รหัสพนักงาน</label>
                                    <input type="text" name="employee_id" id="employee_id"
                                        class="form-control @error('employee_id') is-invalid @enderror"
                                        value="{{ old('employee_id', $user->employee_id ?? '') }}"
                                        autocomplete="employee_id" maxlength="30" readonly>
                                    @error('employee_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-3 form-group">
                                    <label for="name">ชื่อ-นามสกุล</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name ?? '') }}" autocomplete="name" maxlength="255"
                                        readonly>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-3 form-group">
                                    <label>สาขา</label>
                                    <input type="text" class="form-control"
                                        value="{{ '[' . $user->_branch->code . '] ' . $user->_branch->name }}" readonly>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-3 form-group">
                                    <label>แผนก</label>
                                    <input type="text" class="form-control" value="{{ $user->_department->name_th }}"
                                        readonly>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-3 form-group">
                                    <label>ระดับ</label>
                                    <input type="text" class="form-control" value="{{ $user->_level->name }}" readonly>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-3 form-group">
                                    <label for="email">อีเมล</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email ?? '') }}" autocomplete="email" maxlength="255"
                                        readonly>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-3 form-group">
                                    <label for="phone_no">เบอร์โทรศัพท์</label>
                                    <input type="text" name="phone_no" id="phone_no"
                                        class="form-control @error('phone_no') is-invalid @enderror"
                                        value="{{ old('phone_no', $user->phone_no ?? '') }}" autocomplete="tel" maxlength="20">
                                    @error('phone_no')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-lg-3 form-group">
                                    <label for="password">รหัสผ่าน</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" autocomplete="off"
                                        maxlength="255">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-3 form-group">
                                    <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        autocomplete="off" maxlength="255">
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-lg-3 form-group">
                                    <label for="profile_image">รูปภาพประจำตัว</label>
                                    <input type="file" name="profile_image" id="profile_image"
                                        class="form-control @error('profile_image') is-invalid @enderror"
                                        accept="image/jpg, image/jpeg, image/png, image/svg">
                                    @error('profile_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('home') }}" class="btn btn-dark">
                                    <i class="fa-solid fa-house me-1"></i>
                                    หน้าหลัก
                                </a>
                                <button type="submit" class="btn btn-success ms-auto btn_submit_bill">
                                    <i class="fa-solid fa-floppy-disk me-1"></i>
                                    บันทึก
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-1 flex-wrap">
                    <h4 class="mb-2">ข้อมูลการเข้าสู่ระบบบนอุปกรณ์ต่าง ๆ</h4>
                    <form method="POST" action="{{ route('auth.logout_my_all_others') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger btn_submit">
                            <i class="fa-solid fa-power-off me-1"></i>
                            ออกจากระบบบนอุปกรณ์อื่นทั้งหมด
                        </button>
                    </form>
                </div>

                <div class="row g-3">
                    @foreach ($sessions as $session)
                        @php
                            $browser_icons = [
                                'Chrome' => 'fa-brands fa-chrome',
                                'Firefox' => 'fa-brands fa-firefox',
                                'Safari' => 'fa-brands fa-safari',
                                'Edge' => 'fa-brands fa-edge',
                                'Opera' => 'fa-brands fa-opera',
                                'IE' => 'fa-brands fa-internet-explorer',
                                'Samsung Internet' => 'fa-solid fa-mobile-screen',
                                'UC Browser' => 'fa-solid fa-mobile-screen',
                                'Brave' => 'fa-brands fa-brave',
                                'Vivaldi' => 'fa-solid fa-browser',
                            ];

                            $device_icons = [
                                'Desktop' => 'fa-solid fa-laptop',
                                'Mobile' => 'fa-solid fa-mobile-screen',
                                'Tablet' => 'fa-solid fa-tablet-screen-button',
                                'Bot' => 'fa-solid fa-robot',
                                'Console' => 'fa-solid fa-gamepad',
                                // 'Unknown' => 'fa-solid fa-circle-question',
                            ];

                            $device_os_icons = [
                                'Windows' => 'fa-brands fa-windows',
                                'OS X' => 'fa-brands fa-apple',
                                'Macintosh' => 'fa-brands fa-apple',
                                'iOS' => 'fa-brands fa-apple',
                                'Android' => 'fa-brands fa-android',
                                'AndroidOS' => 'fa-brands fa-android',
                                'Linux' => 'fa-brands fa-linux',
                                'Ubuntu' => 'fa-brands fa-linux',
                                'Chrome OS' => 'fa-solid fa-laptop',
                                'BlackBerry' => 'fa-solid fa-mobile-screen',
                                'Windows Phone' => 'fa-solid fa-mobile-screen',
                            ];

                            $browser_icon_class = $browser_icons[$session->browser] ?? 'fa-solid fa-globe';
                            $device_icon_class = $device_icons[$session->device_category ?? ''] ?? '';
                            $device_os_icon_class = $device_os_icons[$session->device] ?? 'fa-solid fa-laptop';
                        @endphp
                        <div class="col-sm-12 col-md-6">
                            <div class="card shadow-sm overflow-hidden border-0 mb-0">
                                <div class="card-header py-2 px-3 border-bottom border-1 bg-info bg-opacity-10">
                                    <div class="fs-5 d-flex align-items-center fw-bolder text-secondary">
                                        <i class="{{ $device_os_icon_class }} me-1"></i>
                                        {{ $session->device }}
                                        <span class="badge bg-info rounded-pill ms-2 d-flex align-items-center">
                                            @if ($device_icon_class)
                                                <i class="{{ $device_icon_class }} fa-sm me-1"></i>
                                            @endif
                                            {{ $session->device_type }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center pt-1 p-3">
                                    <!-- Left: Device / Browser / Location -->
                                    <div class="mb-2 mb-md-0 flex-grow-1">
                                        <p class="mb-1">
                                            <span data-bs-toggle="tooltip" title="{{ $session->user_agent }}" data-bs-placement="top">
                                                <i class="{{ $browser_icon_class }} me-1"></i>
                                                {{ $session->browser }}
                                            </span>
                                        </p>
                                        <p class="mb-1">
                                            <span data-bs-toggle="tooltip" title="{{ $session->ip_address }}" data-bs-placement="top">
                                                <i class="fa-solid fa-location-dot me-1"></i>
                                                {{ $session->city }}, {{ $session->country }}
                                            </span>
                                        </p>
                                        <p class="mb-1 small">
                                            <i class="fa-solid fa-clock me-1"></i>
                                            เข้าสู่ระบบเมื่อ {{ $session->login_at ? Helper::formatThaiDate($session->login_at) : '-' }}
                                        </p>
                                        <p class="mb-0 small">
                                            <i class="fa-solid fa-clock me-1"></i>
                                            ใช้งานล่าสุดเมื่อ {{ $session->last_activity_at ? Helper::formatThaiDate($session->last_activity_at) : '-' }}
                                        </p>
                                    </div>

                                    <!-- Right: Logout / Current + Timestamps -->
                                    <div class="d-flex flex-column align-items-end">
                                        @if ($session->session_file !== session()->getId())
                                            <form method="POST" action="{{ route('auth.logout_others') }}">
                                                @csrf
                                                <div class="d-flex align-items-center">
                                                    <input type="hidden" name="session_file" value="{{ $session->session_file }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger btn_submit text-nowrap">
                                                        <i class="fa-solid fa-arrow-right-from-bracket me-1"></i>
                                                        ออกจากระบบ
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            <span class="badge bg-success p-2">
                                                <i class="fa-solid fa-user-check me-1"></i>
                                                อุปกรณ์นี้
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @parent
    <script>
        document.getElementById('profile_image').addEventListener('change', function(e) {
            const [file] = this.files;
            if (file) {
                const imgUrl = URL.createObjectURL(file);

                // อัปเดตรูป
                const imgPreview = document.querySelector('.profile-img img');
                if (imgPreview) {
                    imgPreview.src = imgUrl;
                }

                // อัปเดต href ของ <a> lightbox
                const linkPreview = document.querySelector('.profile-img a');
                if (linkPreview) {
                    linkPreview.href = imgUrl;
                }
            }
        });
    </script>
@endsection
