@extends('layouts.app')
@section('page_title', 'แก้ไขข้อมูลผู้ใช้งาน')
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
                                <li class="breadcrumb-item">
                                    <a href="{{ route('user.index') }}">ข้อมูลผู้ใช้งาน</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">แก้ไขข้อมูลผู้ใช้งาน</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card-header">
                        <h3>แก้ไขข้อมูลผู้ใช้งาน : {{ $user->name ?? '' }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            @if (isset($user->profile_image))
                                <div class="col-12 mb-4 text-center">
                                    <img src="{{ Helper::checkImageExists($user->profile_image) }}"
                                        class="rounded img-fluid object-cover" style="max-width: 200px;" />
                                </div>
                            @endif
                            @include('user.form')
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('user.index') }}" class="btn btn-dark">
                                    <i class="fa-solid fa-arrow-left me-1"></i>
                                    ย้อนกลับ
                                </a>
                                <button type="sumbit" class="btn btn-success ms-auto btn_submit_bill">
                                    <i class="fa-solid fa-floppy-disk me-1"></i>
                                    บันทึก
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
