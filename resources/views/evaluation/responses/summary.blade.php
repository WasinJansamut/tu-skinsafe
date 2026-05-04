@extends('layouts.app')
@section('page_title', 'ผลรวมแบบประเมิน')

@section('content')
    <div class="conatiner-fluid content-inner">
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
                                <li class="breadcrumb-item active" aria-current="page">ผลรวมแบบประเมิน</li>
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
                            <h3 class="mb-0">ผลรวมแบบประเมิน</h3>
                            <div class="text-muted">จำนวนผู้ตอบทั้งหมด {{ number_format($responsesCount) }} ราย</div>
                            <div class="text-muted">คะแนนเฉลี่ยรวม {{ $overallAverage !== null ? number_format((float) $overallAverage, 2) : '-' }}</div>
                        </div>
                        <a href="{{ route('evaluation.responses') }}" class="btn btn-outline-success">
                            <i class="fa-solid fa-table-list me-1"></i>
                            ดูคำตอบแบบประเมิน
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="text-center">
                                    <tr>
                                        <th class="text-start">รายการประเมิน</th>
                                        <th>ค่าเฉลี่ย</th>
                                        <th class="text-success">5</th>
                                        <th style="color:#5abf69;">4</th>
                                        <th style="color:#b58100;">3</th>
                                        <th style="color:#fd7e14;">2</th>
                                        <th class="text-danger">1</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($questionStats as $stat)
                                        <tr>
                                            <td class="text-start">{{ $stat['number'] }}. {{ $stat['text'] }}</td>
                                            <td class="text-center fw-semibold">
                                                {{ $stat['average_score'] !== null ? number_format((float) $stat['average_score'], 2) : '-' }}
                                            </td>
                                            <td class="text-center">{{ $stat['score_5'] }}</td>
                                            <td class="text-center">{{ $stat['score_4'] }}</td>
                                            <td class="text-center">{{ $stat['score_3'] }}</td>
                                            <td class="text-center">{{ $stat['score_2'] }}</td>
                                            <td class="text-center">{{ $stat['score_1'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">ยังไม่มีข้อมูลแบบประเมิน</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
