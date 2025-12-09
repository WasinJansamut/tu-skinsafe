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

    <!-- FixedHeader plugin compatible with DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">

    <!-- Flatpickr -->
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/flatpickr/css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ Helper::versionedAsset('assets/flatpickr/css/themes/airbnb.css') }}">

    <link rel="preload" as="image" href="{{ asset('assets/images/dashboard/top-header1.png') }}" fetchpriority="high">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    {{-- @vite('resources/js/app.js') --}}

    <style>
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
    @include('layouts.loading')
    <!-- loader END -->

    @include('layouts.menu')

    <main class="main-content">
        @include('layouts.header')

        <div class="iq-navbar-header" style="height: 0px;">
            <div class="iq-header-img overflow-hidden">
                <img src="{{ asset('assets/images/dashboard/top-header1.png') }}" alt="header"
                    class="theme-color-default-img img-fluid w-100 h-100 pe-none">
            </div>
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
                </ul>
                <div class="right-panel">
                    &copy;
                    {{ date('Y') }}
                    By
                    <a href="{{ url('/') }}">
                        {{ config('app.name') ?? 'NOT FOUND' }}
                    </a>
                </div>
            </div>
        </footer>
        <!-- Footer Section End -->
    </main>
</body>

<!-- Library Bundle Script -->
<script src="{{ asset('assets/js/core/libs.min.js') }}"></script>

<!-- Slider-tab Script -->
<script src="{{ asset('assets/js/plugins/slider-tabs.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('assets/js/plugins/select2.js') }}" defer></script>
<script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
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

<!-- ป้องกันการกด Submit หลายครั้งในเวลาเดียวกัน -->
<script>
    $("form").on("submit", function(e) {
        // ถ้าไม่ผ่าน HTML5 validation
        if (!this.checkValidity()) {
            e.preventDefault(); // กันไม่ให้ submit
            e.stopPropagation();
            return; // ออกจาก function ไม่ต้อง disable ปุ่ม
        }

        // ผ่าน validation แล้ว ค่อย disable ปุ่ม
        $(".btn").prop('disabled', true);
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

<!-- Sweetalert2 -->
<script src="{{ asset('assets/sweetalert2/js/sweetalert2.all.min.js') }}"></script>

<script>
    $("#privacy_policy").on("click", function() {
        Swal.fire({
            icon: "info",
            title: "นโยบายความเป็นส่วนตัว",
            html: "xxxxxx<br>xxxxxxx<br>xxxxxxxxx<br>xxxxxxxxxx<br>xxxxxxxxxxx<br>xxxxxxxxxxxx<br>xxxxxxxxxxxxx",
            confirmButtonText: "ตกลง",
            allowOutsideClick: false,
            allowEscapeKey: false
        });
    });

    $("#terms_of_use").on("click", function() {
        Swal.fire({
            icon: "info",
            title: "ข้อกำหนดการใช้งาน",
            html: "xxxxxx<br>xxxxxxx<br>xxxxxxxxx<br>xxxxxxxxxx<br>xxxxxxxxxxx<br>xxxxxxxxxxxx<br>xxxxxxxxxxxxx",
            confirmButtonText: "ตกลง",
            allowOutsideClick: false,
            allowEscapeKey: false
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

@yield('script')

</html>
