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
            <h4 class="logo-title ms-1">
                {{ config('app.name') ?? 'NOT FOUND' }}
                <div style="font-size: .55em; font-family: 'Serif';">
                    v.{{ $encoded_hashids }}
                </div>
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
                {{-- <li class="nav-item static-item">
                    <a class="nav-link static-item disabled text-start" href="#" tabindex="-1">
                        <span class="default-icon" style="letter-spacing: 0rem;">
                            <div class="w-100">
                                <i class="fa-solid fa-signature me-1"></i>
                                {{ Auth::user()->name ?? '' }}
                            </div>
                            <div class="w-100">
                                <span class="badge rounded-pill bg-dark">
                                    {{ Auth::user()->_department->name_th ?? '' }}
                                </span>
                            </div>
                        </span>
                        <span class="mini-icon text-dark" data-bs-toggle="tooltip"
                            title="{{ Auth::user()->name ?? '' }}" data-bs-placement="right">
                            <i class="fa-solid fa-signature"></i>
                        </span>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('home') }}">
                        <i class="icon" data-bs-toggle="tooltip" title="หน้าหลัก" data-bs-placement="right">
                            <img src="{{ asset('assets/images/icons/home.svg') }}" width="20" height="20" loading="lazy">
                        </i>
                        <span class="item-name">หน้าหลัก</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('check_stock') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('check_stock.index') }}">
                        <i class="icon" data-bs-toggle="tooltip" title="เช็คสต็อก" data-bs-placement="right">
                            <img src="{{ asset('assets/images/icons/product.svg') }}" width="20" height="20" loading="lazy">
                        </i>
                        <span class="item-name">เช็คสต็อก</span>
                    </a>
                </li>
                {{-- ================== สินค้าในคลัง ================== --}}
                @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SSALES', 'SACC', 'SALES', 'SALESF', 'ACC', 'SSTOCK', 'STOCK']))
                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item  text-start" tabindex="-1">
                            <span class="default-icon">สินค้าในคลัง</span>
                            <i class="fa fa-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="['SADMIN', 'SSALES', 'SACC', 'SALES', 'SALESF', 'ACC', 'SSTOCK', 'STOCK']"></i>
                            <span class="mini-icon" data-bs-toggle="tooltip" title="สินค้าในคลัง"
                                data-bs-placement="right">-</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('warehouse_stock') ? 'active' : '' }}"
                            aria-current="page" href="{{ route('warehouse_stock.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="สินค้าในคลัง" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/vender.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">สินค้าในคลัง</span>
                        </a>
                    </li>
                @endif

                {{-- ================== End สินค้าในคลัง================== --}}

                <!-- [Start] การขาย -->
                @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SSALES', 'SALES', 'SALESF', 'SSTOCK', 'STOCK', 'SACC', 'ACC']))
                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item  text-start" href="#" tabindex="-1">
                            <span class="default-icon">การขาย</span>
                            <i class="fa fa-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="['SADMIN', 'SSALES', 'SALES', 'SALESF', 'SSTOCK', 'STOCK', 'SACC', 'ACC']"></i>
                            <span class="mini-icon" data-bs-toggle="tooltip" title="การขาย"
                                data-bs-placement="right">-</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('pos/*') ? 'active' : '' }}" aria-current="page" href="{{ route('pos.storefront') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="{{ __('ขายหน้าร้าน') }}" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/cashier.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">{{ __('ขายหน้าร้าน') }}</span>
                            <span class="badge rounded-pill bg-success">POS</span>
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Request::is('bill*') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('bill.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="1. ใบเสนอราคา" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/bill.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">1. ใบเสนอราคา *** </span>
                            <span class="badge rounded-pill bg-success">NN</span>
                        </a>
                    </li> --}}

                    @foreach ($departmentMenus as $menu)
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('bill*') && Request::query('code') == $menu->code ? 'active' : '' }}"
                                aria-current="page"
                                href="{{ $menu->code === 'NS' ? route('bill.create') : route('bill.index', ['code' => $menu->code]) }}">
                                <i class="icon" data-bs-toggle="tooltip" title="{{ $menu->name_menu }}"
                                    data-bs-placement="right">
                                    <img src="{{ asset($menu->icon) }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">{{ $menu->name_menu }}</span>
                                @if ($menu->show_count != 0)
                                    <span class="badge rounded-pill {{ $menu->bg_class ?? '' }}">
                                        {{ $menu->_bills_count }}
                                    </span>

                                    @if ($menu->sound_alert == 1 && $menu->_bills_count > 0)
                                        {{-- จัดเก็บตัวแปรเล่นเสียง --}}
                                        <script>
                                            var total_noti = {{ $menu->_bills_count }};
                                        </script>
                                    @endif
                                @endif
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('vehicle_route*') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('vehicle_route.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลสายรถ" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/schedule.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ข้อมูลสายรถ</span>
                        </a>
                    </li>
                    @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SACC', 'ACC', 'SALES', 'SALES']))
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('bill_note*') ? 'active' : '' }}" aria-current="page"
                                href="{{ route('bill_note.index') }}">
                                <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลใบแจ้งหนี้/วางบิล" data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/bill-payment.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">ข้อมูลใบแจ้งหนี้/วางบิล </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('purchase_order*') ? 'active' : '' }}" aria-current="page"
                                href="{{ route('purchase_order.index') }}">
                                <i class="icon" data-bs-toggle="tooltip" title="ใบสั่งซื้อ" data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/bill.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">ใบสั่งซื้อ</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('receipt*') ? 'active' : '' }}" aria-current="page"
                                href="{{ route('receipt.index') }}">
                                <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลใบรับชำระหนี้" data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/receipt.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">ใบรับชำระหนี้</span>
                                <span class="badge rounded-pill bg-warning" data-bs-toggle="tooltip" title="จำนวนที่ไม่ได้อนุมัติของใบรับชำระหนี้ที่ไม่อัปโหลดสลิป" data-bs-placement="top">
                                    {{ $tab_menu_receipt_not_slip_payment_and_not_approve_count }}
                                </span>
                            </a>
                        </li>
                    @endif
                @endif
                <!-- [End] การขาย -->

                @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SACC', 'ACC', 'SSTOCK', 'STOCK']))
                    {{-- ================== บัญชี ================== --}}
                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item  text-start" href="#" tabindex="-1">
                            <span class="default-icon">บัญชี</span>
                            <i class="fa fa-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="['SADMIN', 'SACC', 'ACC']"></i>
                            <span class="mini-icon" data-bs-toggle="tooltip" title="บัญชี"
                                data-bs-placement="right">-</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('receipt*') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('receipt.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลใบรับชำระหนี้" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/receipt.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ใบรับชำระหนี้</span>
                            <span class="badge rounded-pill bg-warning" data-bs-toggle="tooltip" title="จำนวนที่ไม่ได้อนุมัติของใบรับชำระหนี้ที่ไม่อัปโหลดสลิป" data-bs-placement="top">
                                {{ $tab_menu_receipt_not_slip_payment_and_not_approve_count }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('product') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('product.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลสินค้า (แผนกบัญชี)" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/product.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ข้อมูลสินค้า (แผนกบัญชี)</span>
                        </a>
                    </li>
                    {{-- ================== End บัญชี================== --}}
                @endif

                @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SSTOCK', 'STOCK', 'SACC', 'ACC']))
                    {{-- ==================นับสต็อก================== --}}
                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item text-start" href="#" tabindex="-1">
                            <span class="default-icon">นับสต็อก</span>
                            <i class="fa fa-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="['SADMIN', 'SSTOCK', 'STOCK', 'SACC', 'ACC']"></i>
                            <span class="mini-icon" data-bs-toggle="tooltip" title="รับสินค้าเข้า"
                                data-bs-placement="right">-</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('warehouse_inventory*') ? 'active' : '' }}"
                            aria-current="page" href="{{ route('warehouse_inventory.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="นับสต็อก" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/list.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">นับสต็อก</span>
                            <span class="badge rounded-pill bg-warning">
                                {{ $warehouseInventoryCount ?? 0 }}
                            </span>

                            @if (!empty($warehouseInventoryCount) && $warehouseInventoryCount > 0)
                                {{-- จัดเก็บตัวแปรเล่นเสียง --}}
                                <script>
                                    var total_noti = {{ $warehouseInventoryCount }};
                                </script>
                            @endif
                        </a>
                    </li>

                    @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SACC', 'ACC']))
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('warehouse_stock/reduction*') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('warehouse_reduction.index') }}">
                                <i class="icon" data-bs-toggle="tooltip" title="ปรับปรุงลดสต็อก" data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/vender.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">ปรับปรุงลดสต็อก (ลด)</span>
                            </a>
                        </li>
                    @endif

                    @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SACC', 'ACC']))
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('warehouse_begin_balance*') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('warehouse_begin_balance.index') }}">
                                <i class="icon" data-bs-toggle="tooltip" title="สินค้ายกมา" data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/vender.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">สินค้ายกมา/เพิ่มจากการผลิต</span>
                            </a>
                        </li>
                    @endif
                    {{-- ================== End นับสต็อก ================== --}}
                @endif





                @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SSTOCK', 'STOCK', 'SACC', 'ACC']))
                    {{-- ==================รับสินค้าเข้า================== --}}
                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item text-start" href="#" tabindex="-1">
                            <span class="default-icon">รับสินค้าเข้า</span>
                            <i class="fa fa-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="['SADMIN', 'SSTOCK', 'STOCK', 'SACC', 'ACC']"></i>
                            <span class="mini-icon" data-bs-toggle="tooltip" title="รับสินค้าเข้า"
                                data-bs-placement="right">-</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('receive_vender*') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('receive_vender.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="รับเข้าจากเจ้าหนี้" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/vender.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">รับเข้าจากเจ้าหนี้</span>
                            <span class="badge rounded-pill bg-danger me-1">{{ $status1Count }}</span>
                            <span class="badge rounded-pill bg-warning">{{ $status2Count }}</span>
                        </a>
                    </li>

                    @if (empty(array_intersect(Auth::user()->department_role ?? [], ['SSTOCK', 'STOCK'])))
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('product_swap*') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('product_swap.index') }}">
                                <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลสลับสินค้า"
                                    data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/swap.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">สลับสินค้า</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('report.accounting.debtor.customer_unpaid') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="ลูกหนี้ค้างชำระ" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ลูกหนี้ค้างชำระ</span>
                            {{-- เอาเฉพาะที่ยังไม่จ่าย ถ้าจ่ายไม่ครบก็เอามา --}}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('report.accounting.debtor.sales_tax') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="รายงานภาษีขาย" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">รายงานภาษีขาย</span>
                        </a>
                    </li>


                    {{-- ================== End รับสินค้าเข้า================== --}}
                @endif


                @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SACC', 'ACC']))
                    {{-- ==================ใบลดหนี้ CN / CNN ================== --}}
                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item text-start" href="#" tabindex="-1">
                            <span class="default-icon">ใบลดหนี้ (CN/CNN)</span>
                            <i class="fa fa-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="['SADMIN', 'SACC', 'ACC']"></i>
                            <span class="mini-icon" data-bs-toggle="tooltip" title="ใบลดหนี้"
                                data-bs-placement="right">-</span>
                        </a>
                    </li>

                    {{-- 🔹 ใบลดหนี้ลูกหนี้ (Customer Credit Note) --}}
                    <li class="nav-item static-item px-3 text-muted small fw-bold">ลูกหนี้</li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ Request::is('credit-notes/create') ? 'active' : '' }}"
                            href="{{ route('credit-notes.create') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="เพิ่มใบลดหนี้ลูกหนี้" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/add2.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">เพิ่มใบลดหนี้ลูกหนี้</span>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('credit-notes') ? 'active' : '' }}"
                            href="{{ route('credit-notes.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="รายการใบลดหนี้ลูกหนี้" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/cn.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ใบลดหนี้ลูกหนี้</span>
                        </a>
                    </li>

                    {{-- 🔸 ใบลดหนี้เจ้าหนี้ (Supplier Credit Note) --}}
                    <li class="nav-item static-item px-3 text-muted small fw-bold mt-2">เจ้าหนี้</li>
                    {{-- <li class="nav-item ">
                        <a class="nav-link disabled {{ Request::is('credit-notes/supplier/create') ? 'active' : '' }}"
                            href="{{ route('credit-notes.supplier.create') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="เพิ่มใบลดหนี้เจ้าหนี้" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/add2.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">เพิ่มใบลดหนี้เจ้าหนี้</span>
                        </a>
                    </li> --}}
                    <li class="nav-item ">
                        <a class="nav-link  {{ Request::is('credit-notes/supplier') ? 'active' : '' }}"
                            href="{{ route('credit-notes.supplier.index_supplier') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="รายการใบลดหนี้เจ้าหนี้" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/cn.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ใบลดหนี้เจ้าหนี้</span>
                        </a>
                    </li>
                    {{-- ================== End CN/CNN ================== --}}
                @endif





                @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'DRIVER']))
                    {{-- ================== Start คนขับ Driver================== --}}
                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled text-start" href="#" tabindex="-1">
                            <span class="default-icon">พนักงานขับรถ</span>
                            <span class="mini-icon" data-bs-toggle="tooltip" title="พนักงานขับรถ"
                                data-bs-placement="right">-</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('my_vehicle_round') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('my_vehicle_round.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="รอบรถของฉัน" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/schedule.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">รอบรถของฉัน</span>
                        </a>
                    </li>

                    @foreach ($departmentMenus as $menu)
                        @if (in_array($menu->code, ['RS', 'IT', 'FD', 'AP']))
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('my_vehicle_round/bill*') && Request::query('code') == $menu->code ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('my_bill.bill', ['code' => $menu->code]) }}">
                                    <i class="icon" data-bs-toggle="tooltip" title="{{ $menu->name_menu }}"
                                        data-bs-placement="right">
                                        <img src="{{ asset($menu->icon) }}" width="20" height="20" loading="lazy">
                                    </i>
                                    <span class="item-name">{{ $menu->name_menu }}</span>
                                    @if ($menu->show_count != 0)
                                        <span class="badge rounded-pill {{ $menu->bg_class ?? '' }}">
                                            {{ $menu->_bills_count }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                        @endif
                    @endforeach
                    {{-- ================== End คนขับ Driver================== --}}
                @endif

                @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SSALES', 'SALES', 'SACC', 'ACC']))
                    <!-- [Start] โอนสินค้า -->
                    <li>
                        <hr class="hr-horizontal">
                    </li>

                    <li class="nav-item static-item">
                        <a class="nav-link static-item text-start" href="#" tabindex="-1">
                            <span class="default-icon">โอนสินค้า</span>
                            <i class="fa fa-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="['SADMIN', 'SSALES', 'SALES', 'SSTOCK', 'STOCK', 'SACC', 'ACC']"></i>
                            <span class="mini-icon" data-bs-toggle="tooltip" title="โอนสินค้า"
                                data-bs-placement="right">-</span>
                        </a>
                    </li>
                    @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SSALES', 'SALES', 'SACC', 'ACC']))
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('warehouse_stock/all') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('warehouse_stock.index_all') }}">
                                <i class="icon" data-bs-toggle="tooltip" title="เช็คสินค้าสาขาอื่น"
                                    data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/vender.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">เช็คสินค้าสาขาอื่น</span>
                            </a>
                        </li>
                    @endif
                    @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SACC', 'ACC']))
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('product_transfer/my_branch*') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('product_transfer.my_branch_index') }}">
                                <i class="icon" data-bs-toggle="tooltip" title="เราขอโอนจากสาขาอื่น"
                                    data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/transfer.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">โอนสินค้าให้สาขาอื่น</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('product_transfer/other_branch*') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('product_transfer.other_branch_index') }}">
                                <i class="icon" data-bs-toggle="tooltip" title="ตอบรับใบโอน"
                                    data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/transfer.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">ตอบรับใบโอน</span>
                                <span class="badge rounded-pill bg-warning">{{ $transfer_status1 }}</span>
                            </a>
                        </li>
                    @endif
                    <!-- [End] โอนสินค้า -->
                @endif

                @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SACC', 'ACC']))
                    {{-- ================== หัก ณ ที่จ่าย================== --}}
                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item text-start" href="#" tabindex="-1">
                            <span class="default-icon">หัก ณ ที่จ่าย</span>
                            <i class="fa fa-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="['SADMIN','SACC', 'ACC']"></i>
                            <span class="mini-icon" data-bs-toggle="tooltip" title="จัดการ"
                                data-bs-placement="right">-</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#menu_withholding" role="button"
                            aria-expanded="false" aria-controls="sidebar-special">
                            <i class="icon" data-bs-toggle="tooltip" title="หัก ณ ที่จ่าย" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/tax.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">หัก ณ ที่จ่าย</span>
                            <i class="right-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" class="icon-18"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="menu_withholding" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('withholding*') && (!Request::is('withholding/contact*') && !Request::is('withholding/save_draft*')) ? 'active' : '' }}"
                                    href="{{ route('withholding.index') }}">
                                    <span data-bs-toggle="tooltip" title="หัก ณ ที่จ่าย" data-bs-placement="right">
                                        <i class="icon">
                                            <img src="{{ asset('assets/images/icons/tax.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                        <i class="sidenav-mini-icon">
                                            <img src="{{ asset('assets/images/icons/tax.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                    </span>
                                    <span class="item-name">หัก ณ ที่จ่าย</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('withholding/report*') ? 'active' : '' }}"
                                    href="{{ route('withholding.report') }}">
                                    <span data-bs-toggle="tooltip" title="รายงาน" data-bs-placement="right">
                                        <i class="icon">
                                            <img src="{{ asset('assets/images/icons/tax.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                        <i class="sidenav-mini-icon">
                                            <img src="{{ asset('assets/images/icons/tax.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                    </span>
                                    <span class="item-name">รายงาน</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('withholding/contact*') ? 'active' : '' }}"
                                    href="{{ route('withholding_contact.index') }}">
                                    <span data-bs-toggle="tooltip" title="ผู้ติดต่อ" data-bs-placement="right">
                                        <i class="icon">
                                            <img src="{{ asset('assets/images/icons/contact.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                        <i class="sidenav-mini-icon">
                                            <img src="{{ asset('assets/images/icons/contact.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                    </span>
                                    <span class="item-name">ผู้ติดต่อ</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- ================== End หัก ณ ที่จ่าย================== --}}
                @endif

                <!--================== [Start] ช่าง================== -->
                @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SSERVICE', 'SERVICE']))
                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SSERVICE']))
                        <li class="nav-item static-item">
                            <a class="nav-link static-item text-start" href="#" tabindex="-1">
                                <span class="default-icon">ช่าง</span>
                                <i class="fa fa-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="['SADMIN', 'SSERVICE', 'SERVICE']"></i>
                                <span class="mini-icon" data-bs-toggle="tooltip" title="ช่าง"
                                    data-bs-placement="right">-</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('machine*') ? 'active' : '' }}" aria-current="page"
                                href="{{ route('machine.index') }}">
                                <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลเครื่อง" data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/machine.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">ข้อมูลเครื่อง</span>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item static-item">
                        <a class="nav-link static-item text-start" href="#" tabindex="-1">
                            <span class="default-icon">งานซ่อม / ช่าง</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('technician/jobs/new*') ? 'active' : '' }}"
                            href="{{ route('technician.jobs.index', ['status' => 'new']) }}">
                            <i class="fa fa-file-alt text-primary me-1"></i>
                            <span class="item-name ms-1">1. ใบงานใหม่</span>
                            <span class="badge rounded-pill bg-primary float-end">{{ $tech_new_jobs ?? 0 }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('technician/jobs/in_progress*') ? 'active' : '' }}"
                            href="{{ route('technician.jobs.index', ['status' => 'in_progress']) }}">
                            <i class="fa fa-spinner text-warning me-1"></i>
                            <span class="item-name ms-1">2. กำลังดำเนินการ</span>
                            <span class="badge rounded-pill bg-warning float-end">{{ $tech_inprogress_jobs ?? 0 }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('technician/jobs/problem*') ? 'active' : '' }}"
                            href="{{ route('technician.jobs.index', ['status' => 'problem']) }}">
                            <i class="fa fa-exclamation-triangle text-danger me-1"></i>
                            <span class="item-name ms-1">3. มีปัญหา</span>
                            <span class="badge rounded-pill bg-danger float-end">{{ $tech_problem_jobs ?? 0 }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('technician/jobs/waiting_check*') ? 'active' : '' }}"
                            href="{{ route('technician.jobs.index', ['status' => 'waiting_check']) }}">
                            <i class="fa fa-check-double text-info me-1"></i>
                            <span class="item-name ms-1">4. จบงานแล้ว <small>(รอตรวจสอบ)</small></span>
                            <span class="badge rounded-pill bg-info float-end">{{ $tech_waiting_check_jobs ?? 0 }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('technician/jobs/closed*') ? 'active' : '' }}"
                            href="{{ route('technician.jobs.index', ['status' => 'closed']) }}">
                            <i class="fa fa-clipboard-check text-success me-1"></i>
                            <span class="item-name ms-1">5 .ปิดงานแล้ว</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('technician/report') ? 'active' : '' }}"
                            href="{{ route('technician.report.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="รายงานการปฏิบัติงานของช่าง">
                                <img src="{{ asset('assets/images/icons/report.svg') }}" width="20" height="20">
                            </i>
                            <span class="item-name">รายงานการปฏิบัติงานช่าง</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('technician/report/allowance*') ? 'active' : '' }}"
                            href="{{ route('technician.report.allowance') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="รายงานคำนวนเบี้ยเลี้ยงช่าง">
                                <img src="{{ asset('assets/images/icons/report.svg') }}" width="20" height="20">
                            </i>
                            <span class="item-name">รายงานคำนวนเบี้ยเลี้ยงช่าง</span>
                        </a>
                    </li>
                @endif
                <!--================== [End] ช่าง  ==================-->

                {{-- ================== รายงาน================== --}}
                <li>
                    <hr class="hr-horizontal">
                </li>
                @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SSALES', 'SACC', 'SALES', 'SALESF', 'ACC', 'DRIVER', 'SSTOCK']))
                    <li class="nav-item static-item">
                        <a class="nav-link static-item  text-start" href="#" tabindex="-1">
                            <span class="default-icon">รายงาน </span>
                            <i class="fa fa-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="['SADMIN', 'SSALES', 'SACC', 'ACC','DRIVER','SSTOCK']"></i>
                            <span class="mini-icon" data-bs-toggle="tooltip" title="รายงาน"
                                data-bs-placement="right">-</span>
                        </a>
                    </li>

                    {{-- ///// รายงานแผนกขาย ///// --}}
                    @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SSALES', 'SALES', 'SACC', 'ACC']))
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#menu_report_sales" role="button"
                                aria-expanded="false" aria-controls="sidebar-special">
                                <i class="icon" data-bs-toggle="tooltip" title="รายงานแผนกขาย"
                                    data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/report.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">รายงานแผนกขาย</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" class="icon-18"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>

                            <ul class="sub-nav collapse" id="menu_report_sales" data-bs-parent="#sidebar-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('bill/find') ? 'active' : '' }}"
                                        aria-current="page" href="{{ route('bill.find') }}">
                                        <i class="icon" data-bs-toggle="tooltip" title="รายงานบิลขายทุกสถานะ" data-bs-placement="right">
                                            <img src="{{ asset('assets/images/icons/bill.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                        <span class="item-name">บิลขายทุกสถานะ</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('report.accounting.debtor.sales_summary') }}">
                                        <i class="icon" data-bs-toggle="tooltip" title="สรุปยอดขายสินค้า" data-bs-placement="right">
                                            <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                        <span class="item-name">สรุปยอดขายสินค้า</span>


                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('report.accounting.debtor.customer_unpaid') }}">
                                        <i class="icon" data-bs-toggle="tooltip" title="ลูกหนี้ค้างชำระ" data-bs-placement="right">
                                            <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                        <span class="item-name">ลูกหนี้ค้างชำระ</span>
                                        {{-- เอาเฉพาะที่ยังไม่จ่าย ถ้าจ่ายไม่ครบก็เอามา --}}
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('report.accounting.debtor.sales_tax') }}">
                                        <i class="icon" data-bs-toggle="tooltip" title="รายงานภาษีขาย" data-bs-placement="right">
                                            <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                        <span class="item-name">รายงานภาษีขาย</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endif
                    {{-- ///// End รายงานแผนกขาย ///// --}}


                    {{-- ///// รายงานแผนกบัญชี ///// --}}
                    @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SACC', 'ACC']))
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#menu_report_acc_main" role="button"
                                aria-expanded="false" aria-controls="menu_report_acc_main">
                                <i class="icon" data-bs-toggle="tooltip" title="รายงานแผนกบัญชี" data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/bill.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">รายงานแผนกบัญชี</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" class="icon-18"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>

                            <ul class="sub-nav collapse" id="menu_report_acc_main" data-bs-parent="#sidebar-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('bill/find') ? 'active' : '' }}"
                                        aria-current="page" href="{{ route('bill.find') }}">
                                        <i class="icon" data-bs-toggle="tooltip" title="ดูเอกสารแนบบิล" data-bs-placement="right">
                                            <img src="{{ asset('assets/images/icons/bill.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                        <span class="item-name">ดูเอกสารแนบบิล</span>
                                    </a>
                                </li>

                                {{-- ลูกหนี้ --}}
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="collapse" href="#menu_report_acc_debtor" role="button"
                                        aria-expanded="false" aria-controls="menu_report_acc_debtor">
                                        <i class="icon"><img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy"></i>
                                        <span class="item-name">ลูกหนี้</span>
                                        <i class="right-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" class="icon-18"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </i>
                                    </a>

                                    <ul class="sub-nav collapse" id="menu_report_acc_debtor">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('report.accounting.debtor.sales_summary') }}">สรุปยอดขายสินค้า</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('report.accounting.debtor.product_movement') }}">ความเคลื่อนไหวสินค้ารายตัว</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('report.accounting.debtor.inventory') }}">สินค้าในคลัง</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('report.accounting.debtor.product_cost') }}">สินค้าคงเหลือ และ ต้นทุนสินค้า</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('report.accounting.debtor.customer_unpaid') }}">
                                                ลูกหนี้ค้างชำระ
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('report.accounting.debtor.customer_unpaid_installment') }}">
                                                รายงานสินค้าเงินผ่อน
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('report.accounting.debtor.received_cheques') }}">
                                                รายงานเช็ครับ
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('report.accounting.debtor.sales_tax') }}">รายงานภาษีขาย</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('report.accounting.debtor.gl_credit_sales') }}">แยกประเภททั่วไป (GL)</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('report.accounting.debtor.export_express') }}">Export to Express </a>
                                        </li>
                                    </ul>

                                </li>

                                {{-- เจ้าหนี้ --}}
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="collapse" href="#menu_report_acc_creditor" role="button"
                                        aria-expanded="false" aria-controls="menu_report_acc_creditor">
                                        <i class="icon"><img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy"></i>
                                        <span class="item-name">เจ้าหนี้</span>
                                        <i class="right-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" class="icon-18"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </i>
                                    </a>
                                    <ul class="sub-nav collapse" id="menu_report_acc_creditor">
                                        <ul class="sub-nav collapse" id="menu_report_acc_creditor">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('report.accounting.creditor.purchase_vat') }}">รายงานภาษีซื้อ </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('report.accounting.creditor.supplier_summary') }}">สรุปยอดซื้อสินค้าจากเจ้าหนี้</a>
                                            </li>
                                        </ul>

                                    </ul>
                                </li>

                            </ul>
                        </li>
                    @endif
                    {{-- ///// End รายงานแผนกบัญชี ///// --}}

                    {{-- ///// รายงานแผนกจัดส่ง ///// --}}
                    @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SACC', 'ACC', 'SSTOCK', 'DRIVER']))
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#menu_report_driver" role="button"
                                aria-expanded="false" aria-controls="sidebar-special">
                                <i class="icon" data-bs-toggle="tooltip" title="รายงานแผนกจัดส่ง"
                                    data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/truck.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">รายงานแผนกจัดส่ง</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" class="icon-18"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>

                            <ul class="sub-nav collapse" id="menu_report_driver" data-bs-parent="#sidebar-menu">


                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('report_bill_driver') ? 'active' : '' }}"
                                        aria-current="page" href="{{ route('report_bill_driver.index') }}">
                                        <i class="icon" data-bs-toggle="tooltip" title="รายงานรอบรถและบัดดี้" data-bs-placement="right">
                                            <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                        <span class="item-name">รายงานรอบรถและบัดดี้</span>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link  {{ Request::is('report_bill_driver/commission*') ? 'active' : '' }}"
                                        aria-current="page" href="{{ route('report_bill_driver.commission') }}">
                                        <i class="icon" data-bs-toggle="tooltip" title="การจัดส่งและเบี้ยเลี้ยง" data-bs-placement="right">
                                            <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                        <span class="item-name">การจัดส่งและเบี้ยเลี้ยง</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link  {{ Request::is('report_bill_driver/bill_success') ? 'active' : '' }}"
                                        aria-current="page" href="{{ route('report_bill_driver.bill_success') }}">
                                        <i class="icon" data-bs-toggle="tooltip" title="รายงานที่ถูกจัดส่งสำเร็จ" data-bs-placement="right">
                                            <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                        <span class="item-name">รายงานที่ถูกจัดส่งสำเร็จ</span>
                                    </a>
                                </li>

                                {{-- <li class="nav-item">
                                <a class="nav-link disabled {{ Request::is('xxx') ? 'active' : '' }}" aria-current="page"
                                    href="{{ route('bill.find') }}">
                                    <i class="icon" data-bs-toggle="tooltip" title="XXX"
                                        data-bs-placement="right">
                                        <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20"
                                            height="20">
                                    </i>
                                    <span class="item-name">XXX</span>
                                </a>
                            </li> --}}
                            </ul>
                        </li>
                        {{-- ///// End รายงานแผนกจัดส่ง ///// --}}
                    @endif




                @endif {{-- ==================End รายงาน================== --}}


                @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'HR']))
                    {{-- ==================ฝ่ายบุคคล HR ================== --}}
                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item text-start" href="#" tabindex="-1">
                            <span class="default-icon">ฝ่ายบุคคล</span>
                            <i class="fa fa-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="['SADMIN','HR']"></i>
                            <span class="mini-icon" data-bs-toggle="tooltip" title="ฝ่ายบุคคล" data-bs-placement="right">-</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('vehicles_for_manage*') ? 'active' : '' }}"
                            href="{{ route('vehicles_for_manage.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/vehicle.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ข้อมูลรถ (ธุรการ)</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('user*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="จัดการผู้ใช้งาน" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/user.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">จัดการผู้ใช้งาน</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('report_bill_driver*') ? 'active' : '' }}"
                            href="{{ route('report_bill_driver.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="รายงานคนขับรถ" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/report.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">รายงานคนขับรถ</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('report_bill_driver/bill_success') ? 'active' : '' }}"
                            href="{{ route('report_bill_driver.bill_success') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="รายงานที่ถูกจัดส่งสำเร็จ" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/report.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">รายงานที่ถูกจัดส่งสำเร็จ(คนขับ)</span>
                        </a>
                    </li>
                @endif

                @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SSALES', 'SACC', 'SALES', 'SALESF', 'ACC']))
                    {{-- ==================จัดการข้อมูล================== --}}
                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item text-start" href="#" tabindex="-1">
                            <span class="default-icon">จัดการข้อมูล</span>
                            <i class="fa fa-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="['SADMIN','SSALES','SALES']"></i>
                            <span class="mini-icon" data-bs-toggle="tooltip" title="จัดการข้อมูล"
                                data-bs-placement="right">-</span>
                        </a>
                    </li>
                    @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN']))
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#menu_product" role="button"
                                aria-expanded="false" aria-controls="sidebar-special">
                                <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลสินค้า"
                                    data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/product.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">
                                    ข้อมูลสินค้า
                                    <small class="msg_sync_all_company text-danger ms-1" role="button"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="ข้อมูลนี้เชื่อมกันทั้ง 3 บริษัท<br>ได้แก่ CGM CGS CMG"
                                        data-bs-html="true">
                                        <i class="fa-solid fa-database"></i>
                                    </small>
                                </span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" class="icon-18"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="menu_product" data-bs-parent="#sidebar-menu">

                                <li class="nav-item">
                                    <a class="nav-link {{ (Request::is('product') || Request::is('product/*')) && !Request::is('product/catalog*') && !Request::is('product/brand*') && !Request::is('product/spec*') && !Request::is('product/sort_catalog*') && !Request::is('product_swap*') ? 'active' : '' }}"
                                        href="{{ route('product.index') }}">
                                        <span data-bs-toggle="tooltip" title="สินค้า" data-bs-placement="right">
                                            <i class="icon">
                                                <img src="{{ asset('assets/images/icons/product.svg') }}"
                                                    width="20" height="20" loading="lazy">
                                            </i>
                                            <i class="sidenav-mini-icon">
                                                <img src="{{ asset('assets/images/icons/product.svg') }}"
                                                    width="20" height="20" loading="lazy">
                                            </i>
                                        </span>
                                        <span class="item-name">สินค้าทั้งหมด</span>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('product/sort_catalog*') ? 'active' : '' }}"
                                        href="{{ route('product.index_sort_catalog') }}">
                                        <span data-bs-toggle="tooltip" title="รายงานสินค้าแยกประเภท" data-bs-placement="right">
                                            <i class="icon">
                                                <img src="{{ asset('assets/images/icons/report.svg') }}"
                                                    width="20" height="20" loading="lazy">
                                            </i>
                                            <i class="sidenav-mini-icon">
                                                <img src="{{ asset('assets/images/icons/report.svg') }}"
                                                    width="20" height="20" loading="lazy">
                                            </i>
                                        </span>
                                        <span class="item-name">รายงานสินค้าแยกประเภท</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('product/catalog*') ? 'active' : '' }}"
                                        href="{{ route('product_catalog.index') }}">
                                        <span data-bs-toggle="tooltip" title="ประเภท" data-bs-placement="right">
                                            <i class="icon">
                                                <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                                            </i>
                                            <i class="sidenav-mini-icon">
                                                <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                                            </i>
                                        </span>
                                        <span class="item-name">ประเภท</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('product/brand*') ? 'active' : '' }}"
                                        href="{{ route('product_brand.index') }}">
                                        <span data-bs-toggle="tooltip" title="แบรนด์" data-bs-placement="right">
                                            <i class="icon">
                                                <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                                            </i>
                                            <i class="sidenav-mini-icon">
                                                <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                                            </i>
                                        </span>
                                        <span class="item-name">แบรนด์</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('product/spec*') ? 'active' : '' }}"
                                        href="{{ route('product_spec.index') }}">
                                        <span data-bs-toggle="tooltip" title="สเปค" data-bs-placement="right">
                                            <i class="icon">
                                                <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                                            </i>
                                            <i class="sidenav-mini-icon">
                                                <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                                            </i>
                                        </span>
                                        <span class="item-name">สเปค</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    @endif

                    @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN']))
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('branch*') ? 'active' : '' }}" aria-current="page"
                                href="{{ route('branch.index') }}">
                                <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลสาขา"
                                    data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/store.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">ข้อมูลสาขา</span>
                            </a>
                        </li>
                    @endif
                    @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN', 'SACC', 'ACC']))
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('company_contact*') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('company_contact.index') }}">
                                <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลลูกค้า/เจ้าหนี้"
                                    data-bs-placement="right">
                                    <img src="{{ asset('assets/images/icons/business-card.svg') }}" width="20" height="20" loading="lazy">
                                </i>
                                <span class="item-name">ข้อมูลลูกค้า/เจ้าหนี้</span>
                            </a>
                        </li>
                    @endif
                    {{-- ================== End จัดการข้อมูล================== --}}
                @endif

                @if (array_intersect(Auth::user()->department_role ?? [], ['SADMIN']))
                    <!-- [Start] จัดการข้อมูลเริ่มต้น -->
                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item text-start" href="#" tabindex="-1">
                            <span class="default-icon">จัดการข้อมูลเริ่มต้น</span>
                            <i class="fa fa-info-circle ms-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="['SADMIN']"></i>
                            <span class="mini-icon" data-bs-toggle="tooltip" title="จัดการข้อมูลเริ่มต้น"
                                data-bs-placement="right">-</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('user*') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('user.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลผู้ใช้งาน" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/user.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ข้อมูลผู้ใช้งาน</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#menu_vehicle" role="button"
                            aria-expanded="false" aria-controls="sidebar-special">
                            <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลรถ" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/vehicle.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ข้อมูลรถ</span>
                            <i class="right-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" class="icon-18"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="menu_vehicle" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('vehicle/type*') ? 'active' : '' }}"
                                    href="{{ route('vehicle_type.index') }}">
                                    <span data-bs-toggle="tooltip" title="ประเภทรถ" data-bs-placement="right">
                                        <i class="icon">
                                            <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                        <i class="sidenav-mini-icon">
                                            <img src="{{ asset('assets/images/icons/dot.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                    </span>
                                    <span class="item-name">ประเภทรถ</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('vehicle') && Request::is('vehicle/*') && !Request::is('vehicle/type*') && !Request::is('vehicle_route*') ? 'active' : '' }}"
                                    href="{{ route('vehicle.index') }}">
                                    <span data-bs-toggle="tooltip" title="รถ" data-bs-placement="right">
                                        <i class="icon">
                                            <img src="{{ asset('assets/images/icons/vehicle.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                        <i class="sidenav-mini-icon">
                                            <img src="{{ asset('assets/images/icons/vehicle.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                    </span>
                                    <span class="item-name">รถ</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('vehicles_for_manage*') ? 'active' : '' }}"
                                    href="{{ route('vehicles_for_manage.index') }}">
                                    <span data-bs-toggle="tooltip" title="จัดการข้อมูลรถทุกบริษัท (ธุรการ)" data-bs-placement="right">
                                        <i class="icon">
                                            <img src="{{ asset('assets/images/icons/vehicle.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                        <i class="sidenav-mini-icon">
                                            <img src="{{ asset('assets/images/icons/vehicle.svg') }}" width="20" height="20" loading="lazy">
                                        </i>
                                    </span>
                                    <span class="item-name">รถ(ธุรการ)</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('vehicle_route*') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('vehicle_route.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลสายรถ" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/schedule.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ข้อมูลสายรถ</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('promotion*') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('promotion.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลโปรโมชั่น" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/promotion.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">
                                ข้อมูลโปรโมชั่น
                                <small class="msg_sync_all_company text-danger ms-1" role="button"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="ข้อมูลนี้เชื่อมกันทั้ง 3 บริษัท<br>ได้แก่ CGM CGS CMG" data-bs-html="true">
                                    <i class="fa-solid fa-database"></i>
                                </small>
                            </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('department*') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('department.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลแผนก" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/department.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ข้อมูลแผนก</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('branch*') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('branch.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลสาขา" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/store.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ข้อมูลสาขา</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('report_rate_driver*') ? 'active' : '' }}"
                            aria-current="page" href="{{ route('report_rate_driver.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="การคำนวนเบี้ยเลี้ยงคนขับ" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/truck.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">การคำนวนเบี้ยเลี้ยงคนขับ</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('payment_channel*') ? 'active' : '' }}"
                            aria-current="page" href="{{ route('payment_channel.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลช่องทางการชำระเงิน" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/store.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ข้อมูลช่องทางการชำระเงิน</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('company_information*') ? 'active' : '' }}"
                            aria-current="page" href="{{ route('company_information.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลบริษัท" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/setting.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ข้อมูลบริษัท</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('bank_account*') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('bank_account.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="ข้อมูลบัญชีธนาคาร" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/bank.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">ข้อมูลบัญชีธนาคาร</span>
                        </a>
                    </li>
                    <!-- [End] จัดการข้อมูลเริ่มต้น -->

                    <li>
                        <hr class="hr-horizontal">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('log*') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('log.index') }}">
                            <i class="icon" data-bs-toggle="tooltip" title="บันทึกเหตุการณ์" data-bs-placement="right">
                                <img src="{{ asset('assets/images/icons/log.svg') }}" width="20" height="20" loading="lazy">
                            </i>
                            <span class="item-name">บันทึกเหตุการณ์</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('manual*') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('manual.index') }}">
                        <i class="icon" data-bs-toggle="tooltip" title="คู่มือการใช้งาน"
                            data-bs-placement="right">
                            <img src="{{ asset('assets/images/icons/log.svg') }}" width="20" height="20" loading="lazy">
                        </i>
                        <span class="item-name">คู่มือการใช้งาน</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" aria-current="page"
                        href="{{ url('clear_cache') }}">
                        <i class="icon" data-bs-toggle="tooltip" title="clear_cache"
                            data-bs-placement="right">
                            <img src="{{ asset('assets/images/icons/setting.svg') }}" width="20" height="20" loading="lazy">
                        </i>
                        <span class="item-name">Clear Cache</span>
                    </a>
                </li>


                <li>
                    <hr class="hr-horizontal">
                </li>

                {{-- <li class="nav-item static-item">
                    <a class="nav-link static-item disabled text-start" href="#" tabindex="-1">
                        <span class="default-icon">Home</span>
                        <span class="mini-icon" data-bs-toggle="tooltip" title="Home"
                            data-bs-placement="right">-</span>
                    </a>
                </li> --}}
            </ul>
            <!-- Sidebar Menu End -->
        </div>
    </div>
    <div class="sidebar-footer"></div>
</aside>


@section('script')
    @parent
    <script>
        //    var total_noti = 1;
        //   alert(total_noti);
        if (total_noti > 0) {
            const audio = new Audio("{{ asset('assets/sound/notify.mp3') }}");
            // Check if the browser has permission to play the audio
            audio.play().then(() => {
                // Audio is playing
            }).catch(() => {
                // Audio cannot be played
            });
        }
    </script>
@endsection
