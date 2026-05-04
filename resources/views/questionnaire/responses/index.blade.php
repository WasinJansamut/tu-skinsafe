@extends('layouts.app')
@section('page_title', 'ข้อมูลแบบสอบถามยืนยันความต้องการ')
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
                                    แบบสอบถามยืนยันความต้องการ
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">ข้อมูลแบบสอบถาม</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card-header">
                        <div class="mb-2">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                                แบบสอบถามยืนยันความต้องการ
                            </span>
                        </div>
                        <h3 class="mb-0">ข้อมูลแบบสอบถามยืนยันความต้องการ</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>วันที่ตอบ</th>
                                        <th>อายุ</th>
                                        <th>เพศ</th>
                                        <th>การศึกษา</th>
                                        <th>เคยใช้ telemedicine</th>
                                        <th>คะแนนเฉลี่ย</th>
                                        <th>ดูข้อมูล</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($responses as $response)
                                        <tr class="text-center">
                                            <td>{{ $response->id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($response->created_at)->format('d/m/Y H:i') }}</td>
                                            <td>{{ $response->age }}</td>
                                            <td>
                                                @if ($response->gender === 'male')
                                                    ชาย
                                                @elseif ($response->gender === 'female')
                                                    หญิง
                                                @else
                                                    อื่นๆ {{ $response->gender_other ? '(' . $response->gender_other . ')' : '' }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($response->education_level === 'below_bachelor')
                                                    ต่ำกว่าปริญญาตรี
                                                @elseif ($response->education_level === 'bachelor')
                                                    ปริญญาตรี
                                                @else
                                                    สูงกว่าปริญญาตรี
                                                @endif
                                            </td>
                                            <td>{{ $response->used_telemedicine ? 'เคย' : 'ไม่เคย' }}</td>
                                            <td>{{ number_format((float) $response->average_score, 2) }}</td>
                                            <td>
                                                <a href="{{ route('questionnaire.responses.show', $response->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fa-solid fa-eye me-1"></i>
                                                    ดูข้อมูล
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">ยังไม่มีข้อมูลแบบสอบถามยืนยันความต้องการ</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $responses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
