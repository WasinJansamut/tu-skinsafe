<div class="position-relative">
    <!--Nav Start-->
    <nav class="nav navbar navbar-expand-xl navbar-light iq-navbar header-hover-menu left-border">
        <div class="container-fluid navbar-inner">
            <!-- Logo + System name -->
            <a href="{{ url('/') }}" class="navbar-brand p-0">
                <div class="logo-main text-primary">
                    <div class="logo-normal">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" width="32" height="32" loading="lazy">
                    </div>
                    <div class="logo-mini">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" width="32" height="32" loading="lazy">
                    </div>
                </div>
                <h4 class="logo-title d-block d-xl-none ms-1">
                    {{ config('app.name') ?? 'NOT FOUND' }}
                </h4>
            </a>

            <!-- ขวาสุด -->
            <div class="d-flex align-items-center ms-auto">
                <span class="btn btn-sm btn-icon btn-outline-secondary me-3 d-xl-none" role="button"
                    onclick="Swal.fire({ title: 'กำลัง Refresh กรุณารอสักครู่', toast: true, position: 'top-end', showConfirmButton: false, didOpen: (toast) => { Swal.showLoading(); setTimeout(() => { location.reload(); }, 1000); } });">
                    <i class="fa-solid fa-arrows-rotate fa-lg"></i>
                </span>

                <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                    <i class="icon d-flex">
                        <svg class="icon-20" width="20" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                        </svg>
                    </i>
                </div>
            </div>

            <div class="offcanvas offcanvas-end shadow-none iq-product-menu-responsive on-rtl end w-100" tabindex="-1"
                id="offcanvasBottom">
                <div class="offcanvas-body">
                    <ul class="iq-nav-menu list-unstyled">
                        <li class="nav-item active ">
                            <a class="nav-link menu-arrow justify-content-start py-0 px-1 ms-1" data-bs-toggle="collapse"
                                href="#branch_relate_date" role="button" aria-expanded="false"
                                aria-controls="branch_relate_date">
                                <h4 class="nav-text mb-0">
                                    <i class="fa-solid fa-shop me-2 text-primary"></i>
                                    [{{ Auth::user()->_branch->code ?? '' }}]
                                    {{ Auth::user()->_branch->name ?? '' }}
                                </h4>
                            </a>
                            @php
                                // ทำแคชข้อมูลสาขาที่เชื่อมต่อ ไว้ 60 วินาที
                                $header_users_branch_relate = Cache::remember('branch_user_relate_' . Auth::user()->id, 60, function () {
                                    return App\Models\UserBranchRelate::select('branch_id')
                                        ->where('user_id', Auth::user()->id)
                                        ->with('_branch:id,code,name')
                                        ->get();
                                });
                            @endphp
                            @if (!empty($header_users_branch_relate))
                                <ul class="iq-header-sub-menu list-unstyled collapse shadow-sm" id="branch_relate_date">
                                    @foreach ($header_users_branch_relate as $row)
                                        <li class="nav-item">
                                            <a class="nav-link @if ($row->branch_id == Auth::user()->branch_id) active disabled @endif change-branch-link"
                                                href="{{ route('user.change_main_branch', $row->branch_id) }}" data-branch-id="{{ $row->branch_id }}">
                                                [{{ $row->_branch->code }}]
                                                {{ $row->_branch->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>

            {{-- <div class="breadcrumb-title border-end me-3 pe-3 d-none d-xl-block">

            </div> --}}

            <div class="d-flex align-items-center">
                <button id="navbar-toggle" class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <span class="navbar-toggler-bar bar1 mt-1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
                    <li class="nav-item dropdown me-0 me-xl-3">
                        <div class="d-flex align-items-center mr-2 iq-font-style" role="group"
                            aria-label="First group" data-setting="radio">
                            <input type="radio" class="btn-check" name="theme_font_size" value="theme-fs-sm"
                                id="font-size-sm">
                            <label for="font-size-sm" class="btn btn-border border-0 btn-icon btn-sm"
                                data-bs-toggle="tooltip" title="ขนาดตัวอักษร 14px" data-bs-placement="bottom">
                                <span class="mb-0 h6" style="color: inherit !important;">A</span>
                            </label>
                            <input type="radio" class="btn-check" name="theme_font_size" value="theme-fs-md"
                                id="font-size-md">
                            <label for="font-size-md" class="btn btn-border border-0 btn-icon" data-bs-toggle="tooltip"
                                title="ขนาดตัวอักษร 16px" data-bs-placement="bottom">
                                <span class="mb-0 h4" style="color: inherit !important;">A</span>
                            </label>
                            <input type="radio" class="btn-check" name="theme_font_size" value="theme-fs-lg"
                                id="font-size-lg">
                            <label for="font-size-lg" class="btn btn-border border-0 btn-icon" data-bs-toggle="tooltip"
                                title="ขนาดตัวอักษร 18px" data-bs-placement="bottom">
                                <span class="mb-0 h2" style="color: inherit !important;">A</span>
                            </label>
                        </div>
                    </li>
                    <li class="nav-item dropdown border-end pe-3 d-none d-xl-block">
                        <form action="{{ route('bill.find') }}" method="GET" class="form-group input-group mb-0 search-input">
                            <input type="text" class="form-control" name="invoice_no" placeholder="ค้นหาบิล..." required>
                            <button type="submit" class="btn btn-primary btm-sm border border-1 border-dark px-3">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </li>
                    {{-- <li class="nav-item dropdown border-end pe-3 d-none d-xl-block">

                        <div class="form-group input-group mb-0 search-input">
                            <input type="text" class="form-control" placeholder="ค้นหา">
                            <span class="input-group-text">
                                <svg class="icon-20" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    </circle>
                                    <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </li> --}}
                    {{-- <li class="nav-item dropdown iq-responsive-menu border-end d-block d-xl-none me-3">
                        <div class="btn btn-sm bg-body" id="navbarDropdown-search-11" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                </circle>
                                <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown-search-11"
                            style="width: 25rem;">
                            <li class="px-3 py-0">
                                <div class="form-group input-group mb-0">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="input-group-text">
                                        <svg class="icon-20" width="20" height="20" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            </circle>
                                            <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </li> --}}
                    <li class="nav-item iq-full-screen d-none d-xl-block" id="fullscreen-item">
                        <a href="#" class="nav-link" id="btnFullscreen" data-bs-toggle="dropdown">
                            <div class="btn btn-primary btn-icon btn-sm rounded-pill">
                                <span class="btn-inner">
                                    <svg class="normal-screen icon-24" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18.5528 5.99656L13.8595 10.8961" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M14.8016 5.97618L18.5524 5.99629L18.5176 9.96906" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M5.8574 18.896L10.5507 13.9964" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M9.60852 18.9164L5.85775 18.8963L5.89258 14.9235" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <svg class="full-normal-screen d-none icon-24" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.7542 10.1932L18.1867 5.79319" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M17.2976 10.212L13.7547 10.1934L13.7871 6.62518" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M10.4224 13.5726L5.82149 18.1398" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M6.74391 13.5535L10.4209 13.5723L10.3867 17.2755"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item dropdown" id="itemdropdown1">
                        <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Helper::checkImageExists(Auth::user()->profile_image) }}" class="rounded-circle"
                                width="32" height="32" loading="lazy">
                            <span class="ms-2 text-center">
                                <div class="text-dark">
                                    {{ Auth::user()->name ?? '' }}
                                </div>
                                <div>
                                    <span class="badge rounded-pill bg-secondary-subtle">
                                        [Lv.{{ Auth::user()->level_id ?? '0' }}]
                                        {{ Auth::user()->_department->name_th ?? 'ไม่พบแผนก' }}
                                    </span>
                                </div>
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('user.my_profile_edit') }}">
                                    ข้อมูลส่วนตัว
                                </a>
                            </li>
                            {{-- <li>
                                <a class="dropdown-item" href="#">
                                    การตั้งค่าความเป็นส่วนตัว
                                </a>
                            </li> --}}
                            {{-- <li>
                                <span class="dropdown-item"
                                    onclick="IQUtils.removeSessionStorage('tour'); location.reload()">
                                    แนะนำหน้าต่างโปรแกรม
                                </span>
                            </li> --}}
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}">
                                    <i class="fa-solid fa-arrow-right-from-bracket me-1"></i>
                                    ออกจากระบบ
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--Nav End-->
</div>
