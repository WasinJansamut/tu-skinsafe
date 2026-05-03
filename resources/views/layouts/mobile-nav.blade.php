@php
    $navItems = [['route' => 'home', 'icon' => 'fa-house', 'label' => 'หน้าหลัก'], ['route' => 'app.upload', 'icon' => 'fa-cloud-arrow-up', 'label' => 'ถ่าย/อัปภาพ'], ['route' => 'app.library', 'icon' => 'fa-regular fa-folder-open', 'label' => 'คลังภาพ'], ['route' => 'app.consent', 'icon' => 'fa-solid fa-users', 'label' => 'การแชร์'], ['route' => 'app.history', 'icon' => 'fa-regular fa-clock', 'label' => 'ประวัติ']];
@endphp

<nav class="bottom-nav" aria-label="เมนูด้านล่าง">
    <div class="bottom-nav-inner">
        @foreach ($navItems as $item)
            <a href="{{ route($item['route']) }}" class="bottom-nav-item {{ request()->routeIs($item['route']) ? 'is-active' : '' }}">
                <span class="bottom-nav-icon"><i class="fa-solid {{ $item['icon'] }}"></i></span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>
