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
                <h4 class="logo-title fw-bold d-block d-xl-none ms-1" style="color: #bd1d27">
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
                                        {{ Auth::user()->name ?? '' }}
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
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fa-solid fa-arrow-right-from-bracket me-1"></i>
                                        ออกจากระบบ
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--Nav End-->
</div>
