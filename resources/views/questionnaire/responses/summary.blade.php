@extends('layouts.app')
@section('page_title', 'ผลรวมแบบสอบถาม')
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
                                <li class="breadcrumb-item active" aria-current="page">ผลรวมแบบสอบถาม</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h3 class="mb-0">ผลรวมแบบสอบถาม</h3>
                            <div class="text-muted">จำนวนผู้ตอบทั้งหมด {{ number_format($responsesCount) }} ราย</div>
                        </div>
                        <a href="{{ route('questionnaire.responses') }}" class="btn btn-outline-primary">
                            <i class="fa-solid fa-table-list me-1"></i>
                            ดูราย Record
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-4">
                            @foreach ($summarySections as $section)
                                <div class="border rounded p-3 bg-white">
                                    <div class="mb-3">
                                        <div class="fw-bold">{{ $section['title'] }}</div>
                                        <div class="small text-muted">{{ $section['subtitle'] }}</div>
                                    </div>

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
                                                @foreach ($section['questions'] as $question)
                                                    <tr>
                                                        <td class="text-start">
                                                            {{ $question['number'] }}. {{ $question['text'] }}
                                                        </td>
                                                        <td class="text-center fw-semibold">
                                                            {{ $question['average_score'] !== null ? number_format((float) $question['average_score'], 2) : '-' }}
                                                        </td>
                                                        <td class="text-center">{{ $question['score_5'] }}</td>
                                                        <td class="text-center">{{ $question['score_4'] }}</td>
                                                        <td class="text-center">{{ $question['score_3'] }}</td>
                                                        <td class="text-center">{{ $question['score_2'] }}</td>
                                                        <td class="text-center">{{ $question['score_1'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
