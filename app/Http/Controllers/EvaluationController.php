<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EvaluationController extends Controller
{
    private function ensureAdmin(): void
    {
        $hasAdmin = User::where('role', 'admin')->exists();

        if ($hasAdmin && Auth::user()?->role !== 'admin') {
            abort(403, 'เฉพาะผู้ดูแลระบบเท่านั้น');
        }
    }

    private function evaluationItems(): array
    {
        return [
            1 => 'หน้าหลักของระบบช่วยให้เข้าใจภาพรวมของข้อมูลได้ชัดเจน',
            2 => 'ฟังก์ชันถ่ายภาพหรืออัปโหลดภาพใช้งานได้ง่ายและเหมาะสม',
            3 => 'การกรอกข้อมูลประกอบภาพ เช่น อาการ ตำแหน่ง หรือหมายเหตุ มีความชัดเจน',
            4 => 'คลังภาพของฉันช่วยให้ตรวจสอบภาพย้อนหลังได้สะดวก',
            5 => 'การดู แก้ไข หรือลบข้อมูลภาพสามารถเข้าใจได้ง่าย',
            6 => 'หน้าการยินยอมและการแชร์ข้อมูลแสดงวัตถุประสงค์การใช้ข้อมูลได้ชัดเจน',
            7 => 'ระบบช่วยให้รู้สึกว่าสามารถควบคุมการให้หรือถอนความยินยอมได้',
            8 => 'หน้าสิทธิ์การเข้าถึงข้อมูลช่วยให้เข้าใจว่าใครสามารถเข้าถึงข้อมูลของตนได้',
            9 => 'การกำหนดสิทธิ์แบบดูข้อมูลเท่านั้นมีความเหมาะสมกับข้อมูลภาพทางการแพทย์',
            10 => 'หน้าประวัติการเข้าถึงและการแจ้งเตือนช่วยให้ตรวจสอบการใช้ข้อมูลย้อนหลังได้',
            11 => 'ระบบทำให้เกิดความเชื่อมั่นต่อการคุ้มครองข้อมูลส่วนบุคคล',
            12 => 'ระบบมีรูปแบบหน้าจอที่ใช้งานง่าย เหมาะกับการใช้งานผ่านสมาร์ทโฟน',
            13 => 'ฟังก์ชันหลักของระบบมีความเหมาะสมกับการจัดเก็บและส่งต่อภาพถ่ายโรคผิวหนัง',
            14 => 'โดยรวมแล้วระบบต้นแบบมีประโยชน์ต่อการติดตามหรือจัดการข้อมูลภาพโรคผิวหนัง',
            15 => 'โดยรวมแล้วท่านพึงพอใจต่อระบบต้นแบบ',
        ];
    }

    private function decodeJsonField(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        $decoded = json_decode((string) $value, true);

        return is_array($decoded) ? $decoded : [];
    }

    private function genderLabel(?string $gender, ?string $other = null): string
    {
        return match ($gender) {
            'male' => 'ชาย',
            'female' => 'หญิง',
            'other' => 'อื่นๆ' . ($other ? ' (' . $other . ')' : ''),
            default => '-',
        };
    }

    private function educationLabel(?string $education): string
    {
        return match ($education) {
            'below_bachelor' => 'ต่ำกว่าปริญญาตรี',
            'bachelor' => 'ปริญญาตรี',
            'higher' => 'สูงกว่าปริญญาตรี',
            default => '-',
        };
    }

    private function treatmentLabel(?string $treatmentCount): string
    {
        return match ($treatmentCount) {
            '1_2' => '1–2 ครั้ง',
            '3_5' => '3–5 ครั้ง',
            'more_5' => 'มากกว่า 5 ครั้ง',
            default => '-',
        };
    }

    private function telemedicineLabel(?string $value): string
    {
        return match ($value) {
            'yes' => 'เคย',
            'no' => 'ไม่เคย',
            default => '-',
        };
    }

    private function formatSubmittedAt(object $row): string
    {
        $raw = $row->submitted_at ?? $row->created_at ?? null;

        return $raw ? \Carbon\Carbon::parse($raw)->format('d/m/Y H:i') : '-';
    }

    public function responses()
    {
        $this->ensureAdmin();

        if (! Schema::hasTable('system_evaluation_responses')) {
            abort(500, 'ยังไม่ได้สร้างตาราง system_evaluation_responses');
        }

        $responses = DB::table('system_evaluation_responses')
            ->orderByDesc('id')
            ->paginate(20);

        $responses->getCollection()->transform(function ($row) {
            $general = $this->decodeJsonField($row->general_answers_json ?? null);
            $scale = $this->decodeJsonField($row->scale_answers_json ?? null);

            $scores = [];
            foreach ($scale as $score) {
                $scores[] = (int) $score;
            }

            $row->submitted_at_text = $this->formatSubmittedAt($row);
            $row->gender_label = $this->genderLabel(
                $general['gender'] ?? null,
                $general['gender_other'] ?? null
            );
            $row->age = $general['age'] ?? null;
            $row->education_label = $this->educationLabel($general['education'] ?? null);
            $row->treatment_label = $this->treatmentLabel($general['treatment_count'] ?? null);
            $row->telemedicine_label = $this->telemedicineLabel($general['telemedicine_experience'] ?? null);
            $row->average_score = count($scores) > 0 ? round(array_sum($scores) / count($scores), 2) : null;

            return $row;
        });

        $responsesCount = DB::table('system_evaluation_responses')->count();

        return view('evaluation.responses.index', compact('responses', 'responsesCount'));
    }

    public function showResponse($id)
    {
        $this->ensureAdmin();

        if (! Schema::hasTable('system_evaluation_responses')) {
            abort(500, 'ยังไม่ได้สร้างตาราง system_evaluation_responses');
        }

        $response = DB::table('system_evaluation_responses')->where('id', $id)->first();
        abort_unless($response, 404);

        $general = $this->decodeJsonField($response->general_answers_json ?? null);
        $scale = $this->decodeJsonField($response->scale_answers_json ?? null);
        $open = $this->decodeJsonField($response->open_answers_json ?? null);
        $items = $this->evaluationItems();

        $response->submitted_at_text = $this->formatSubmittedAt($response);
        $response->gender_label = $this->genderLabel(
            $general['gender'] ?? null,
            $general['gender_other'] ?? null
        );
        $response->age = $general['age'] ?? null;
        $response->education_label = $this->educationLabel($general['education'] ?? null);
        $response->treatment_label = $this->treatmentLabel($general['treatment_count'] ?? null);
        $response->telemedicine_label = $this->telemedicineLabel($general['telemedicine_experience'] ?? null);

        return view('evaluation.responses.show', compact('response', 'general', 'scale', 'open', 'items'));
    }

    public function summary()
    {
        $this->ensureAdmin();

        if (! Schema::hasTable('system_evaluation_responses')) {
            abort(500, 'ยังไม่ได้สร้างตาราง system_evaluation_responses');
        }

        $items = $this->evaluationItems();
        $responses = DB::table('system_evaluation_responses')
            ->select('scale_answers_json')
            ->get();

        $responsesCount = $responses->count();
        $questionStats = [];

        foreach ($items as $number => $text) {
            $questionStats[$number] = [
                'number' => $number,
                'text' => $text,
                'average_score' => null,
                'score_5' => 0,
                'score_4' => 0,
                'score_3' => 0,
                'score_2' => 0,
                'score_1' => 0,
            ];
        }

        $overallSum = 0;
        $overallCount = 0;

        foreach ($responses as $row) {
            $answers = $this->decodeJsonField($row->scale_answers_json ?? null);

            foreach ($items as $number => $_text) {
                $score = $answers[$number] ?? $answers[(string) $number] ?? null;
                $score = is_numeric($score) ? (int) $score : null;

                if (! $score || $score < 1 || $score > 5) {
                    continue;
                }

                $questionStats[$number]['score_' . $score]++;
                $questionStats[$number]['average_score'] = ($questionStats[$number]['average_score'] ?? 0) + $score;
                $overallSum += $score;
                $overallCount++;
            }
        }

        foreach ($questionStats as $number => $stats) {
            $count = array_sum([
                $stats['score_5'],
                $stats['score_4'],
                $stats['score_3'],
                $stats['score_2'],
                $stats['score_1'],
            ]);

            $questionStats[$number]['average_score'] = $count > 0
                ? round(($stats['average_score'] ?? 0) / $count, 2)
                : null;
        }

        $overallAverage = $overallCount > 0 ? round($overallSum / $overallCount, 2) : null;

        return view('evaluation.responses.summary', compact('questionStats', 'responsesCount', 'overallAverage'));
    }
}
