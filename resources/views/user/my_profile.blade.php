@extends('layouts.app')
@section('page_title', 'ข้อมูลส่วนตัว')
@section('content')
    <div class="conatiner-fluid content-inner">
        @include('layouts.alert')

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="px-4 pt-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">หน้าหลัก</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">ข้อมูลส่วนตัว</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card-header">
                        <h3 class="mb-0">ข้อมูลส่วนตัว</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            แก้ไขได้เฉพาะรหัสผ่าน ส่วนชื่อผู้ใช้งานและประเภทผู้ใช้งานกำหนดโดยผู้ดูแลระบบ
                        </div>

                        <form action="{{ route('user.my_profile_update') }}" method="post">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="name">ชื่อ-นามสกุล</label>
                                    <input type="text" id="name" class="form-control" value="{{ $user->name ?? '' }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="username">ชื่อผู้ใช้งาน</label>
                                    <input type="text" id="username" class="form-control" value="{{ $user->username ?? '' }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="email">อีเมล</label>
                                    <input type="email" id="email" class="form-control" value="{{ $user->email ?? '' }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="role_display">ประเภทผู้ใช้งาน</label>
                                    <input type="text" id="role_display" class="form-control"
                                        value="{{ ($user->role ?? '') === 'admin' ? 'Admin' : 'ผู้เข้าร่วมวิจัย' }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="password">รหัสผ่านใหม่</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="password_confirmation">ยืนยันรหัสผ่านใหม่</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror" autocomplete="new-password">
                                    @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('home') }}" class="btn btn-dark">
                                    <i class="fa-solid fa-house me-1"></i>
                                    หน้าหลัก
                                </a>
                                <button type="submit" class="btn btn-success">
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
