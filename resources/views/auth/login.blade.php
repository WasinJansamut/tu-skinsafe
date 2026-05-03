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
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-key me-1"></i>
                                                เข้าสู่ระบบ
                                            </button>
                                        </div>
                                    </form>

                                    <div class="border-top mt-4 pt-4">
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-outline-primary btn-lg py-3 fw-bold" data-bs-toggle="modal" data-bs-target="#participantRegisterModal">
                                                <i class="fa-solid fa-user-plus me-2"></i>
                                                สมัครเข้าร่วมวิจัย
                                            </button>
                                        </div>
                                    </div>
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

    <div class="modal fade" id="participantRegisterModal" tabindex="-1" aria-labelledby="participantRegisterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title mb-1" id="participantRegisterModalLabel">สมัครเข้าร่วมวิจัย</h5>
                        <small class="text-muted">ข้อมูลชุดนี้ใช้เฉพาะการสร้างบัญชีสำหรับเข้าสู่ระบบเท่านั้น</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="form_participant_register" action="{{ route('participant.register') }}" method="post" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-warning mb-3">
                            กรุณาอ่านคำชี้แจงในการเข้าร่วมวิจัยก่อน จึงจะสามารถกรอกข้อมูลและบันทึกการสมัครได้
                        </div>

                        <div class="d-flex justify-content-between align-items-start gap-2 mb-3 p-3 rounded-3 bg-light">
                            <div>
                                <div class="fw-semibold text-dark">คำชี้แจงในการเข้าร่วมวิจัย</div>
                                <small class="text-muted">กดดูรายละเอียดก่อนสมัครเข้าร่วม</small>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="participantResearchNoteTrigger">
                                <i class="fa-solid fa-circle-info me-1"></i>
                                อ่านคำชี้แจง
                            </button>
                        </div>

                        <div class="row g-3" id="participantRegisterFields">
                            <div class="col-12 col-md-6">
                                <label for="participant_name" class="form-label">นามสมมุติ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="participant_name" name="name" maxlength="255" autocomplete="off" required>
                            </div>



                            <div class="col-12">
                                <label for="participant_compensation_channel" class="form-label">ช่องทางและรายละเอียดการจ่ายค่าตอบแทน <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="participant_compensation_channel" name="compensation_channel" maxlength="255" autocomplete="off" placeholder="เช่น โอนเงินผ่านบัญชีธนาคาร / พร้อมเพย์ / เงินสด" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="participant_username" class="form-label">ชื่อผู้ใช้งาน <span class="text-danger">*</span> <small class="text-muted">ใช้เข้าสู่ระบบ</small></label>
                                <input type="text" class="form-control" id="participant_username" name="username" maxlength="30" autocomplete="off" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="participant_password" class="form-label">รหัสผ่าน <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="participant_password" name="password" maxlength="255" autocomplete="new-password" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="participant_password_confirmation" class="form-label">ยืนยันรหัสผ่าน <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="participant_password_confirmation" name="password_confirmation" maxlength="255" autocomplete="new-password" required>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" id="participantRegisterSubmit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            สมัครเข้าร่วมวิจัย
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="participantResearchNoteModal" tabindex="-1" aria-labelledby="participantResearchNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title mb-0" id="participantResearchNoteModalLabel">คำชี้แจงในการเข้าร่วมวิจัย</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p class="mb-3" style="text-indent: 1.5em;">
                            งานวิจัยเรื่อง <span class="fw-semibold">กรอบพัฒนาระบบจัดเก็บและแลกเปลี่ยน
                                ข้อมูลภาพถ่ายโรคผิวหนังเพื่อสนับสนุนการแพทย์ทางไกล
                            </span> มีวัตถุประสงค์เพื่อ
                            <span class="fw-semibold">พัฒนาระบบต้นแบบสำหรับจัดเก็บและส่งต่อภาพถ่ายโรคผิวหนัง</span>
                            โดยการเก็บข้อมูลจากผู้เข้าร่วมวิจัยเพื่อใช้ในการออกแบบและประเมินระบบต้นแบบให้เหมาะสมกับการใช้งานจริง
                        </p>
                        <p class="mb-3" style="text-indent: 1.5em;">
                            การเข้าร่วมวิจัยนี้เป็นไปโดยความสมัครใจ ผู้เข้าร่วมสามารถถอนตัวได้ทุกเมื่อโดยไม่กระทบสิทธิของท่าน
                        </p>
                        <p class="mb-3" style="text-indent: 1.5em;">
                            หากท่านทดสอบการใช้งานและประเมินผลสำเร็จ จะมีค่าตอบแทนตามที่โครงการกำหนด
                            <span class="fw-semibold">จำนวนเงิน 300 บาท</span>
                            โดยจะจ่ายผ่านช่องทางที่ท่านระบุไว้ในแบบฟอร์มสมัครเข้าร่วมวิจัยหลังจากที่ท่านทำแบบทดสอบและประเมินผลเสร็จสมบูรณ์แล้ว
                            <span class="fw-semibold">ภาพใน 24 ชั่วโมงหลังทดสอบระบบต้นแบบและทำแบบประเมินเสร็จสิ้น ท่านสามารถเข้ามาดูสถานะได้ในระบบต้นแบบนี้ จากส่วนข้อมูลผู้เข้าร่วมวิจัย</span>
                        </p>
                        <p class="mb-0" style="text-indent: 1.5em;">
                            ข้อมูลที่เก็บจะใช้เพื่อการวิจัยเท่านั้น และจะดำเนินการตามแนวทางการคุ้มครองข้อมูลส่วนบุคคลและจริยธรรมการวิจัยที่เกี่ยวข้อง
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="participantResearchNoteAcknowledge">รับทราบ</button>
                </div>
            </div>
        </div>
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
            const participantModalElement = document.getElementById('participantRegisterModal');
            const participantModal = participantModalElement ? bootstrap.Modal.getOrCreateInstance(participantModalElement) : null;
            const researchNoteModalElement = document.getElementById('participantResearchNoteModal');
            const researchNoteModal = researchNoteModalElement ? bootstrap.Modal.getOrCreateInstance(researchNoteModalElement, {
                backdrop: 'static',
                keyboard: false
            }) : null;
            const participantRegisterFields = $('#participantRegisterFields');
            let researchNoteAccepted = false;

            const lockParticipantForm = function() {
                participantRegisterFields.find('input, select, textarea').prop('disabled', true);
                $('#participantRegisterSubmit').prop('disabled', true);
            };

            const unlockParticipantForm = function() {
                participantRegisterFields.find('input, select, textarea').prop('disabled', false);
                $('#participantRegisterSubmit').prop('disabled', false);
            };

            const refreshParticipantFormState = function() {
                if (researchNoteAccepted) {
                    unlockParticipantForm();
                } else {
                    lockParticipantForm();
                }
            };

            $('script').each(function() {
                $(this).attr('defer', '');
            });

            $('img').each(function() {
                $(this).attr('loading', 'lazy');
            });

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

            $('#participantResearchNoteTrigger').on('click', function() {
                if (researchNoteModal) {
                    researchNoteModal.show();
                }
            });

            $('#participantResearchNoteAcknowledge').on('click', function() {
                researchNoteAccepted = true;
                refreshParticipantFormState();

                if (researchNoteModal) {
                    researchNoteModal.hide();
                }

                $('#participant_name').trigger('focus');
            });

            $('#participantRegisterModal').on('shown.bs.modal', function() {
                researchNoteAccepted = false;
                refreshParticipantFormState();

                if (researchNoteModal) {
                    researchNoteModal.show();
                }
            });

            $('#participantRegisterModal').on('hidden.bs.modal', function() {
                $('#form_participant_register')[0].reset();
                researchNoteAccepted = false;
                refreshParticipantFormState();
                $('#participantRegisterSubmit').html('<i class="fa-solid fa-floppy-disk me-1"></i> สมัครเข้าร่วมวิจัย');
            });

            $('#participantResearchNoteModal').on('hidden.bs.modal', function() {
                if (!researchNoteAccepted) {
                    refreshParticipantFormState();
                }
            });

            refreshParticipantFormState();

            $("#form_participant_register").on("submit", function(e) {
                e.preventDefault();

                const $form = $(this);
                const submitButton = $('#participantRegisterSubmit');
                const originalButtonHtml = submitButton.html();
                const formData = new FormData(this);
                const escapeHtml = function(text) {
                    return $('<div>').text(text).html();
                };

                if (!researchNoteAccepted) {
                    Swal.fire({
                        icon: 'info',
                        title: 'กรุณาอ่านคำชี้แจงก่อน',
                        text: 'ต้องกดรับทราบคำชี้แจงก่อนจึงจะกรอกและบันทึกข้อมูลได้',
                        confirmButtonText: 'ปิด'
                    });

                    return;
                }

                submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> กำลังสมัคร');

                Swal.fire({
                    title: `<h2 class="mb-0 text-dark">กำลังสมัครเข้าร่วมวิจัย</h2>`,
                    html: `<div class="d-flex flex-column align-items-center">
                                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <div class="mb-1">โปรดรอสักครู่...</div>
                            </div>`,
                    showConfirmButton: false,
                    showCloseButton: false,
                    showCancelButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        Swal.close();

                        if (participantModal) {
                            participantModal.hide();
                        }

                        $('#username').val(response?.user?.username || $('#participant_username').val());
                        $('#password').val('').trigger('focus');

                        Swal.fire({
                            icon: 'success',
                            title: 'สมัครสำเร็จ',
                            html: escapeHtml(response?.message || 'สมัครเข้าร่วมวิจัยสำเร็จ สามารถเข้าสู่ระบบเพื่อทำแบบทดสอบได้เลย'),
                            confirmButtonText: 'เข้าใจแล้ว'
                        });
                    },
                    error: function(xhr) {
                        Swal.close();

                        submitButton.prop('disabled', false).html(originalButtonHtml);

                        let message = 'เกิดข้อผิดพลาดในการสมัคร';
                        const response = xhr.responseJSON || {};

                        if (response.errors) {
                            const messages = [];

                            Object.values(response.errors).forEach(function(errorList) {
                                errorList.forEach(function(errorMessage) {
                                    messages.push(errorMessage);
                                });
                            });

                            message = messages.map(function(item) {
                                return escapeHtml(item);
                            }).join('<br>');
                        } else if (response.message) {
                            message = escapeHtml(response.message);
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'สมัครไม่สำเร็จ',
                            html: `<div class="text-start">${message}</div>`,
                            confirmButtonText: 'ปิด'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
