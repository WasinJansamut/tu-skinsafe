@if (Session::has('primary'))
    <div class="alert alert-left alert-primary alert-dismissible fade show mb-3" role="alert">
        <div class="fs-4">
            <i class="fa-solid fa-circle-check me-1 fs-3"></i>
            <span>สำเร็จ</span>
        </div>
        <div>{!! Session::get('primary') !!}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-left alert-success alert-dismissible fade show mb-3" role="alert">
        <div class="fs-4">
            <i class="fa-solid fa-circle-check me-1 fs-3"></i>
            <span>สำเร็จ</span>
        </div>
        <div>{!! Session::get('success') !!}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('warning'))
    <div class="alert alert-left alert-warning alert-dismissible fade show mb-3" role="alert">
        <div class="fs-4">
            <i class="fa-solid fa-triangle-exclamation me-1 fs-3"></i>
            <span>คำเตือน</span>
        </div>
        <div>{!! Session::get('warning') !!}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('info'))
    <div class="alert alert-left alert-info alert-dismissible fade show mb-3" role="alert">
        <div class="fs-4">
            <i class="fa-solid fa-circle-info me-1 fs-3"></i>
            <span>รายละเอียด</span>
        </div>
        <div>{!! Session::get('info') !!}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('danger'))
    <div class="alert alert-left alert-danger alert-dismissible fade show mb-3" role="alert">
        <div class="fs-4">
            <i class="fa-solid fa-circle-radiation me-1 fs-3"></i>
            <span>เกิดข้อผิดพลาด</span>
        </div>
        <div>{!! Session::get('danger') !!}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3">
        <div class="fs-4">
            <i class="fa-solid fa-circle-radiation me-1 fs-3"></i>
            <span>เกิดข้อผิดพลาด</span>
        </div>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


@if (Session::has('sound'))
    <script>
        const audio = new Audio('{{ asset(session('sound')) }}');

        // Check if the browser has permission to play the audio
        audio.play().then(() => {
            // Audio is playing
        }).catch(() => {
            // Audio cannot be played
        });
    </script>
@endif
