<!doctype html>
<html lang="th" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>เข้าสู่ระบบ : {{ config('app.name') ?? 'NOT FOUND' }}</title>

    <!-- META: TU SkinSafe SEO + Social -->
    <meta name="title" content="TU SkinSafe - Your Skin. Your Control.">
    <meta name="description" content="TU SkinSafe ระบบต้นแบบเพื่อการวิจัยด้านการจัดเก็บและแบ่งปันภาพผิวหนังอย่างปลอดภัย ภาพของคุณ สิทธิของคุณ พัฒนาโดย นายวศิลป์ จันทร์สมุทร">
    <meta name="keywords" content="TU SkinSafe, teledermatology, dermatology, skin imaging, PDPA, prototype system, ภาพผิวหนัง, ระบบต้นแบบ, ธรรมศาสตร์, งานวิจัย">
    <meta name="author" content="Wasin Jansamut">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://tu-skinsafe.com/">
    <meta property="og:title" content="TU SkinSafe - Your Skin. Your Control.">
    <meta property="og:description" content="ระบบต้นแบบเพื่อการวิจัยด้านการจัดเก็บและแบ่งปันภาพผิวหนังอย่างปลอดภัย ภาพของคุณ สิทธิของคุณ พัฒนาโดย นายวศิลป์ จันทร์สมุทร">
    <meta property="og:image" content="{{ asset('assets/images/og-cover.png') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="TU SkinSafe - Your Skin. Your Control.">
    <meta name="twitter:description" content="Prototype for secure dermatological image storage & sharing.">
    <meta name="twitter:image" content="{{ asset('assets/images/og-cover.png') }}">


    <!-- Favicon -->
    <!-- Favicon generator. For real. https://realfavicongenerator.net -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon/apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') ?? 'ไม่พบ' }}" />
    <link rel="manifest" href="{{ asset('assets/images/favicon/site.webmanifest') }}" />
    <meta name="msapplication-TileColor" content="#00152c">
    <meta name="theme-color" content="#ffffff">

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}">

    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/css/hope-ui.min.css') }}">
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/css/pro.min.css') }}">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/css/custom.min.css') }}">

    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/css/customizer.min.css') }}">

    <!-- Font Awesome Css -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.min.css') }}">

    <!-- Sweetalert2 -->
    <link href="{{ asset('assets/sweetalert2/css/sweetalert2.min.css') }}" rel="stylesheet" />

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') ?? 'ไม่พบ' }}">
    <link rel="manifest" href="{{ asset('assets/js/site.webmanifest') }}">
</head>

<body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
    <!-- loader Start -->
    @include('layouts.loading')
    <!-- loader END -->
    <div class="wrapper">
        <section class="login-content">
            <div class="row m-0 align-items-center bg-white vh-100">
                <div class="col-md-6">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            @include('layouts.alert')

                            <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card iq-auth-form">
                                <div class="card-body">
                                    <div class="text-center mb-2">
                                        <img class="pe-none" src="{{ asset('assets/images/logo/logo_horizontal.png') }}" height="80" loading="lazy">
                                    </div>

                                    <h2 class="mb-2 text-center">เข้าสู่ระบบ</h2>

                                    <form id="form_login" action="{{ route('login') }}" method="post">
                                        @csrf
                                        @method('POST')
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="username" class="form-label" style="">ชื่อผู้ใช้งาน</label>
                                                    <input type="text"
                                                        class="form-control @error('username') is-invalid @enderror"
                                                        id="username" name="username"
                                                        aria-describedby="username" value="{{ old('username') }}"
                                                        required autofocus autocomplete="off">
                                                    @error('username')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">รหัสผ่าน</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                            id="password" name="password" aria-describedby="password" autocomplete="off" required>
                                                        <i class="fa fa-eye-slash position-absolute" id="togglePassword"
                                                            style="top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer; color: #888;"></i>
                                                    </div>
                                                    <script>
                                                        document.getElementById('togglePassword').addEventListener('click', function() {
                                                            const passwordInput = document.getElementById('password');
                                                            const icon = this;
                                                            const isPassword = passwordInput.type === 'password';

                                                            passwordInput.type = isPassword ? 'text' : 'password';
                                                            icon.classList.toggle('fa-eye');
                                                            icon.classList.toggle('fa-eye-slash');
                                                        });
                                                    </script>
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mb-3">
                                            <button type="submit" class="btn btn-primary ">
                                                <i class="fa-solid fa-key me-1"></i>
                                                เข้าสู่ระบบ
                                            </button>
                                            <a class="btn btn-link" href="#">สมัครสมาชิก</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-md-block d-none bg-primary p-0 vh-100 overflow-hidden">
                    <img src="{{ asset('assets/images/auth-pro/02.jpg') }}"
                        class="img-fluid pe-none gradient-main animated-scaleX" alt="images" loading="lazy">
                </div>
            </div>
        </section>
    </div>

    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

    <!-- Hopeui Script -->
    <script src="{{ Helper::versionedAsset('assets/js/hope-ui.js') }}"></script>
    <script src="{{ Helper::versionedAsset('assets/js/hope-uipro.js') }}"></script>
    <script src="{{ Helper::versionedAsset('assets/js/sidebar.js') }}"></script>

    <!-- Sweetalert2 -->
    <script src="{{ asset('assets/sweetalert2/js/sweetalert2.all.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('script').each(function() {
                $(this).attr('defer', '');
            });

            $('img').each(function() {
                $(this).attr('loading', 'lazy');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#form_login").on("submit", function(e) {
                e.preventDefault();

                var username = $('#username').val();
                $(".btn").prop('disabled', true);
                Swal.fire({
                    title: `<h2 class="mb-0 text-dark">กำลังเข้าสู่ระบบ</h2>`,
                    html: `<div class="d-flex flex-column align-items-center">
                                <span class="fs-5 text-primary fw-bold text-uppercase mb-3">ชื่อผู้ใช้งาน ${username}</span>
                                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="mb-1">โปรดรอสักครู่...</div>
                            </div>`,
                    showConfirmButton: false,
                    showCloseButton: false,
                    showCancelButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        // ✅ เมื่อ swal render เสร็จ ค่อย submit ฟอร์ม
                        requestAnimationFrame(() => {
                            requestAnimationFrame(() => {
                                e.target.submit();
                            });
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
