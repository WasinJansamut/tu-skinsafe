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
                                                <form action="{{ route('user.soft_delete', $user->id) }}" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <a href="{{ route('user.edit', $user->id) }}"
                                                        class="btn btn-icon btn-warning" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="แก้ไข">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <button class="btn btn-icon btn-danger btn_delete"
                                                        alert-msg='ผู้ใช้งาน {{ $user->name ?? '' }}'
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="ลบ">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
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
