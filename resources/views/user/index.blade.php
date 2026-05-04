@extends('layouts.app')
@section('page_title', 'ข้อมูลผู้ใช้งาน')
@section('content')
    <div class="conatiner-fluid content-inner">
        @include('layouts.alert')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-4 pt-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">หน้าหลัก</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">ข้อมูลผู้ใช้งาน</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="card-title mb-0">
                            <h3 class="mb-0">User Manage</h3>
                        </div>
                        <div class="card-action mt-2 mt-sm-0">
                            <a href="{{ route('user.create') }}" class="btn btn-success">
                                <i class="fa fa-plus me-1"></i>
                                เพิ่มข้อมูล
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered w-100" id="data-table" data-toggle="data-table"
                                data-page-length="100">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>นามสมมุติ</th>
                                        <th>ชื่อผู้ใช้งาน</th>
                                        <th>ช่องทางการโอนเงิน</th>
                                        <th>สถานะการโอน</th>
                                        <th>ภารกิจ</th>
                                        <th>ประเภทผู้ใช้งาน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        @php
                                            $transferStatus = trim((string) ($user->status_payto_research_participant ?? ''));
                                            $paymentChannel = trim((string) ($user->compensation_channel ?? ''));

                                            if ($paymentChannel === 'ไม่รับค่าตอบแทน' || $transferStatus === 'ไม่ขอรับค่าตอบแทน') {
                                                $paymentBadgeClass = 'bg-success';
                                                $paymentBadgeLabel = 'ไม่ขอรับค่าตอบแทน';
                                            } elseif ($transferStatus === 'ชำระแล้ว') {
                                                $paymentBadgeClass = 'bg-success';
                                                $paymentBadgeLabel = 'ชำระแล้ว';
                                            } else {
                                                $paymentBadgeClass = 'bg-danger';
                                                $paymentBadgeLabel = $transferStatus !== '' ? $transferStatus : 'ยังไม่ชำระ';
                                            }
                                        @endphp
                                        <tr class="text-center">
                                            <td>
                                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                    <a href="{{ route('user.edit', $user->id) }}"
                                                        class="btn btn-icon btn-warning" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="แก้ไข">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <form action="{{ route('user.soft_delete', $user->id) }}" method="post" class="m-0">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-icon btn-danger btn_delete"
                                                            alert-msg='ผู้ใช้งาน {{ $user->name ?? '' }}'
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="ลบ">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                    @if (($user->role ?? null) === 'research_participant')
                                                        <form action="{{ route('user.reset_participant_data', $user->id) }}" method="post" class="m-0 js-reset-participant-form">
                                                            @csrf
                                                            <button type="button"
                                                                class="btn btn-icon btn-outline-danger js-reset-participant"
                                                                data-user-name="{{ $user->name ?? 'ผู้เข้าร่วมวิจัย' }}"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="รีเซ็ตข้อมูลผู้เข้าร่วมวิจัย">
                                                                <i class="fa-solid fa-arrows-rotate"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-start">
                                                <div class="fw-semibold">{{ $user->name ?? '' }}</div>
                                            </td>
                                            <td>
                                                {{ $user->username ?? '' }}
                                            </td>
                                            <td class="text-start">
                                                {{ $paymentChannel !== '' ? $paymentChannel : '-' }}
                                            </td>
                                            <td>
                                                <span class="badge {{ $paymentBadgeClass }}">
                                                    {{ $paymentBadgeLabel }}
                                                </span>
                                            </td>
                                            <td>
                                                @if (($user->role ?? null) === 'research_participant')
                                                    <span class="badge {{ $user->task_completed_class ?? 'bg-secondary' }}">
                                                        {{ $user->task_completed_label ?? '-'}}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-success' }}">
                                                    {{ $user->role === 'admin' ? 'Admin' : 'ผู้เข้าร่วมวิจัย' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.querySelectorAll('.js-reset-participant').forEach((button) => {
            button.addEventListener('click', async function() {
                const form = this.closest('form');
                const userName = this.dataset.userName || 'ผู้เข้าร่วมวิจัย';
                const result = await Swal.fire({
                    icon: 'warning',
                    title: 'รีเซ็ตข้อมูลผู้เข้าร่วมวิจัย',
                    html: `ต้องการล้างข้อมูลของ <strong>${userName}</strong> หรือไม่<br><span class="text-danger">ระบบจะลบข้อมูลการใช้งานทั้งหมดของผู้เข้าร่วมคนนั้น แต่ไม่ลบบัญชีผู้ใช้งาน</span>`,
                    showCancelButton: true,
                    confirmButtonText: 'รีเซ็ต',
                    cancelButtonText: 'ยกเลิก',
                    confirmButtonColor: '#b42318',
                });

                if (result.isConfirmed && form) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
