<aside class="sidebar sidebar-base " id="first-tour" data-toggle="main-sidebar" data-sidebar="responsive">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="{{ url('/') }}" class="navbar-brand my-1 py-2">
            <!--Logo start-->
            <div class="logo-main">
                <div class="logo-normal">
                    <img src="{{ asset('assets/images/logo/logo.png') }}" width="28" height="28" loading="lazy">
                </div>
                <div class="logo-mini">
                    <img src="{{ asset('assets/images/logo/logo.png') }}" width="28" height="28" loading="lazy">
                </div>
            </div>
            <!--logo End-->
            <h4 class="logo-title fw-bold ms-1" style="color: #bd1d27">
                <span style="color:#bd1d27">TU</span><span style="color:#032775"> SkinSafe</span>
            </h4>
        </a>
        <script>
            var total_noti = 0;
        </script>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg class="icon-20" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list">
            <!-- Sidebar Menu Start -->
            <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('home') || Request::is('/') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('home') }}">
                        <i class="icon" data-bs-toggle="tooltip" title="หน้าหลัก" data-bs-placement="right">
                            <img src="{{ asset('assets/images/icons/home.svg') }}" width="20" height="20" loading="lazy">
                        </i>
                        <span class="item-name">หน้าหลัก</span>
                    </a>
                </li>

                <li>
                    <hr class="hr-horizontal">
                </li>
            </ul>
            <!-- Sidebar Menu End -->
        </div>
    </div>
    <div class="sidebar-footer"></div>
</aside>
