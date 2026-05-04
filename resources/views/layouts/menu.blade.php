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

                @if (auth()->user()?->role === 'admin' || !\App\Models\User::where('role', 'admin')->exists())
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('user') || Request::is('user/*') ? 'active' : '' }}"
                            href="{{ route('user.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="User Manage" data-bs-placement="right">
                                <i class="fa-solid fa-users"></i>
                            </i>
                            <span class="item-name">User Manage</span>
                        </a>
                    </li>

                    <li>
                        <hr class="hr-horizontal">
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('questionnaire/responses') || Request::is('questionnaire/responses/*') ? 'active' : '' }}"
                            href="{{ route('questionnaire.responses') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="แบบสอบถามยืนยันความต้องการ" data-bs-placement="right">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </i>
                            <span class="item-name">แบบสอบถามยืนยันความต้องการ</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('questionnaire/summary') ? 'active' : '' }}"
                            href="{{ route('questionnaire.summary') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="ผลรวมแบบสอบถามยืนยันความต้องการ" data-bs-placement="right">
                                <i class="fa-solid fa-chart-column"></i>
                            </i>
                            <span class="item-name">ผลรวมแบบสอบถามยืนยันความต้องการ</span>
                        </a>
                    </li>
                    <li>
                        <hr class="hr-horizontal">
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('evaluation/responses') || Request::is('evaluation/responses/*') ? 'active' : '' }}"
                            href="{{ route('evaluation.responses') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="คำตอบแบบประเมิน" data-bs-placement="right">
                                <i class="fa-solid fa-clipboard-check"></i>
                            </i>
                            <span class="item-name">คำตอบแบบประเมิน</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('evaluation/summary') ? 'active' : '' }}"
                            href="{{ route('evaluation.summary') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="ผลรวมแบบประเมิน" data-bs-placement="right">
                                <i class="fa-solid fa-chart-simple"></i>
                            </i>
                            <span class="item-name">ผลรวมแบบประเมิน</span>
                        </a>
                    </li>
                @endif
            </ul>
            <!-- Sidebar Menu End -->
        </div>
    </div>
    <div class="sidebar-footer"></div>
</aside>
