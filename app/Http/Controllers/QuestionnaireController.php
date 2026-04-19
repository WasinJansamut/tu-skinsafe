<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionnaireController extends Controller
{
    private function sections(): array
    {
        return [
            [
                'title' => 'หมวดที่ 1 ความต้องการด้านการบันทึกภาพโรคผิวหนัง',
                'subtitle' => 'Image Capture Requirements',
                'questions' => [
                    1 => 'ระบบควรอนุญาตให้ผู้ป่วยอัปโหลดภาพโรคผิวหนังเพื่อบันทึกข้อมูลสุขภาพ',
                    2 => 'ระบบควรมีเครื่องมือช่วยให้ผู้ป่วยถ่ายภาพโรคผิวหนังได้อย่างชัดเจนและเหมาะสม',
                    3 => 'ระบบควรมีตัวอย่างการถ่ายภาพเพื่อช่วยให้ผู้ป่วยถ่ายภาพตำแหน่งเดิมของโรคและสามารถเปรียบเทียบการเปลี่ยนแปลงได้',
                ],
            ],
            [
                'title' => 'หมวด 2 ความต้องการด้านการจัดการภาพโรคผิวหนัง',
                'subtitle' => 'Image Management Requirements',
                'questions' => [
                    4 => 'ระบบควรจัดเก็บภาพโรคผิวหนังพร้อมข้อมูลประกอบ เช่น วันที่และตำแหน่งของโรค',
                    5 => 'ผู้ป่วยควรสามารถแก้ไขข้อมูลของภาพที่อัปโหลดได้',
                    6 => 'ผู้ป่วยควรสามารถลบภาพโรคผิวหนังออกจากระบบได้',
                    7 => 'ผู้ป่วยควรสามารถดูภาพย้อนหลังเพื่อเปรียบเทียบการเปลี่ยนแปลงของโรคได้',
                ],
            ],
            [
                'title' => 'หมวด 3 ความต้องการด้านการให้ความยินยอมในการใช้ข้อมูล',
                'subtitle' => 'Consent Management Requirements',
                'questions' => [
                    8 => 'ระบบควรมีการขอความยินยอมก่อนการเก็บหรือใช้ข้อมูลภาพ',
                    9 => 'ระบบควรมีคำอธิบายเกี่ยวกับวัตถุประสงค์การใช้ข้อมูลก่อนที่ผู้ป่วยจะให้ความยินยอม',
                    10 => 'ผู้ป่วยควรสามารถถอนความยินยอมในการใช้ข้อมูลได้ทุกเวลา',
                ],
            ],
            [
                'title' => 'หมวด 4 ความต้องการด้านการควบคุมสิทธิ์การเข้าถึงข้อมูล',
                'subtitle' => 'Access Control Requirements',
                'questions' => [
                    11 => 'ผู้ป่วยควรสามารถกำหนดได้ว่าใครสามารถเข้าถึงภาพของตนได้',
                    12 => 'ผู้ป่วยควรสามารถควบคุมการแชร์ข้อมูลของตนได้ด้วยตนเอง',
                ],
            ],
            [
                'title' => 'หมวด 5 ความต้องการด้านความโปร่งใสในการเข้าถึงข้อมูล',
                'subtitle' => 'Data Transparency Requirements',
                'questions' => [
                    13 => 'ผู้ป่วยควรสามารถตรวจสอบได้ว่าใครเคยเข้าถึงข้อมูลภาพของตน',
                ],
            ],
            [
                'title' => 'หมวด 6 ความต้องการด้านการแบ่งปันข้อมูลทางการแพทย์',
                'subtitle' => 'Medical Data Sharing Requirements',
                'questions' => [
                    14 => 'ผู้ป่วยควรสามารถแชร์ภาพโรคผิวหนังให้แพทย์เพื่อช่วยในการวินิจฉัยได้',
                    15 => 'ผู้ป่วยควรสามารถเลือกแชร์ข้อมูลของตนเพื่อการวิจัยได้',
                ],
            ],
            [
                'title' => 'หมวด 7 ความต้องการด้านความเป็นส่วนตัวและความปลอดภัยของข้อมูล',
                'subtitle' => 'Privacy and Security Requirements',
                'questions' => [
                    16 => 'ระบบควรมีมาตรการปกปิดข้อมูลส่วนบุคคลของผู้ป่วย',
                    17 => 'ระบบควรมีมาตรการยืนยันตัวตนและรักษาความปลอดภัยของข้อมูล',
                ],
            ],
            [
                'title' => 'หมวด 8 ความต้องการด้านการแจ้งเตือนการใช้ข้อมูล',
                'subtitle' => 'Notification Requirements',
                'questions' => [
                    18 => 'ระบบควรแจ้งเตือนผู้ป่วยเมื่อข้อมูลภาพของตนถูกเข้าถึงหรือถูกแชร์',
                ],
            ],
            [
                'title' => 'หมวด 9 ความต้องการด้านการใช้ปัญญาประดิษฐ์ช่วยคัดกรองโรค',
                'subtitle' => 'AI-assisted Screening Requirements',
                'questions' => [
                    19 => 'ระบบควรมี AI เพื่อช่วยคัดกรองโรคผิวหนังเบื้องต้น',
                ],
            ],
            [
                'title' => 'หมวด 10 ความต้องการด้านความสะดวกในการใช้งานและการจัดการข้อมูล',
                'subtitle' => 'Usability and Data Management Requirements',
                'questions' => [
                    20 => 'ระบบควรใช้งานได้สะดวกผ่านสมาร์ทโฟนและมีหน้าจอแสดงข้อมูลภาพรวมของข้อมูลผู้ป่วย',
                ],
            ],
        ];
    }

    private function ensureAdmin(): void
    {
        $hasAdmin = User::where('role', 'admin')->exists();

        if ($hasAdmin && Auth::user()?->role !== 'admin') {
            abort(403, 'เฉพาะผู้ดูแลระบบเท่านั้น');
        }
    }

    public function index()
    {
        $sections = $this->sections();

        return view('questionnaire.index', compact('sections'));
    }

    public function store(Request $request)
    {
        $questionRules = [];
        for ($i = 1; $i <= 20; $i++) {
            $questionRules['q' . $i] = ['required', 'integer', 'between:1,5'];
        }

        $validated = $request->validate(array_merge([
            'age' => ['required', 'integer', 'between:1,120'],
            'gender' => ['required', 'in:male,female,other'],
            'gender_other' => ['nullable', 'string', 'max:255', 'required_if:gender,other'],
            'education_level' => ['required', 'in:below_bachelor,bachelor,above_bachelor'],
            'treatment_count' => ['required', 'in:1-2,3-5,more_than_5'],
            'used_telemedicine' => ['required', 'in:yes,no'],
            'main_concern' => ['nullable', 'string'],
            'additional_features' => ['nullable', 'string'],
            'other_suggestions' => ['nullable', 'string'],
        ], $questionRules), [
            'gender_other.required_if' => 'กรุณาระบุเพศ',
        ]);

        $payload = [
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'gender_other' => $validated['gender'] === 'other' ? $validated['gender_other'] : null,
            'education_level' => $validated['education_level'],
            'treatment_count' => $validated['treatment_count'],
            'used_telemedicine' => $validated['used_telemedicine'] === 'yes' ? 1 : 0,
            'main_concern' => $validated['main_concern'] ?? null,
            'additional_features' => $validated['additional_features'] ?? null,
            'other_suggestions' => $validated['other_suggestions'] ?? null,
            'respondent_ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        for ($i = 1; $i <= 20; $i++) {
            $payload['q' . $i] = (int) $validated['q' . $i];
        }

        DB::table('requirement_confirmation_questionnaires')->insert($payload);

        return redirect()
            ->route('questionnaire.index')
            ->with('success', 'บันทึกแบบสอบถามเรียบร้อยแล้ว ขอบคุณสำหรับคำตอบของท่าน');
    }

    public function responses()
    {
        $this->ensureAdmin();

        $responses = DB::table('requirement_confirmation_questionnaires')
            ->select('*')
            ->selectRaw('ROUND((q1 + q2 + q3 + q4 + q5 + q6 + q7 + q8 + q9 + q10 + q11 + q12 + q13 + q14 + q15 + q16 + q17 + q18 + q19 + q20) / 20, 2) as average_score')
            ->orderByDesc('id')
            ->paginate(20);

        return view('questionnaire.responses.index', compact('responses'));
    }

    public function showResponse($id)
    {
        $this->ensureAdmin();

        $response = DB::table('requirement_confirmation_questionnaires')->where('id', $id)->first();

        abort_unless($response, 404);

        $sections = $this->sections();

        return view('questionnaire.responses.show', compact('response', 'sections'));
    }

    public function summary()
    {
        $this->ensureAdmin();

        $sections = $this->sections();
        $responsesCount = DB::table('requirement_confirmation_questionnaires')->count();
        $summarySections = [];

        foreach ($sections as $section) {
            $questions = [];

            foreach ($section['questions'] as $questionNumber => $questionText) {
                $column = 'q' . $questionNumber;
                $row = DB::table('requirement_confirmation_questionnaires')
                    ->selectRaw("
                        ROUND(AVG({$column}), 2) as average_score,
                        SUM(CASE WHEN {$column} = 5 THEN 1 ELSE 0 END) as score_5,
                        SUM(CASE WHEN {$column} = 4 THEN 1 ELSE 0 END) as score_4,
                        SUM(CASE WHEN {$column} = 3 THEN 1 ELSE 0 END) as score_3,
                        SUM(CASE WHEN {$column} = 2 THEN 1 ELSE 0 END) as score_2,
                        SUM(CASE WHEN {$column} = 1 THEN 1 ELSE 0 END) as score_1
                    ")
                    ->first();

                $questions[] = [
                    'number' => $questionNumber,
                    'text' => $questionText,
                    'average_score' => $row->average_score ?? null,
                    'score_5' => (int) ($row->score_5 ?? 0),
                    'score_4' => (int) ($row->score_4 ?? 0),
                    'score_3' => (int) ($row->score_3 ?? 0),
                    'score_2' => (int) ($row->score_2 ?? 0),
                    'score_1' => (int) ($row->score_1 ?? 0),
                ];
            }

            $summarySections[] = [
                'title' => $section['title'],
                'subtitle' => $section['subtitle'],
                'questions' => $questions,
            ];
        }

        return view('questionnaire.responses.summary', compact('summarySections', 'responsesCount'));
    }
}
