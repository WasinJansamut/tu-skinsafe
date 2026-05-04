<?php

namespace App\Http\Controllers;

use App\Models\UserTaskCompletion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class MobileMenuController extends Controller
{
    private const SYSTEM_OVERVIEW_TASK_KEY = 'system_overview';
    private const SKIN_IMAGE_UPLOAD_TASK_KEY = 'skin_image_upload';
    private const LIBRARY_DETAIL_TASK_KEY = 'library_detail';
    private const CONSENT_PAGE_TASK_KEY = 'consent_page';
    private const ACCESS_PAGE_TASK_KEY = 'access_page';
    private const HISTORY_PAGE_TASK_KEY = 'history_page';
    private const EVALUATION_FORM_TASK_KEY = 'evaluation_form';

    private function page(array $data)
    {
        return view('mobile.page', $data);
    }

    private function isTaskCompleted(int $userId, string $taskKey): bool
    {
        return UserTaskCompletion::query()
            ->where('user_id', $userId)
            ->where('task_key', $taskKey)
            ->whereNotNull('completed_at')
            ->exists();
    }

    private function recordTaskCompletion(int $userId, string $taskKey): void
    {
        if (! Schema::hasTable('user_task_completions')) {
            return;
        }

        UserTaskCompletion::updateOrCreate(
            [
                'user_id' => $userId,
                'task_key' => $taskKey,
            ],
            [
                'completed_at' => now(),
            ]
        );
    }

    private function writeLog(?int $userId, string $actionKey, string $actionLabel, string $pagePath, array $details = []): void
    {
        if (! Schema::hasTable('system_logs')) {
            return;
        }

        DB::table('system_logs')->insert([
            'user_id' => $userId,
            'action_key' => $actionKey,
            'action_label' => $actionLabel,
            'page_path' => $pagePath,
            'details' => ! empty($details) ? json_encode($details, JSON_UNESCAPED_UNICODE) : null,
            'created_at' => now(),
        ]);
    }

    public function upload()
    {
        $user = auth()->user();
        $uploadCompleted = $this->isTaskCompleted($user->id, self::SKIN_IMAGE_UPLOAD_TASK_KEY);

        $this->writeLog($user->id, 'view_upload_page', 'เปิดหน้าถ่าย/อัปโหลดภาพ', '/app/upload');

        return view('mobile.upload', [
            'page_title' => 'ถ่าย/อัปโหลดภาพ',
            'page_subtitle' => 'ถ่ายภาพหรืออัปโหลดภาพถ่ายผิวหนังเข้าสู่ระบบต้นแบบ',
            'upload_completed' => $uploadCompleted,
        ]);
    }

    public function library()
    {
        $user = auth()->user();
        $records = collect();

        if (Schema::hasTable('skin_image_records')) {
            $records = DB::table('skin_image_records')
                ->where('user_id', $user->id)
                ->orderByDesc('id')
                ->get()
                ->map(function ($record) {
                    $paths = json_decode($record->image_paths ?? '[]', true) ?: [];

                    $record->thumbnail_url = ! empty($record->primary_image_path)
                        ? Storage::url($record->primary_image_path)
                        : (! empty($paths[0]) ? Storage::url($paths[0]) : null);
                    $record->image_total = (int) ($record->image_count ?? count($paths));
                    $record->created_at_text = ! empty($record->created_at)
                        ? \Illuminate\Support\Carbon::parse($record->created_at)->addYears(543)->format('d/m/y H:i')
                        : '-';
                    $record->paths = $paths;

                    return $record;
                });
        }

        $this->writeLog($user->id, 'view_library_page', 'เปิดหน้าคลังภาพของฉัน', '/app/library');

        return view('mobile.library', [
            'page_title' => 'คลังภาพของฉัน',
            'records' => $records,
        ]);
    }

    public function libraryShow(int $id)
    {
        $user = auth()->user();

        if (! Schema::hasTable('skin_image_records')) {
            abort(404);
        }

        $record = DB::table('skin_image_records')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (! $record) {
            abort(404);
        }

        $paths = json_decode($record->image_paths ?? '[]', true) ?: [];
        $record->paths = $paths;
        $record->thumbnail_url = ! empty($record->primary_image_path)
            ? Storage::url($record->primary_image_path)
            : (! empty($paths[0]) ? Storage::url($paths[0]) : null);
        $record->image_total = (int) ($record->image_count ?? count($paths));
        $record->created_at_text = ! empty($record->created_at)
            ? \Illuminate\Support\Carbon::parse($record->created_at)->addYears(543)->format('d/m/y H:i')
            : '-';
        $record->updated_at_text = ! empty($record->updated_at)
            ? \Illuminate\Support\Carbon::parse($record->updated_at)->addYears(543)->format('d/m/y H:i')
            : '-';

        $this->writeLog($user->id, 'view_skin_image_detail', 'เปิดดูรายละเอียดรายการภาพผิวหนัง', '/app/library/' . $record->id, [
            'record_id' => $record->id,
        ]);
        $this->recordTaskCompletion($user->id, self::LIBRARY_DETAIL_TASK_KEY);

        return view('mobile.library_show', [
            'page_title' => 'รายละเอียดรายการภาพ',
            'record' => $record,
        ]);
    }

    public function consent()
    {
        $user = auth()->user();
        $this->writeLog($user->id, 'view_consent_page', 'เปิดหน้าการยินยอมและการแชร์ข้อมูล', '/app/consent');
        $this->recordTaskCompletion($user->id, self::CONSENT_PAGE_TASK_KEY);

        return $this->page([
            'page_title' => 'การยินยอมและการแชร์ข้อมูล',
            'page_icon' => 'fa-user-group',
            'page_subtitle' => 'จัดการความยินยอมและผู้ที่เข้าถึงข้อมูลได้',
            'hero_title' => 'การยินยอมและการแชร์ข้อมูล',
            'hero_text' => 'ผู้เข้าร่วมสามารถเปิดหรือปิดการแชร์ข้อมูลตามเงื่อนไขของโครงการ',
            'primary_label' => 'จัดการการยินยอม',
            'items' => [
                ['title' => 'สถานะความยินยอม', 'meta' => 'อนุญาตให้ใช้ข้อมูลเพื่อการวิจัย'],
                ['title' => 'การแชร์ข้อมูล', 'meta' => 'เลือกผู้รับข้อมูลได้เป็นรายคน'],
                ['title' => 'ประวัติการเปลี่ยนแปลง', 'meta' => 'ตรวจสอบย้อนหลังได้ทุกครั้ง'],
            ],
        ]);
    }

    public function access()
    {
        $user = auth()->user();
        $this->writeLog($user->id, 'view_access_page', 'เปิดหน้าสิทธิ์การเข้าถึงข้อมูล', '/app/access');
        $this->recordTaskCompletion($user->id, self::ACCESS_PAGE_TASK_KEY);

        return $this->page([
            'page_title' => 'สิทธิ์การเข้าถึงข้อมูล',
            'page_icon' => 'fa-lock',
            'page_subtitle' => 'ควบคุมสิทธิ์การเปิดดูและใช้งานข้อมูล',
            'hero_title' => 'สิทธิ์การเข้าถึงข้อมูล',
            'hero_text' => 'กำหนดผู้มีสิทธิ์เข้าถึงข้อมูลและระดับการใช้งานของแต่ละคน',
            'primary_label' => 'ตั้งค่าสิทธิ์',
            'items' => [
                ['title' => 'สิทธิ์พื้นฐาน', 'meta' => 'เจ้าของข้อมูลและทีมวิจัยหลัก'],
                ['title' => 'สิทธิ์เพิ่มเติม', 'meta' => 'เพิ่มผู้ชมข้อมูลแบบเฉพาะกิจได้'],
                ['title' => 'ตรวจสอบสิทธิ์', 'meta' => 'ทบทวนสิทธิ์ทั้งหมดก่อนเผยแพร่'],
            ],
        ]);
    }

    public function history()
    {
        $user = auth()->user();
        $this->writeLog($user->id, 'view_history_page', 'เปิดหน้าประวัติการเข้าถึงและการแจ้งเตือน', '/app/history');
        $this->recordTaskCompletion($user->id, self::HISTORY_PAGE_TASK_KEY);

        return $this->page([
            'page_title' => 'ประวัติการเข้าถึงและการแจ้งเตือน',
            'page_icon' => 'fa-clock',
            'page_subtitle' => 'ติดตามเหตุการณ์ล่าสุดและสถานะระบบ',
            'hero_title' => 'ประวัติการเข้าถึงและการแจ้งเตือน',
            'hero_text' => 'แสดงกิจกรรมล่าสุดที่เกี่ยวข้องกับข้อมูลของคุณ',
            'primary_label' => 'ดูประวัติทั้งหมด',
            'items' => [
                ['title' => 'แพทย์เข้าดูข้อมูล', 'meta' => '10 นาทีที่แล้ว'],
                ['title' => 'มีการขอแชร์ข้อมูล', 'meta' => '1 ชั่วโมงที่แล้ว'],
                ['title' => 'การยืนยันจะหมดอายุ', 'meta' => '2 ชั่วโมงที่แล้ว'],
            ],
        ]);
    }

    public function evaluation()
    {
        $user = auth()->user();
        $ready = $this->isTaskCompleted($user->id, self::SYSTEM_OVERVIEW_TASK_KEY)
            && $this->isTaskCompleted($user->id, self::SKIN_IMAGE_UPLOAD_TASK_KEY)
            && $this->isTaskCompleted($user->id, self::LIBRARY_DETAIL_TASK_KEY)
            && $this->isTaskCompleted($user->id, self::CONSENT_PAGE_TASK_KEY)
            && $this->isTaskCompleted($user->id, self::ACCESS_PAGE_TASK_KEY)
            && $this->isTaskCompleted($user->id, self::HISTORY_PAGE_TASK_KEY);

        $completed = $this->isTaskCompleted($user->id, self::EVALUATION_FORM_TASK_KEY);

        $this->writeLog($user->id, 'view_evaluation_page', 'เปิดหน้าแบบประเมินผลการใช้งานระบบต้นแบบ', '/app/evaluation');

        return view('mobile.evaluation', [
            'page_title' => 'แบบประเมินผลการใช้งานระบบต้นแบบ',
            'ready' => $ready,
            'completed' => $completed,
        ]);
    }

    public function submitEvaluation(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'gender' => ['required', 'in:male,female,other'],
            'gender_other' => ['nullable', 'string', 'max:100'],
            'education' => ['required', 'in:below_bachelor,bachelor,higher'],
            'treatment_count' => ['required', 'in:1_2,3_5,more_5'],
            'telemedicine_experience' => ['required', 'in:yes,no'],
            'scale_answers' => ['required', 'array', 'size:15'],
            'scale_answers.*' => ['required', 'integer', 'between:1,5'],
            'section3_1' => ['nullable', 'string', 'max:2000'],
            'section3_2' => ['nullable', 'string', 'max:2000'],
            'section3_3' => ['nullable', 'string', 'max:2000'],
            'section3_4' => ['nullable', 'string', 'max:2000'],
        ]);

        if (! Schema::hasTable('system_evaluation_responses')) {
            abort(500, 'ยังไม่ได้สร้างตาราง system_evaluation_responses');
        }

        DB::table('system_evaluation_responses')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'general_answers_json' => json_encode([
                    'age' => $validated['age'],
                    'gender' => $validated['gender'],
                    'gender_other' => $validated['gender_other'] ?? null,
                    'education' => $validated['education'],
                    'treatment_count' => $validated['treatment_count'],
                    'telemedicine_experience' => $validated['telemedicine_experience'],
                ], JSON_UNESCAPED_UNICODE),
                'scale_answers_json' => json_encode($validated['scale_answers'], JSON_UNESCAPED_UNICODE),
                'open_answers_json' => json_encode([
                    'section3_1' => $validated['section3_1'] ?? null,
                    'section3_2' => $validated['section3_2'] ?? null,
                    'section3_3' => $validated['section3_3'] ?? null,
                    'section3_4' => $validated['section3_4'] ?? null,
                ], JSON_UNESCAPED_UNICODE),
                'submitted_at' => now(),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $this->recordTaskCompletion($user->id, self::EVALUATION_FORM_TASK_KEY);
        $this->writeLog($user->id, 'submit_evaluation_form', 'บันทึกแบบประเมินผลการใช้งานระบบต้นแบบ', '/app/evaluation');

        return redirect()->route('home')->with('success', 'ทำแบบประเมินครบถ้วนแล้ว');
    }

    public function about()
    {
        return $this->page([
            'page_title' => 'เกี่ยวกับผู้ทำวิจัย',
            'page_icon' => 'fa-circle-info',
            'page_subtitle' => 'ข้อมูลโครงการและผู้จัดทำวิทยานิพนธ์',
            'hero_title' => 'เกี่ยวกับผู้ทำวิจัย',
            'hero_text' => 'สรุปกรอบพัฒนาระบบจัดเก็บและแลกเปลี่ยนข้อมูลภาพถ่ายโรคผิวหนัง',
            'primary_label' => '',
            'items' => [
                [
                    'title' => 'ชื่องานวิจัย',
                    'meta' => 'กรอบพัฒนาระบบจัดเก็บและแลกเปลี่ยนข้อมูลภาพถ่ายโรคผิวหนังเพื่อสนับสนุนการแพทย์ทางไกล',
                    'icon' => 'fa-file-lines',
                    'color' => '#4552d0',
                    'bg' => 'rgba(69, 82, 208, 0.10)',
                ],
                [
                    'title' => 'โดย',
                    'meta' => 'วศิลป์ จันทร์สมุทร',
                    'icon' => 'fa-user-pen',
                    'color' => '#f07a1d',
                    'bg' => 'rgba(247, 190, 137, 0.24)',
                ],
                [
                    'title' => 'หลักสูตร',
                    'meta' => 'วิทยาศาสตรมหาบัณฑิต (วิทยาการคอมพิวเตอร์) สาขาวิชาวิทยาการคอมพิวเตอร์',
                    'icon' => 'fa-graduation-cap',
                    'color' => '#7d52dd',
                    'bg' => 'rgba(169, 134, 240, 0.20)',
                ],
                [
                    'title' => 'คณะและมหาวิทยาลัย',
                    'meta' => 'คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยธรรมศาสตร์',
                    'icon' => 'fa-building-columns',
                    'color' => '#1c8ea0',
                    'bg' => 'rgba(150, 223, 228, 0.24)',
                ],
                [
                    'title' => 'ปีการศึกษา',
                    'meta' => '2568',
                    'icon' => 'fa-calendar-days',
                    'color' => '#e54f8a',
                    'bg' => 'rgba(243, 153, 184, 0.24)',
                ],
                [
                    'title' => 'ติดต่อ',
                    'meta' => '080-0808714',
                    'icon' => 'fa-phone',
                    'color' => '#16834d',
                    'bg' => 'rgba(34, 197, 94, 0.18)',
                ],
            ],
        ]);
    }

    public function status()
    {
        return view('mobile.status', [
            'page_title' => 'ข้อมูลสถานะผู้เข้าร่วม',
            'current_user' => auth()->user(),
        ]);
    }

    public function systemOverview()
    {
        $user = auth()->user();

        $this->writeLog($user->id, 'view_system_overview', 'เปิดหน้าแนะนำภาพรวมของระบบต้นแบบ', '/app/system-overview');

        return view('mobile.system_overview', [
            'page_title' => 'แนะนำภาพรวมของระบบต้นแบบ',
            'page_subtitle' => 'แนะนำภาพรวมของระบบต้นแบบและฟังก์ชันพื้นฐาน',
            'overview_completed' => $this->isTaskCompleted($user->id, self::SYSTEM_OVERVIEW_TASK_KEY),
            'video_url' => asset('assets/images/pro/plugins/video-1.mp4'),
        ]);
    }

    public function completeSystemOverview(Request $request)
    {
        $user = $request->user();

        $this->recordTaskCompletion($user->id, self::SYSTEM_OVERVIEW_TASK_KEY);
        $this->writeLog($user->id, 'complete_system_overview', 'รับทราบและบันทึกขั้นแนะนำภาพรวมของระบบต้นแบบ', '/app/system-overview');

        return redirect()->route('home')->with('success', 'บันทึกการรับทราบขั้นแนะนำภาพรวมของระบบเรียบร้อยแล้ว');
    }

    public function storeUpload(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'capture_mode' => ['required', 'in:camera,upload,mixed'],
            'symptoms' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,heic,heif', 'max:10240'],
        ], [
            'capture_mode.required' => 'กรุณาเลือกวิธีการถ่ายหรืออัปโหลดภาพ',
            'capture_mode.in' => 'รูปแบบการถ่ายภาพไม่ถูกต้อง',
            'symptoms.required' => 'กรุณากรอกอาการ / โรค',
            'location.required' => 'กรุณากรอกตำแหน่งที่ถ่าย',
            'images.required' => 'กรุณาเพิ่มภาพอย่างน้อย 1 ภาพ',
            'images.array' => 'รูปแบบไฟล์ไม่ถูกต้อง',
            'images.min' => 'กรุณาเพิ่มภาพอย่างน้อย 1 ภาพ',
            'images.*.file' => 'ไฟล์ภาพไม่ถูกต้อง',
            'images.*.mimes' => 'รองรับไฟล์ภาพ JPG, JPEG, PNG, WEBP, HEIC, HEIF',
        ]);

        if (! Schema::hasTable('skin_image_records')) {
            abort(500, 'ยังไม่ได้สร้างตาราง skin_image_records');
        }

        $storedPaths = [];
        foreach ($request->file('images', []) as $file) {
            $storedPaths[] = $file->store('skin-images/' . now()->format('Y/m/d'), 'public');
        }

        $recordId = DB::table('skin_image_records')->insertGetId([
            'user_id' => $user->id,
            'capture_mode' => $validated['capture_mode'],
            'symptoms' => $validated['symptoms'],
            'location' => $validated['location'],
            'notes' => $validated['notes'] ?? null,
            'primary_image_path' => $storedPaths[0] ?? null,
            'image_paths' => json_encode($storedPaths, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'image_count' => count($storedPaths),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->recordTaskCompletion($user->id, self::SKIN_IMAGE_UPLOAD_TASK_KEY);
        $this->writeLog($user->id, 'save_skin_image', 'บันทึกภาพผิวหนัง', '/app/upload', [
            'record_id' => $recordId,
            'image_count' => count($storedPaths),
            'capture_mode' => $validated['capture_mode'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'บันทึกภาพผิวหนังเรียบร้อยแล้ว',
                'redirect_url' => route('app.library'),
            ]);
        }

        return redirect()->route('app.library')->with('success', 'บันทึกภาพผิวหนังเรียบร้อยแล้ว');
    }

    public function notifications()
    {
        return $this->page([
            'page_title' => 'การแจ้งเตือน',
            'page_icon' => 'fa-bell',
            'page_subtitle' => 'รายการแจ้งเตือนล่าสุดของคุณ',
            'hero_title' => 'การแจ้งเตือน',
            'hero_text' => 'รวมรายการแจ้งเตือนสำคัญจากระบบ',
            'primary_label' => 'จัดการการแจ้งเตือน',
            'items' => [
                ['title' => 'นพ.วรชัย เข้าดูข้อมูลของคุณ', 'meta' => '10 นาทีที่แล้ว'],
                ['title' => 'พญ.จันทร์ทิพย์ ขอแชร์ข้อมูล', 'meta' => '1 ชั่วโมงที่แล้ว'],
                ['title' => 'การยินยอมจะหมดอายุในอีก 7 วัน', 'meta' => '2 ชั่วโมงที่แล้ว'],
            ],
        ]);
    }

    public function shares()
    {
        return $this->page([
            'page_title' => 'สถานะการแชร์ข้อมูล',
            'page_icon' => 'fa-share-nodes',
            'page_subtitle' => 'รายการการแชร์ข้อมูลล่าสุด',
            'hero_title' => 'สถานะการแชร์ข้อมูล',
            'hero_text' => 'แสดงผู้รับข้อมูลและสถานะการแชร์ที่เปิดใช้งานอยู่',
            'primary_label' => 'ดูสถานะทั้งหมด',
            'items' => [
                ['title' => 'นพ.วรชัย แพทย์ผิวหนัง', 'meta' => 'แชร์เมื่อ 12 พ.ค. 2567', 'state' => 'กำลังแชร์'],
                ['title' => 'พญ.จันทร์ทิพย์ ผิวหนัง', 'meta' => 'แชร์เมื่อ 10 พ.ค. 2567', 'state' => 'กำลังแชร์'],
                ['title' => 'รศ.นพ.สมชาย ศัลยกรรมผิวหนัง', 'meta' => 'แชร์เมื่อ 08 พ.ค. 2567', 'state' => 'กำลังแชร์'],
            ],
        ]);
    }
}
