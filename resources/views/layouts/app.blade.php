<!doctype html>
<meta name="csrf-token" content="{{ csrf_token() }}">

<html lang="th" data-bs-theme="light" data-bs-theme-color="default" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('page_title') : {{ $show_company_all_web->name_th ?? 'NOT FOUND' }}</title>
    <meta name="description" content="{{ config('app.name') ?? '' }}">
    <meta name="keywords" content="{{ config('app.name') ?? '' }}">
    <meta name="author" content="{{ config('app.name') ?? '' }}">
    <meta name="DC.title" content="{{ config('app.name') ?? '' }}">

    <!-- Tell the browser to behave as a web app -->
    <meta name="mobile-web-app-capable" content="yes">

    <!-- Set the app's status bar style -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- Google Font Api KEY-->
    <meta name="google_font_api" content="AIzaSyBG58yNdAjc20_8jAvLNSVi9E4Xhwjau_k">
    <!-- Config Options -->
    {{-- <meta name="setting_options"
        content='{&quot;saveLocal&quot;:&quot;sessionStorage&quot;,&quot;storeKey&quot;:&quot;huisetting-html&quot;,&quot;setting&quot;:{&quot;app_name&quot;:{&quot;value&quot;:&quot;Hope UI&quot;},&quot;theme_scheme_direction&quot;:{&quot;value&quot;:&quot;ltr&quot;},&quot;theme_scheme&quot;:{&quot;value&quot;:&quot;light&quot;},&quot;theme_style_appearance&quot;:{&quot;value&quot;:[&quot;theme-default&quot;]},&quot;theme_color&quot;:{&quot;colors&quot;:{&quot;--{{ prefix }}primary&quot;:&quot;#3a57e8&quot;,&quot;--{{ prefix }}info&quot;:&quot;#08B1BA&quot;},&quot;value&quot;:&quot;theme-color-default&quot;},&quot;theme_transition&quot;:{&quot;value&quot;:&quot;theme-with-animation&quot;},&quot;theme_font_size&quot;:{&quot;value&quot;:&quot;theme-fs-md&quot;},&quot;page_layout&quot;:{&quot;value&quot;:&quot;container-fluid&quot;},&quot;header_navbar&quot;:{&quot;value&quot;:&quot;default&quot;},&quot;header_banner&quot;:{&quot;value&quot;:&quot;default&quot;},&quot;sidebar_color&quot;:{&quot;value&quot;:&quot;sidebar-white&quot;},&quot;card_color&quot;:{&quot;value&quot;:&quot;card-default&quot;},&quot;sidebar_type&quot;:{&quot;value&quot;:[]},&quot;sidebar_menu_style&quot;:{&quot;value&quot;:&quot;left-bordered&quot;},&quot;footer&quot;:{&quot;value&quot;:&quot;default&quot;},&quot;body_font_family&quot;:{&quot;value&quot;:null},&quot;heading_font_family&quot;:{&quot;value&quot;:null}}}'> --}}

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

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') ?? 'ไม่พบ' }}">
    <link rel="manifest" href="{{ asset('assets/js/site.webmanifest') }}">

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}">

    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/css/hope-ui.min.css') }}">
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/css/pro.min.css') }}">

    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/css/customizer.min.css') }}">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/css/custom.min.css') }}">

    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/css/rtl.min.css') }}">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Select2 -->
    <link href="{{ asset('assets/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/select2/css/select2-bootstrap-5-theme.min.css.css') }}" rel="stylesheet" />

    <!-- Font Awesome Css -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.min.css') }}" />

    <!-- Sweetalert2 -->
    <link href="{{ asset('assets/sweetalert2/css/sweetalert2.min.css') }}" rel="stylesheet" />

    <!-- Lightbox2 -->
    <link href="{{ asset('assets/lightbox2/css/lightbox.css') }}" rel="stylesheet" />

    {{-- <link href="{{ asset('assets/e-commerce/assets/css/e-commerce.min.css') }}" rel="stylesheet" /> --}}

    <!-- FixedHeader plugin compatible with DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">

    <!-- Flatpickr -->
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/flatpickr/css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/flatpickr/css/themes/airbnb.css') }}">

    <link rel="preload" as="image" href="{{ asset('assets/images/dashboard/top-header.png') }}" fetchpriority="high">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    {{-- @vite('resources/js/app.js') --}}

    <style>
        .relative svg {
            width: 16px;
            /* ขนาดกว้าง */
            height: 16px;
            /* ขนาดสูง */
            text-align: center;
        }

        .disabled-overlay {
            pointer-events: none;
            opacity: 0.5;
        }

        input:read-only:not([type="file"]):not([type="checkbox"]):not([type="radio"]):not([type="date"]):not([type="datetime-local"]):not([type="time"]):not(.input) {
            background-color: #f6f6f6 !important;
        }

        /*
        /* Show BE year in calendar header (overlay) */
        .flatpickr-current-month .numInputWrapper {
            position: relative;
        }

        .flatpickr-current-month .numInput.cur-year {
            color: transparent !important;
            /* ซ่อน ค.ศ. ตลอดเวลา */
            background: transparent !important;
        }

        .flatpickr-current-month .be-year-overlay {
            position: absolute;
            left: 0;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            text-align: center;
            pointer-events: none;
            color: #222;
            /* หรือสีที่ต้องการ */
            z-index: 2;
            opacity: 1;
        }
    </style>
    @yield('style')
</head>

<body>
    <!-- loader Start -->
    @if (!request()->is('check_stock*') && !request()->is('another_url*') && !request()->is('third_url*'))
        @include('layouts.loading')
    @endif
    <!-- loader END -->

    @include('layouts.menu')

    <main class="main-content">
        @include('layouts.header')

        <div class="iq-navbar-header" style="height: 0px;">
            <div class="iq-header-img overflow-hidden">
                <img src="{{ asset('assets/images/dashboard/top-header.png') }}" alt="header"
                    class="theme-color-default-img img-fluid w-100 h-100">
            </div>
        </div>

        <div id="network-banner" class="alert-striped text-center p-2 m-0 position-fixed top-0 start-0 w-100 d-none" role="alert" style="z-index: 9999;"
            data-offline-text="ไม่มีการเชื่อมต่ออินเทอร์เน็ต" data-online-text="กลับมาออนไลน์แล้ว">
            <!-- ข้อความจะเปลี่ยนตามสถานะ -->
        </div>

        @yield('content')

        <!-- Footer Section Start -->
        <footer class="footer">
            <div class="footer-body">
                <ul class="left-panel list-inline mb-0 p-0">
                    <li class="list-inline-item">
                        <span id="privacy_policy" class="text-primary" role="button">
                            นโยบายความเป็นส่วนตัว
                        </span>
                    </li>
                    <li class="list-inline-item">
                        <span id="terms_of_use" class="text-primary" role="button">
                            ข้อกำหนดการใช้งาน
                        </span>
                    </li>
                    <li class="list-inline-item">
                        |
                    </li>
                    <li class="list-inline-item">
                        <span class="mb-0 text-capitalize">
                            <i class="fa-solid fa-arrows-rotate fa-spin me-1"></i>
                            Refresh หน้าภายใน
                            <span id="countdownDisplay">60</span>
                            วินาที
                        </span>
                    </li>
                </ul>
                <div class="right-panel">
                    &copy;
                    {{ date('Y') }}
                    By
                    <a href="{{ url('/') }}">
                        {{ $show_company_all_web->name_th ?? 'NOT FOUND' }}
                    </a>
                </div>
            </div>
        </footer>
        <!-- Footer Section End -->

        <!-- Modal แสดงพิมพ์บาร์โค้นสินค้า -->
        <div class="modal fade" id="modalShowPrintBarcodeProduct" tabindex="-1"
            aria-labelledby="modalShowPrintBarcodeProductLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalShowPrintBarcodeProductLabel">แสดงข้อมูล</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- แสดงข้อความ "กำลังโหลด..." ก่อน iframe -->
                        <div id="loadingMessagePrintBarcodeProduct" class="text-center">
                            <div class="spinner-border text-primary mb-2" role="status">
                                <span class="visually-hidden">กำลังโหลด...</span>
                            </div>
                            <p>กำลังโหลด...</p>
                        </div>
                        <!-- Iframe -->
                        <iframe id="iframePrintBarcodeProduct" class="w-100 border-0 overflow-x-hidden" height="220"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

<!-- Library Bundle Script -->
<script src="{{ asset('assets/js/core/libs.min.js') }}"></script>
<!-- Plugin Scripts -->
<!-- Tour plugin Start -->
{{-- <script src="{{ asset('assets/vendor/sheperd/dist/js/sheperd.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/tour.js') }}" data-name="{{ Auth::user()->name ?? '' }}" defer></script> --}}

<!-- Flatpickr Script -->
{{-- <script src="{{ asset('assets/vendor/flatpickr/dist/flatpickr.min.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/plugins/flatpickr.js') }}" defer></script> --}}

<!-- Slider-tab Script -->
<script src="{{ asset('assets/js/plugins/slider-tabs.js') }}"></script>

{{-- <script src="{{ asset('assets/select2/js/bootstrap.bundle.min.js') }}"
    integrity="sha384-sqIwnO0uI2Yo5qjwGXu2CgQyxB4G2c5xH9beSHsQuUC6wJO3aMSszc7u" crossorigin="anonymous"></script> --}}

<!-- Select2 -->
<script src="{{ asset('assets/js/plugins/select2.js') }}" defer></script>
<script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // $('.select2').select2({
        //     theme: 'bootstrap-5',
        //     width: '100%',
        //     allowClear: true, // ให้สามารถเคลียร์ค่าที่เลือกได้
        //     placeholder: 'กรุณาเลือก', // เพิ่ม Placeholder สำหรับ Select2
        // });
        $('.select2').each(function() {
            let hide_search = String($(this).data('select2-hide-search')) === "true";
            $(this).select2({
                theme: 'bootstrap-5',
                width: '100%',
                allowClear: true, // ให้สามารถเคลียร์ค่าที่เลือกได้
                placeholder: 'กรุณาเลือก', // เพิ่ม Placeholder สำหรับ Select2
                minimumResultsForSearch: hide_search ? -1 : 0
            });
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    });
</script>

<!-- Flatpickr -->
<script src="{{ asset('assets/flatpickr/js/flatpickr.js') }}"></script>
<script src="{{ asset('assets/flatpickr/js/lang/th.js') }}"></script>
{{-- <script src="{{ asset('assets/flatpickr/js/thaiBuddhistYearDisplayPlugin.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/flatpickr/js/flatpickr-init.js') }}"></script> --}}

<!-- Network Status -->
<script src="{{ Helper::versionedAsset('assets/js/network-status.js') }}"></script>

<!-- ป้องกันการกด Submit หลายครั้งในเวลาเดียวกัน -->
<script>
    $("form").on("submit", function() {
        // Event ลบ comma ก่อน submit form
        $('.input-comma').each(function() {
            $(this).val(removeCommas($(this).val())); // ลบ comma ก่อนส่งข้อมูล
        });

        //$(".btn").prop('disabled', true);
    });
</script>

<!-- เช็ควันที่เเริ่มต้นและวันที่สิ้นสุด -->
<script>
    $(document).ready(function() {
        $('#date_start, #date_end').on('change', function() {
            let date_start = new Date($('#date_start').val());
            let date_end = new Date($('#date_end').val());

            const Toast = Swal.mixin({ // Sweetalert2 Mixin
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            if (date_start > date_end) {
                Toast.fire({
                    icon: "warning",
                    title: "วันที่เริ่มต้นมากกว่าวันที่สิ้นสุด"
                });

                // ปรับให้ค่า date_end เท่ากับ date_start ถ้า date_end น้อยกว่า date_start
                const startVal = $('#date_start').val();
                const endEl = document.getElementById('date_end');
                if (endEl && endEl._flatpickr) {
                    endEl._flatpickr.setDate(startVal, true); // update value + trigger change
                } else {
                    $('#date_end').val(startVal).trigger('change');
                }
            } else if (date_end < date_start) {
                Toast.fire({
                    icon: "warning",
                    title: "วันที่สิ้นสุดน้อยกว่าวันที่เริ่มต้น"
                });

                // ปรับให้ค่า date_start เท่ากับ date_end ถ้า date_start มากกว่า date_end
                const endVal = $('#date_end').val();
                const startEl = document.getElementById('date_start');
                if (startEl && startEl._flatpickr) {
                    startEl._flatpickr.setDate(endVal, true); // update value + trigger change
                } else {
                    $('#date_start').val(endVal).trigger('change');
                }
            }
        });
    });
</script>

<!-- Lodash Utility -->
<script src="{{ asset('assets/vendor/lodash/lodash.min.js') }}"></script>

<!-- Utilities Functions -->
<script src="{{ asset('assets/js/iqonic-script/utility.js') }}"></script>

<!-- Settings Script -->
<script src="{{ asset('assets/js/iqonic-script/setting.js') }}"></script>

<!-- Settings Init Script -->
<script src="{{ asset('assets/js/setting-init.js') }}"></script>

<!-- External Library Bundle Script -->
<script src="{{ asset('assets/js/core/external.min.js') }}"></script>

<!-- Widgetchart Script -->
<script src="{{ Helper::versionedAsset('assets/js/charts/widgetcharts.js') }}" defer></script>

<!-- Dashboard Script -->
<script src="{{ Helper::versionedAsset('assets/js/charts/dashboard.js') }}" defer></script>
<script src="{{ Helper::versionedAsset('assets/js/charts/alternate-dashboard.js') }}" defer></script>

<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap5.min.js"></script>

<!-- FixedHeader plugin compatible with DataTables -->
<script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>

<!-- JSZip -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<!-- Buttons HTML5 Export JS -->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>

<!-- Buttons Print JS -->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<!-- Hopeui Script -->
<script src="{{ Helper::versionedAsset('assets/js/hope-ui.js') }}" defer></script>
<script src="{{ Helper::versionedAsset('assets/js/hope-uipro.js') }}" defer></script>
<script src="{{ Helper::versionedAsset('assets/js/sidebar.js') }}" defer></script>

<!-- Lightbox2 -->
<script src="{{ asset('assets/lightbox2/js/lightbox.js') }}"></script>

<!-- e commerce-->
{{-- <script src="{{ asset('assets/e-commerce/assets/js/ecommerce.js') }}" defer></script> --}}

<script>
    lightbox.option({
        'resizeDuration': 200, // ระยะเวลาในการปรับขนาดภาพ
        'wrapAround': true, // เลื่อนภาพจากภาพสุดท้ายไปภาพแรกได้
        'disableScrolling': true,
    });
</script>

<!-- Sweetalert2 -->
<script src="{{ asset('assets/sweetalert2/js/sweetalert2.all.min.js') }}"></script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.btn_submit_bill', function(e) {
            e.preventDefault();
            $(".btn").prop('disabled', true);
            var user_branch_id_old = @json(Auth::user()->branch_id ?? null);
            var user_branch_code_old = @json(Auth::user()->_branch->code ?? null);
            var user_branch_name_old = @json(Auth::user()->_branch->name ?? null);
            var form = $(this).closest('form');
            var msg = $(this).attr('alert-msg');
            var show_msg = msg ? msg + '<br>' : '';

            if (form[0].checkValidity()) {
                // ดึงค่าใหม่ของ user_branch_id จากเซิร์ฟเวอร์
                $.get("{{ route('user.ajax_get_auth_user') }}", function(response) {
                    var user_branch_id_now = response.result.branch_id;
                    var user_branch_code_now = response.result._branch.code;
                    var user_branch_name_now = response.result._branch.name;

                    // เช็คค่าที่โหลดมาใหม่กับค่าที่โหลดมาตอนแรก
                    if (user_branch_id_old != user_branch_id_now) {
                        Swal.fire({
                            title: "แจ้งเตือน",
                            html: `
                        <i class="fa-solid fa-shop me-1"></i>
                        สาขาของคุณมีการเปลี่ยนแปลง<br>คุณต้องการกลับมาอยู่สาขาเดิมไหม?<br>เพราะถ้าไม่กลับสาขาเดิมจะไม่สามารถทำรายการได้ เนื่องจากสินค้าในสต็อกจะไม่ตรงกับความเป็นจริง
                    `,
                            icon: "warning",
                            showDenyButton: false, // ❌ ปิดปุ่ม deny (No)
                            showCancelButton: true,
                            confirmButtonColor: "#1aa053",
                            denyButtonColor: "#3085d6",
                            cancelButtonColor: "#c03221",
                            confirmButtonText: `สาขาเดิม [${user_branch_code_old}]`,
                            cancelButtonText: `ยกเลิก`,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                setTimeout(() => {
                                    // ดึงปุ่มจาก SweetAlert2 ที่สร้างขึ้น
                                    let confirmBtn = document.querySelector('.swal2-confirm');
                                    let denyBtn = document.querySelector('.swal2-deny');

                                    // เพิ่ม data-bs-toggle="tooltip" และ title
                                    confirmBtn.setAttribute('data-bs-toggle', 'tooltip');
                                    confirmBtn.setAttribute('title', user_branch_name_old);

                                    denyBtn.setAttribute('data-bs-toggle', 'tooltip');
                                    denyBtn.setAttribute('title', user_branch_name_now);

                                    // เปิดใช้งาน Tooltip
                                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                                    tooltipTriggerList.map(function(tooltipTriggerEl) {
                                        return new bootstrap.Tooltip(tooltipTriggerEl);
                                    });
                                }, 100);
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // ใช้ค่าเดิม (user_branch_id_old) และส่งฟอร์มหลังจากอัปเดตสำเร็จ
                                updateUserBranch(user_branch_id_old, form);
                            } else if (result.isDenied) {
                                // ใช้ค่าปัจจุบัน (user_branch_id_now) และส่งฟอร์มหลังจากอัปเดตสำเร็จ
                                // updateUserBranch(user_branch_id_now, form);
                                submitFormWithConfirmation(form);
                            } else {
                                // ถ้ากดปิด ไม่ต้องทำอะไร
                                $(".btn").prop('disabled', false);
                                return;
                            }
                        });
                    } else {
                        // ถ้าค่าตรงกัน ให้ทำการตรวจสอบฟอร์มและส่งเลย
                        submitFormWithConfirmation(form, show_msg);
                    }
                });
            } else {
                $(".btn").prop('disabled', false);
                form[0].reportValidity();
            }
        });

        $(document).on('click', '.btn_submit', function(e) {
            e.preventDefault();
            $(".btn").prop('disabled', true);
            var user_branch_id_old = @json(Auth::user()->branch_id ?? null);
            var user_branch_code_old = @json(Auth::user()->_branch->code ?? null);
            var user_branch_name_old = @json(Auth::user()->_branch->name ?? null);
            var form = $(this).closest('form');
            var msg = $(this).attr('alert-msg');
            var show_msg = msg ? msg + '<br>' : '';

            if (form[0].checkValidity()) {
                // ดึงค่าใหม่ของ user_branch_id จากเซิร์ฟเวอร์
                $.get("{{ route('user.ajax_get_auth_user') }}", function(response) {
                    var user_branch_id_now = response.result.branch_id;
                    var user_branch_code_now = response.result._branch.code;
                    var user_branch_name_now = response.result._branch.name;

                    // เช็คค่าที่โหลดมาใหม่กับค่าที่โหลดมาตอนแรก
                    if (user_branch_id_old != user_branch_id_now) {
                        Swal.fire({
                            title: "แจ้งเตือน",
                            html: `
                        <i class="fa-solid fa-shop me-1"></i>
                        สาขาของคุณมีการเปลี่ยนแปลง<br>คุณต้องการอยู่สาขาไหน?
                    `,
                            icon: "warning",
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonColor: "#1aa053",
                            denyButtonColor: "#3085d6",
                            cancelButtonColor: "#c03221",
                            confirmButtonText: `สาขาเดิม [${user_branch_code_old}]`,
                            denyButtonText: `สาขาปัจจุบัน [${user_branch_code_now}]`,
                            cancelButtonText: `ยกเลิก`,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                setTimeout(() => {
                                    // ดึงปุ่มจาก SweetAlert2 ที่สร้างขึ้น
                                    let confirmBtn = document.querySelector('.swal2-confirm');
                                    let denyBtn = document.querySelector('.swal2-deny');

                                    // เพิ่ม data-bs-toggle="tooltip" และ title
                                    confirmBtn.setAttribute('data-bs-toggle', 'tooltip');
                                    confirmBtn.setAttribute('title', user_branch_name_old);

                                    denyBtn.setAttribute('data-bs-toggle', 'tooltip');
                                    denyBtn.setAttribute('title', user_branch_name_now);

                                    // เปิดใช้งาน Tooltip
                                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                                    tooltipTriggerList.map(function(tooltipTriggerEl) {
                                        return new bootstrap.Tooltip(tooltipTriggerEl);
                                    });
                                }, 100);
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // ใช้ค่าเดิม (user_branch_id_old) และส่งฟอร์มหลังจากอัปเดตสำเร็จ
                                updateUserBranch(user_branch_id_old, form);
                            } else if (result.isDenied) {
                                // ใช้ค่าปัจจุบัน (user_branch_id_now) และส่งฟอร์มหลังจากอัปเดตสำเร็จ
                                // updateUserBranch(user_branch_id_now, form);
                                submitFormWithConfirmation(form);
                            } else {
                                // ถ้ากดปิด ไม่ต้องทำอะไร
                                $(".btn").prop('disabled', false);
                                return;
                            }
                        });
                    } else {
                        // ถ้าค่าตรงกัน ให้ทำการตรวจสอบฟอร์มและส่งเลย
                        submitFormWithConfirmation(form, show_msg);
                    }
                });
            } else {
                $(".btn").prop('disabled', false);
                form[0].reportValidity();
            }
        });

        // ฟังก์ชันอัปเดตค่า branch_id และส่งฟอร์ม
        function updateUserBranch(branch_id, form) {
            $.post("{{ route('user.ajax_update_auth_user_branch_id') }}", {
                branch_id: branch_id,
                _token: "{{ csrf_token() }}"
            }).done(function(response) {
                Swal.fire({
                    title: "อัปเดตสำเร็จ",
                    text: "สาขาถูกอัปเดตเรียบร้อย! กำลังดำเนินการ",
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    submitFormWithConfirmation(form);
                });
            }).fail(function() {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด",
                    text: "ไม่สามารถอัปเดตสาขาได้ กรุณาลองใหม่",
                    icon: "error",
                    confirmButtonText: "ตกลง"
                });
            });
        }

        // ฟังก์ชันตรวจสอบฟอร์มและส่ง
        function submitFormWithConfirmation(form, show_msg = '') {
            if (form[0].checkValidity()) {
                Swal.fire({
                    title: "คุณแน่ใจไหม?",
                    html: show_msg + 'คุณต้องการยืนยันใช่หรือไม่?',
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#1aa053",
                    cancelButtonColor: "#c03221",
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: `<h3 class="mb-0 text-dark">กำลังประมวลผล</h3>`,
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
                            allowEscapeKey: false,
                        });
                        form.submit();
                    } else {
                        $(".btn").prop('disabled', false);
                    }
                });
            } else {
                $(".btn").prop('disabled', false);
                form[0].reportValidity();
            }
        }
    });
</script>

<script>
    $(document).on('click', '.btn_delete', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var msg = $(this).attr('alert-msg');

        $(".btn").prop('disabled', true);

        // ตรวจสอบความถูกต้องของฟอร์มก่อน
        if (form[0].checkValidity()) {
            Swal.fire({
                title: "คุณแน่ใจไหม?",
                html: 'คุณต้องการลบข้อมูล<br>' + msg + '<br>ใช่หรือไม่?',
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#1aa053",
                cancelButtonColor: "#c03221",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "ลบข้อมูลสำเร็จ",
                        icon: "success",
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        form.submit();
                    }, 500);
                } else {
                    $(".btn").prop('disabled', false);
                }
            });
        } else {
            // แสดงการแจ้งเตือน required ถ้ามีข้อผิดพลาด
            $(".btn").prop('disabled', false);
            form[0].reportValidity();
        }
    });
</script>

<script>
    $(document).on('click', '.btn_cancel', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var msg = $(this).attr('alert-msg');

        $(".btn").prop('disabled', true);

        // ตรวจสอบความถูกต้องของฟอร์มก่อน
        if (form[0].checkValidity()) {
            Swal.fire({
                title: "คุณแน่ใจไหม?",
                html: 'คุณต้องการยกเลิกข้อมูล<br>' + msg + '<br>ใช่หรือไม่?',
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#1aa053",
                cancelButtonColor: "#c03221",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ปิดหน้าต่าง"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Cancel!",
                        text: "ยกเลิกข้อมูลสำเร็จ",
                        icon: "success",
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        form.submit(); // ส่งฟอร์มหลังจากแสดง SweetAlert
                    }, 500);
                } else {
                    $(".btn").prop('disabled', false);
                }
            });
        } else {
            // แสดงการแจ้งเตือน required ถ้ามีข้อผิดพลาด
            $(".btn").prop('disabled', false);
            form[0].reportValidity();
        }
    });
</script>

<script>
    $("#privacy_policy").on("click", function() {
        Swal.fire({
            icon: "info",
            title: "นโยบายความเป็นส่วนตัว",
            html: "เว็บไซต์นี้เก็บรวบรวมข้อมูลส่วนบุคคลของผู้ใช้ เช่น ชื่อ, อีเมล, และข้อมูลการใช้งาน เพื่อปรับปรุงประสบการณ์การใช้งาน และเพื่อการตลาด เราจะรักษาข้อมูลของท่านเป็นความลับและจะไม่เปิดเผยต่อบุคคลที่สามโดยไม่ได้รับความยินยอมจากท่าน",
            confirmButtonText: "ตกลง",
            allowOutsideClick: false,
            allowEscapeKey: false
        });
    });

    $("#terms_of_use").on("click", function() {
        Swal.fire({
            icon: "info",
            title: "ข้อกำหนดการใช้งาน",
            text: "การใช้บริการนี้ ผู้ใช้ต้องปฏิบัติตามกฎระเบียบและเงื่อนไขที่กำหนด หากพบว่ามีการละเมิดกฎระเบียบหรือทำการใดๆ ที่ไม่เหมาะสม ผู้ดูแลระบบมีสิทธิ์ที่จะระงับหรือยกเลิกการใช้บริการได้ทันที",
            confirmButtonText: "ตกลง",
            allowOutsideClick: false,
            allowEscapeKey: false
        });
    });
</script>

<script>
    // ฟังก์ชันสำหรับเพิ่ม comma
    function formatNumberWithCommas(value) {
        return value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    // ฟังก์ชันสำหรับลบ comma
    function removeCommas(value) {
        return value.replace(/,/g, '');
    }

    /**
     * แปลงตัวเลขเป็นรูปแบบที่ใช้แสดงผลทางการเงิน:
     * - ปัดเศษเป็นทศนิยม 2 ตำแหน่ง (ปัดขึ้น, ปัดลง, หรือปัดตามปกติได้)
     * - ใส่ comma คั่นหลักพัน
     *
     * @param {number} value - ตัวเลขที่ต้องการแปลง
     * @param {string} [roundMethod='ceil'] - วิธีปัดเศษ: 'ceil' (ปัดขึ้น), 'floor' (ปัดลง), หรือ 'round' (ปัดตามปกติ)
     * @returns {string} - ตัวเลขที่ผ่านการจัดรูปแบบแล้ว (เช่น 1,234.56)
     */
    function formatCurrency(value, roundMethod = 'round') {
        let rounded;
        switch (roundMethod) {
            case 'floor': // ปัดลง
                rounded = Math.floor(value * 100) / 100;
                break;
            case 'round': // ปัดตามปกติ
                rounded = Math.round(value * 100) / 100;
                break;
            default: // ปัดขึ้น
                rounded = Math.ceil(value * 100) / 100;
        }
        return rounded.toFixed(2);
    }

    // ตรวจสอบให้คีย์ได้เฉพาะตัวเลขและทศนิยมเท่านั้น
    function validateInput(value) {
        return value.replace(/[^0-9.]/g, ''); // อนุญาตเฉพาะตัวเลขและจุดทศนิยม
    }

    // Event สำหรับเพิ่ม comma ขณะที่พิมพ์
    $(document).ready(function() {
        $(document).on("input", ".input-comma", function() {
            let value = $(this).val().replace(/,/g, ''); // ลบ comma ก่อนคำนวณใหม่
            value = validateInput(value); // กรองค่าเฉพาะตัวเลขและทศนิยม

            if (!isNaN(value) && value.length > 0) {
                $(this).val(formatNumberWithCommas(value));
            } else {
                $(this).val(''); // ถ้าค่าไม่ถูกต้อง ให้เคลียร์ช่อง input
            }
        });
    });
    // document.querySelectorAll('.input-comma').forEach(function(input) {
    //     input.addEventListener('input', function(e) {
    //         let value = e.target.value.replace(/,/g, ''); // ลบ comma ก่อนคำนวณใหม่
    //         value = validateInput(value); // กรองค่าเฉพาะตัวเลขและทศนิยม
    //         if (!isNaN(value) && value.length > 0) {
    //             e.target.value = formatNumberWithCommas(value);
    //         } else {
    //             e.target.value = ''; // ถ้าค่าไม่ถูกต้อง ให้เคลียร์ช่อง input
    //         }
    //     });
    // });

    // Event ลบ comma ก่อน submit form
    document.querySelector('form').addEventListener('submit', function(e) {
        document.querySelectorAll('.input-comma').forEach(function(input) {
            console.log('clear comma');
            input.value = removeCommas(input.value); // ลบ comma ก่อนส่งข้อมูล
        });
    });
</script>

{{-- @if (array_intersect(Auth::user()->department_role ?? [], ['SSTOCK', 'STOCK'])) --}}
<script>
    let inactivityTime = 60; // เวลา inactivity ในวินาที
    let timeout; // ตัวแปรเก็บ timeout
    let countdown; // ตัวแปรเก็บ countdown
    let countdownDisplay = document.getElementById('countdownDisplay'); // อ้างอิงไปที่ element ที่จะแสดง countdown

    function resetTimer() {
        clearTimeout(timeout);
        clearInterval(countdown); // ลบ countdown ก่อนหน้านี้

        // รีเซ็ตตัวนับถอยหลัง
        inactivityTime = 300; // ตั้งค่าใหม่เป็น 60 วินาที
        countdownDisplay.textContent = inactivityTime; // แสดงเวลาที่รีเซ็ต

        // ตั้ง countdown ใหม่
        countdown = setInterval(() => {
            inactivityTime--;
            countdownDisplay.textContent = inactivityTime; // อัปเดตแสดงเวลาที่เหลือ

            if (inactivityTime <= 0) {
                clearInterval(countdown); // หยุด countdown
                location.reload(); // รีเฟรชหน้าเมื่อถึง 0
            }
        }, 1000); // ทุก ๆ 1000 มิลลิวินาที (1 วินาที)
    }

    // ฟังก์ชันเช็คความเคลื่อนไหว
    document.addEventListener('mousemove', resetTimer);
    document.addEventListener('keypress', resetTimer);
    document.addEventListener('click', resetTimer);
    document.addEventListener('scroll', resetTimer);

    // เริ่มต้น timer และ countdown เมื่อโหลดหน้า
    resetTimer();
</script>
{{-- @endif --}}

<script>
    $(document).ready(function() {
        var currentUrl = window.location.pathname; // ดึง path ของ URL เช่น /bill/show/53

        if (
            !currentUrl.match(/^\/bill\/show\/\d+$/) &&
            !currentUrl.includes('/check_stock') &&
            !currentUrl.includes('/pos/storefront')
        ) {
            $(document).on("keydown", "input, select, textarea, button", function(e) {
                if (e.key === "Enter") { // ตรวจสอบว่ากดปุ่ม Enter หรือไม่
                    e.preventDefault(); // ป้องกันการ submit form

                    var allInputs = $("input, select, textarea, button").filter(":visible"); // เลือกเฉพาะที่มองเห็นได้
                    var index = allInputs.index(this); // หาตำแหน่งของ input ปัจจุบัน

                    if (index !== -1 && index < allInputs.length - 1) {
                        allInputs.eq(index + 1).focus(); // โฟกัสไปที่ input ถัดไป
                    }
                }
            });
        }
    });
</script>

<!-- [Start] ปิด DevTools + Reload หน้าหรือปิดเว็บ -->
{{-- @if (Auth::user()->_department->code != 'SADMIN')
    <script>
        function is_dev_tools() {
            $('body').html('');
            // $('.main-content').html('');
            console.clear();
            Swal.fire({
                title: "ตรวจพบ Developer Tools!",
                text: "กรุณาปิด Developer Tools ก่อนใช้งานเว็บไซต์นี้",
                icon: "error",
                confirmButtonText: "<i class='fa-solid fa-check me-1'></i> ตกลง",
                confirmButtonColor: "#1aa053",
                allowOutsideClick: false,
                allowEscapeKey: false,
                backdrop: '#FFFFFF'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "กำลังโหลดหน้าเว็บไซต์ใหม่!",
                        html: `<img src="{{ asset('assets/images/loader/Stampede.gif') }}">`,
                        icon: "success",
                        showConfirmButton: false,
                        backdrop: '#FFFFFF'
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            });
        }

        $(document).ready(function() {
            let dev_tools_opened = false; // ตัวแปรเช็คว่าแจ้งเตือนแล้วหรือยัง

            setInterval(() => {
                // ตรวจจับขนาดหน้าต่าง
                if (window.outerWidth - window.innerWidth > 200 ||
                    window.outerHeight - window.innerHeight > 200) {
                    if (!dev_tools_opened) {
                        dev_tools_opened = true;
                        is_dev_tools();
                    }
                }

                // ตรวจจับ Debugger
                let before = performance.now();
                debugger;
                let after = performance.now();
                if (after - before > 100 && !dev_tools_opened) {
                    dev_tools_opened = true;
                    is_dev_tools();
                }
            }, 500);
        });
    </script>
@endif --}}
<!-- [End] ปิด DevTools + Reload หน้าหรือปิดเว็บ -->

<script>
    $(".msg_sync_all_company").on("click", function() {
        Swal.fire({
            title: "การเชื่อมโยงข้อมูลระหว่างบริษัท",
            html: `
                ข้อมูลนี้เชื่อมกันทั้ง 3 บริษัท ได้แก่<br>
                บริษัท เซ็นทรัลแกรนด์ มีเดีย จำกัด<br>
                บริษัท เซ็นทรัล แกรนด์ เซาท์ 2005 จำกัด<br>
                บริษัท เซ็นทรัล มีเดีย กรุ๊ป 2005 จำกัด
            `,
            icon: "info",
            showCancelButton: false,
            confirmButtonColor: "#1aa053",
            confirmButtonText: "ตกลง",
            allowOutsideClick: false,
            allowEscapeKey: false
        });
    });
</script>

<script>
    $(document).ready(function() {
        $(document).on("click", ".show_modal_print_barcode_product", function() {
            var title = $(this).data("title");
            var url = $(this).data("url");

            $('#modalShowPrintBarcodeProductLabel').text(title);
            $("#loadingMessagePrintBarcodeProduct").show(); // แสดงข้อความ "กำลังโหลด..."
            $("#iframePrintBarcodeProduct").hide().attr("src", url); // ซ่อน iframe แล้วตั้งค่า src

            $("#modalShowPrintBarcodeProduct").modal("show"); // เปิด Modal
        });

        // เมื่อ iframe โหลดเสร็จ ให้ซ่อน loading และแสดง iframe
        $("#iframePrintBarcodeProduct").on("load", function() {
            $("#loadingMessagePrintBarcodeProduct").hide(); // ซ่อนข้อความ "กำลังโหลด..."
            $(this).show(); // แสดง iframe
        });

        // เมื่อปิด Modal ให้ล้างค่าของ iframe และแสดง loading ใหม่
        $("#modalShowPrintBarcodeProduct").on("hidden.bs.modal", function() {
            $("#iframePrintBarcodeProduct").attr("src", "").hide(); // ล้างค่า src และซ่อน iframe
            $("#loadingMessagePrintBarcodeProduct").show(); // แสดงข้อความ "กำลังโหลด..." ใหม่
        });
    });
</script>

<script>
    $(document).ready(function() {
        /*
            rel="noopener noreferrer"
            noopener: ป้องกันการเปิด window.opener ที่อาจทำให้หน้าใหม่ที่เปิดจากลิงก์สามารถควบคุมหรือเปลี่ยนแปลงหน้าปัจจุบันได้ ซึ่งเป็นการรักษาความปลอดภัยจากการโจมตีทางเว็บ
            noreferrer: ป้องกันไม่ให้ข้อมูล Referer (ข้อมูลเกี่ยวกับหน้าเว็บที่คลิกลิงก์มาจาก) ถูกส่งไปยังลิงก์ที่เปิดในแท็บใหม่ ซึ่งช่วยปกป้องข้อมูลของผู้ใช้จากการถูกเปิดเผย
        */
        $('a[target="_blank"]').each(function() {
            if (!$(this).attr('rel')) {
                $(this).attr('rel', 'noopener noreferrer');
            } else {
                $(this).attr('rel', $(this).attr('rel') + ' noopener noreferrer');
            }
        });
    });
</script>

{{-- <script>
    $(document).keydown(function(event) {
        if (event.ctrlKey && event.shiftKey && event.code === "KeyS") {
            event.preventDefault(); // ป้องกัน Ctrl + S จากการบันทึกหน้าเว็บ

            // ตรวจสอบว่ามี input, textarea หรือ select ที่ focus หรือไม่
            var focused_input = $("input:focus, textarea:focus, select:focus");

            if (focused_input.length > 0) {
                Swal.fire({
                    title: "กำลังส่งข้อมูล",
                    html: `<img src="{{ asset('assets/images/loader/Stampede.gif') }}">`,
                    icon: "info",
                    showConfirmButton: false,
                    showCloseButton: false,
                    showCancelButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
                focused_input.closest("form").submit(); // ทำการ submit form ที่ focus นั้น
            }
        }
    });
</script> --}}

<script>
    $(document).ready(function() {
        let ipAddressDetected = false;

        function tryNextIpSource(index = 0) {
            const ipSources = [
                "https://ipinfo.io/ip",
                "https://api.ipify.org",
                "https://trackip.net/ip",
                "https://ifconfig.me/ip",
                "https://icanhazip.com"
            ];

            if (ipAddressDetected || index >= ipSources.length) {
                return;
            }

            $.get(ipSources[index])
                .done(function(response) {
                    let ip = response.trim();
                    if (ip) {
                        ipAddressDetected = true; // เจอแล้ว หยุดเลย
                        const ipAuth = "{{ Auth::user()->ip ?? '' }}";

                        if (ip !== ipAuth) {
                            localStorage.setItem("last_sent_ip", ip);

                            $.ajax({
                                url: @json(route('user.ajax_check_and_update_ip')),
                                type: "POST",
                                contentType: "application/json",
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                                },
                                timeout: 2000,
                                data: JSON.stringify({
                                    ip
                                }),
                                success: function(res) {
                                    console.log('IP Address:', res);
                                },
                                error: function() {
                                    console.warn('ส่ง IP ไม่สำเร็จ');
                                }
                            });
                        }
                    }
                })
                .fail(function() {
                    tryNextIpSource(index + 1);
                });
        }
        // tryNextIpSource(); // เริ่มต้นการดึง IP

        // เก็บ Location ลง Session
        $.post("{{ route('user.ajax_update_location_to_session') }}", {
            _token: "{{ csrf_token() }}"
        });
    });
</script>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            Toast.fire({
                icon: "success",
                title: "คัดลอกแล้ว"
            });
        }, function(err) {
            console.error("Copy failed:", err);
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof flatpickr === 'undefined') return;

        function setAltBE(instance) {
            if (!instance || !instance.altInput) return;
            if (instance.selectedDates && instance.selectedDates.length) {
                const g = flatpickr.formatDate(instance.selectedDates[0], instance.config.altFormat, instance.l10n);
                instance.altInput.value = g.replace(/\b(\d{4})\b/, m => String(parseInt(m, 10) + 543));
            } else {
                instance.altInput.value = '';
            }
        }

        function addTodayButton(instance) {
            if (!instance || !instance.calendarContainer) return;

            const container = instance.calendarContainer;

            // Ensure a footer container exists
            let footer = container.querySelector('.flatpickr-footer');
            if (!footer) {
                footer = document.createElement('div');
                footer.className = 'flatpickr-footer';
                footer.style.display = 'flex';
                footer.style.justifyContent = 'flex-end';
                footer.style.gap = '8px';
                footer.style.padding = '6px 8px';
                footer.style.borderTop = '1px solid #eee';
                container.appendChild(footer);
            }

            // If the button already exists for this instance, do nothing
            let btnToday = footer.querySelector('.flatpickr-today-btn');
            if (btnToday) return;

            // Create Today button
            btnToday = document.createElement('button');
            btnToday.type = 'button';
            btnToday.className = 'flatpickr-today-btn btn btn-sm btn-outline-primary';
            btnToday.textContent = 'วันนี้';
            btnToday.addEventListener('click', function() {
                const now = new Date();
                // setDate(date, triggerChange, dateStr)
                instance.setDate(now, true);
                // ปิดปฏิทินหลังเลือก
                instance.close();
            });

            footer.appendChild(btnToday);
        }

        // ใส่ BE year overlay ใน flatpickr header
        function updateCalendarBEHeader(instance) {
            if (!instance || !instance.calendarContainer) return;
            const gYear = instance.currentYear; // Gregorian
            const beYear = gYear + 543;
            const cm = instance.calendarContainer.querySelector('.flatpickr-current-month');
            if (!cm) return;

            // Find the numeric year input wrapper
            const wrap = cm.querySelector('.numInputWrapper');
            const yearInput = cm.querySelector('.cur-year');
            if (!wrap || !yearInput) return;

            // Inject/update overlay to show BE year
            let overlay = wrap.querySelector('.be-year-overlay');
            if (!overlay) {
                overlay = document.createElement('span');
                overlay.className = 'be-year-overlay';
                wrap.appendChild(overlay);
            }
            overlay.textContent = beYear; // show 2568 etc.
        }

        // ---- NEW: Reusable initializer (keeps your existing config and formats) ----
        window.initFlatpickrBE = function(scope) {
            const root = (scope && scope instanceof HTMLElement) ? scope : document;
            const nodes = root.querySelectorAll('input[type="date"], input.flatpickr_thai_be, input[data-fp-be]');
            nodes.forEach(function(el) {
                if (el.hasAttribute('data-fp-ignore') || el.classList.contains('no-flatpickr')) return;
                if (el._flatpickr) return; // already initialized
                if (el.getAttribute('type') === 'date') el.setAttribute('type', 'text');

                flatpickr(el, {
                    altInput: true,
                    altFormat: 'd/m/Y', // แสดง dd/mm/YYYY แล้วค่อยบวก 543 เฉพาะใน alt
                    dateFormat: 'Y-m-d', // ค่า submit เก็บเป็น ค.ศ.
                    allowInput: false,
                    locale: (flatpickr.l10ns && flatpickr.l10ns.th) ? flatpickr.l10ns.th : flatpickr.l10ns.default,
                    onReady(selectedDates, dateStr, instance) {
                        setAltBE(instance);
                        addTodayButton(instance);
                        updateCalendarBEHeader(instance);
                    },
                    onOpen(selectedDates, dateStr, instance) {
                        updateCalendarBEHeader(instance);
                    },
                    onMonthChange(selectedDates, dateStr, instance) {
                        updateCalendarBEHeader(instance);
                    },
                    onYearChange(selectedDates, dateStr, instance) {
                        updateCalendarBEHeader(instance);
                    },
                    onValueUpdate(selectedDates, dateStr, instance) {
                        setAltBE(instance);
                        updateCalendarBEHeader(instance);
                    }
                });
            });
        };

        // Initial run for existing inputs
        window.initFlatpickrBE(document);

        // ---- NEW: Auto-initialize for dynamically added nodes (e.g., cloned rows) ----
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((m) => {
                m.addedNodes.forEach((node) => {
                    if (!(node instanceof HTMLElement)) return;
                    if (node.matches && node.matches('input[type="date"], input.flatpickr_thai_be, input[data-fp-be]')) {
                        window.initFlatpickrBE(node);
                    } else if (node.querySelector) {
                        const targetChild = node.querySelector('input[type="date"], input.flatpickr_thai_be, input[data-fp-be]');
                        if (targetChild) window.initFlatpickrBE(node);
                    }
                });
            });
        });
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    });
</script>

{{-- <script>
    $(function() {
        // ค่าปัจจุบันของสาขา จาก server
        let currentBranchId = @json(Auth::user()->branch_id);

        // เมื่อผู้ใช้คลิกเปลี่ยนสาขา
        $('.change-branch-link').on('click', function() {
            const newBranchId = $(this).data('branch-id');
            // เช็คก่อนว่าเปลี่ยนจริงมั้ย
            if (newBranchId !== currentBranchId) {
                localStorage.setItem('current_branch_id', newBranchId);
            }
        });

        // ฟังการเปลี่ยนแปลงจาก localStorage ใน tab อื่น
        window.addEventListener('storage', function(event) {
            if (event.key === 'current_branch_id') {
                if (event.newValue !== currentBranchId) {
                    // แจ้งเตือน หรือ refresh
                    Swal.fire({
                        title: `<h3 class="mb-0 text-dark">สาขาหลักของคุณถูกเปลี่ยนแล้ว</h3><span class="fs-5 text-primary">กรุณากดปุ่ม "รีหน้าใหม่"</span>`,
                        showConfirmButton: true,
                        confirmButtonText: '<i class="fa-solid fa-rotate-right me-1"></i> รีหน้าใหม่',
                        confirmButtonColor: "#1aa053",
                        showCloseButton: false,
                        showCancelButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }
            }
        });
    });
</script> --}}

@yield('script')

</html>
