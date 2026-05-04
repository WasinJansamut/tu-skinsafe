@extends('layouts.app')
@section('page_title', 'คำตอบแบบประเมิน')

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
                                <li class="breadcrumb-item">แบบประเมินผลการใช้งานระบบต้นแบบ</li>
                                <li class="breadcrumb-item active" aria-current="page">คำตอบแบบประเมิน</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <div class="mb-2">
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                    แบบประเมินผลการใช้งานระบบต้นแบบ
                                </span>
                            </div>
                            <h3 class="mb-0">คำตอบแบบประเมิน</h3>
                            <div class="text-muted">จำนวนผู้ตอบทั้งหมด {{ number_format($responsesCount) }} ราย</div>
                        </div>
                        <a href="{{ route('evaluation.summary') }}" class="btn btn-outline-success">
                            <i class="fa-solid fa-chart-simple me-1"></i>
                            ดูผลรวมแบบประเมิน
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered w-100 align-middle">
                                <thead>
                                    <tr class="text-center">
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
                                            <td>{{ $response->submitted_at_text }}</td>
                                            <td>{{ $response->age ?? '-' }}</td>
                                            <td>{{ $response->gender_label ?? '-' }}</td>
                                            <td>{{ $response->education_label ?? '-' }}</td>
                                            <td>{{ $response->telemedicine_label ?? '-' }}</td>
                                            <td>{{ $response->average_score !== null ? number_format((float) $response->average_score, 2) : '-' }}</td>
                                            <td>
                                                <a href="{{ route('evaluation.responses.show', $response->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fa-solid fa-eye me-1"></i>
                                                    ดูข้อมูล
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">ยังไม่มีข้อมูลแบบประเมิน</td>
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
