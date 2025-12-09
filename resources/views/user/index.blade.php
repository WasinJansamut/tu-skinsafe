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
                            <h3 class="mb-0">ข้อมูลผู้ใช้งาน</h3>
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
                                        <th>รหัสพนักงาน ชื่อ-นามสกุล</th>
                                        <th>สาขา</th>
                                        <th>แผนก</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
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
                                                        alert-msg='ผู้ใช้งาน [{{ $user->employee_id ?? '' }}] {{ $user->name ?? '' }}'
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="ลบ">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="text-start">
                                                <div class="d-flex align-items-center">
                                                    @if (!empty($user->profile_image))
                                                        <a id="lightbox[{{ $user->id }}]" href="{{ Helper::checkImageExists($user->profile_image) }}"
                                                            data-lightbox="user_image_{{ $user->id }}"
                                                            data-title="[{{ $user->employee_id ?? '' }}] {{ $user->name ?? '' }}">
                                                            <img src="{{ Helper::checkImageExists($user->profile_image) }}"
                                                                class="rounded img-fluid avatar-65 me-2" style="max-width: 65px; max-height: 65px;" loading="lazy" />
                                                        </a>
                                                    @endif
                                                    <div class="media-support-info">
                                                        <p class="mb-0">
                                                            <i class="fa-regular fa-address-book"></i>
                                                            {{ $user->employee_id ?? '' }}
                                                        </p>
                                                        <h5 class="iq-sub-label">{{ $user->name ?? '' }}</h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <i class="fa-solid fa-building me-1"></i>
                                                [{{ $user->_branch->code ?? '' }}]
                                                {{ $user->_branch->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $user->_department->name_th ?? '' }}<br>
                                                {{ $user->_level->name ?? '' }}
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
