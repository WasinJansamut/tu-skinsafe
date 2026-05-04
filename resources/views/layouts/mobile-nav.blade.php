@php
    $navItems = [['route' => 'home', 'icon' => 'fa-solid fa-house', 'label' => 'หน้าหลัก'], ['route' => 'app.upload', 'icon' => 'fa-solid fa-cloud-arrow-up', 'label' => 'ถ่าย/อัปภาพ'], ['route' => 'app.library', 'icon' => 'fa-regular fa-folder-open', 'label' => 'คลังภาพ'], ['route' => 'app.consent', 'icon' => 'fa-solid fa-users', 'label' => 'การแชร์'], ['route' => 'app.history', 'icon' => 'fa-regular fa-clock', 'label' => 'ประวัติ']];
@endphp

<style>
    .bottom-nav {
        position: fixed;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: min(430px, 100%);
        border-top: 1px solid rgba(17, 24, 39, 0.08);
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow: 0 -10px 28px rgba(17, 24, 39, 0.08);
        padding: 8px 10px 10px;
        z-index: 1030;
    }

    .bottom-nav-inner {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 4px;
    }

    .bottom-nav-item {
        appearance: none;
        border: 0;
        background: transparent;
        color: #8a8f98;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 6px 2px 2px;
        text-decoration: none;
        font-size: 0.72rem;
        font-weight: 600;
        line-height: 1.1;
    }

    .bottom-nav-item i {
        font-size: 1.15rem;
    }

    .bottom-nav-item.is-active {
        color: #4552d0;
    }

    .bottom-nav-item.is-active .bottom-nav-icon {
        background: rgba(69, 82, 208, 0.12);
        color: #4552d0;
    }

    .bottom-nav-icon {
        width: 36px;
        height: 36px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>

<nav class="bottom-nav" aria-label="เมนูด้านล่าง">
    <div class="bottom-nav-inner">
        @foreach ($navItems as $item)
            <a href="{{ route($item['route']) }}" class="bottom-nav-item {{ request()->routeIs($item['route']) ? 'is-active' : '' }}">
                <span class="bottom-nav-icon"><i class="{{ $item['icon'] }}"></i></span>
                <span>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>
