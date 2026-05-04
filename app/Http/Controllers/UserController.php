<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function ensureAdmin()
    {
        $hasAdmin = User::where('role', 'admin')->exists();

        if ($hasAdmin && Auth::user()?->role !== 'admin') {
            abort(403, 'เฉพาะผู้ดูแลระบบเท่านั้น');
        }
    }

    private function writeAuditLog(string $actionKey, string $actionLabel, string $pagePath, array $details = []): void
    {
        if (! Schema::hasTable('system_logs')) {
            return;
        }

        $payload = [
            'user_id' => Auth::id(),
            'action_key' => $actionKey,
            'action_label' => $actionLabel,
            'page_path' => $pagePath,
            'details' => ! empty($details) ? json_encode($details, JSON_UNESCAPED_UNICODE) : null,
            'created_at' => now(),
        ];

        $currentUser = Auth::user();

        if (Schema::hasColumn('system_logs', 'actor_name')) {
            $payload['actor_name'] = $currentUser?->name;
        }

        if (Schema::hasColumn('system_logs', 'actor_role')) {
            $payload['actor_role'] = $currentUser?->role;
        }

        if (Schema::hasColumn('system_logs', 'action_type')) {
            $payload['action_type'] = 'delete';
        }

        if (Schema::hasColumn('system_logs', 'target_type')) {
            $payload['target_type'] = $details['target_user_role'] ?? 'research_participant';
        }

        if (Schema::hasColumn('system_logs', 'target_id')) {
            $payload['target_id'] = $details['target_user_id'] ?? null;
        }

        if (Schema::hasColumn('system_logs', 'description')) {
            $payload['description'] = $actionLabel;
        }

        if (Schema::hasColumn('system_logs', 'is_read')) {
            $payload['is_read'] = 0;
        }

        DB::table('system_logs')->insert($payload);
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();

        $users = User::orderBy('created_at', 'DESC')->get();
        $taskKeys = [
            'system_overview',
            'skin_image_upload',
            'library_detail',
            'consent_page',
            'access_page',
            'history_page',
        ];
        $taskTotal = count($taskKeys);
        $taskCounts = DB::table('user_task_completions')
            ->whereIn('task_key', $taskKeys)
            ->whereNotNull('completed_at')
            ->groupBy('user_id')
            ->selectRaw('user_id, COUNT(DISTINCT task_key) as task_completed_count')
            ->pluck('task_completed_count', 'user_id');

        $users = $users->map(function ($user) use ($taskCounts, $taskTotal) {
            if (($user->role ?? null) === 'research_participant') {
                $completed = (int) ($taskCounts[$user->id] ?? 0);
                $user->task_completed_count = $completed;
                $user->task_completed_total = $taskTotal;
                $user->task_completed_label = $completed . '/' . $taskTotal;
                $user->task_completed_class = $completed >= $taskTotal ? 'bg-success' : 'bg-secondary';
            } else {
                $user->task_completed_count = null;
                $user->task_completed_total = null;
                $user->task_completed_label = '-';
                $user->task_completed_class = 'bg-secondary';
            }

            return $user;
        });

        return view('user.index', compact('users'));
    }

    public function create(Request $request)
    {
        $this->ensureAdmin();

        $user = new User();

        return view('user.create', compact('user'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:30', 'alpha_dash', Rule::unique('users', 'username')],
                'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
                'compensation_channel' => ['nullable', 'string', 'max:255'],
                'status_payto_research_participant' => ['nullable', 'string', 'max:50'],
                'role' => ['required', Rule::in(['admin', 'research_participant'])],
                'password' => ['required', 'string', 'min:5', 'max:255', 'confirmed'],
                'password_confirmation' => ['required', 'string', 'min:5', 'max:255'],
            ],
            [
                'name.required' => 'กรุณากรอกชื่อ-นามสกุล',
                'username.required' => 'กรุณากรอกชื่อผู้ใช้งาน',
                'username.max' => 'ชื่อผู้ใช้งานต้องไม่เกิน 30 ตัวอักษร',
                'username.alpha_dash' => 'ชื่อผู้ใช้งานใช้ได้เฉพาะตัวอักษรอังกฤษ ตัวเลข ขีดกลาง และขีดล่าง',
                'username.unique' => 'มีชื่อผู้ใช้งานนี้ในระบบแล้ว',
                'email.required' => 'กรุณากรอกอีเมล',
                'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
                'email.unique' => 'มีอีเมลนี้ในระบบแล้ว',
                'compensation_channel.string' => 'ช่องทางการชำระ / รับค่าตอบแทนต้องเป็นข้อความ',
                'compensation_channel.max' => 'ช่องทางการชำระ / รับค่าตอบแทนต้องไม่เกิน 255 ตัวอักษร',
                'status_payto_research_participant.string' => 'สถานะการชำระเงินต้องเป็นข้อความ',
                'status_payto_research_participant.max' => 'สถานะการชำระเงินต้องไม่เกิน 50 ตัวอักษร',
                'role.required' => 'กรุณาเลือกประเภทผู้ใช้งาน',
                'password.required' => 'กรุณากรอกรหัสผ่าน',
                'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 5 ตัวอักษร',
                'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
                'password_confirmation.required' => 'กรุณากรอกยืนยันรหัสผ่าน',
            ]
        );

        User::create([
            'name' => $validated['name'],
            'username' => strtolower($validated['username']),
            'email' => strtolower($validated['email']),
            'compensation_channel' => $validated['compensation_channel'] ?? null,
            'status_payto_research_participant' => $validated['status_payto_research_participant'] ?? null,
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('user.index')->with('success', 'เพิ่มข้อมูลผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function participant_register(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:30', 'alpha_dash', Rule::unique('users', 'username')],
                'compensation_channel' => ['required', 'string', 'max:255'],
                'no_compensation' => ['nullable', 'in:1'],
                'password' => ['required', 'string', 'min:5', 'max:255', 'confirmed'],
                'password_confirmation' => ['required', 'string', 'min:5', 'max:255'],
            ],
            [
                'name.required' => 'กรุณากรอกนามสมมุติ',
                'username.required' => 'กรุณากรอกชื่อผู้ใช้งาน',
                'username.max' => 'ชื่อผู้ใช้งานต้องไม่เกิน 30 ตัวอักษร',
                'username.alpha_dash' => 'ชื่อผู้ใช้งานใช้ได้เฉพาะตัวอักษรอังกฤษ ตัวเลข ขีดกลาง และขีดล่าง',
                'username.unique' => 'มีชื่อผู้ใช้งานนี้ในระบบแล้ว',
                'compensation_channel.required' => 'กรุณากรอกช่องทางการจ่ายค่าตอบแทน',
                'compensation_channel.string' => 'ช่องทางการจ่ายค่าตอบแทนต้องเป็นข้อความ',
                'compensation_channel.max' => 'ช่องทางการจ่ายค่าตอบแทนต้องไม่เกิน 255 ตัวอักษร',
                'no_compensation.in' => 'รูปแบบตัวเลือกไม่ถูกต้อง',
                'password.required' => 'กรุณากรอกรหัสผ่าน',
                'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 5 ตัวอักษร',
                'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
                'password_confirmation.required' => 'กรุณากรอกยืนยันรหัสผ่าน',
            ]
        );

        $placeholderEmail = sprintf('participant-%s@tu-skinsafe.local', Str::uuid()->toString());
        $noCompensation = $request->boolean('no_compensation');
        $compensationChannel = $noCompensation ? 'ไม่รับค่าตอบแทน' : trim($validated['compensation_channel']);
        $paymentStatus = $noCompensation ? 'ไม่ขอรับค่าตอบแทน' : 'รอชำระค่าตอบแทน';

        $user = User::create([
            'name' => trim($validated['name']),
            'username' => strtolower(trim($validated['username'])),
            'email' => $placeholderEmail,
            'compensation_channel' => $compensationChannel,
            'status_payto_research_participant' => $paymentStatus,
            'role' => 'research_participant',
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'สมัครเข้าร่วมวิจัยสำเร็จ สามารถเข้าสู่ระบบเพื่อทำแบบทดสอบได้เลย',
            'user' => [
                'name' => $user->name,
                'username' => $user->username,
            ],
        ], 201);
    }

    public function edit(Request $request, $id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);

        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:30', 'alpha_dash', Rule::unique('users', 'username')->ignore($user->id)],
                'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
                'compensation_channel' => ['nullable', 'string', 'max:255'],
                'status_payto_research_participant' => ['nullable', 'string', 'max:50'],
                'role' => ['required', Rule::in(['admin', 'research_participant'])],
                'password' => ['nullable', 'string', 'min:5', 'max:255', 'confirmed'],
                'password_confirmation' => ['nullable', 'string', 'min:5', 'max:255'],
            ],
            [
                'name.required' => 'กรุณากรอกชื่อ-นามสกุล',
                'username.required' => 'กรุณากรอกชื่อผู้ใช้งาน',
                'username.max' => 'ชื่อผู้ใช้งานต้องไม่เกิน 30 ตัวอักษร',
                'username.alpha_dash' => 'ชื่อผู้ใช้งานใช้ได้เฉพาะตัวอักษรอังกฤษ ตัวเลข ขีดกลาง และขีดล่าง',
                'username.unique' => 'มีชื่อผู้ใช้งานนี้ในระบบแล้ว',
                'email.required' => 'กรุณากรอกอีเมล',
                'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
                'email.unique' => 'มีอีเมลนี้ในระบบแล้ว',
                'compensation_channel.string' => 'ช่องทางการชำระ / รับค่าตอบแทนต้องเป็นข้อความ',
                'compensation_channel.max' => 'ช่องทางการชำระ / รับค่าตอบแทนต้องไม่เกิน 255 ตัวอักษร',
                'status_payto_research_participant.string' => 'สถานะการชำระเงินต้องเป็นข้อความ',
                'status_payto_research_participant.max' => 'สถานะการชำระเงินต้องไม่เกิน 50 ตัวอักษร',
                'role.required' => 'กรุณาเลือกประเภทผู้ใช้งาน',
                'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 5 ตัวอักษร',
                'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
            ]
        );

        $user->name = $validated['name'];
        $user->username = strtolower($validated['username']);
        $user->email = strtolower($validated['email']);
        $user->compensation_channel = $validated['compensation_channel'] ?? null;
        $user->status_payto_research_participant = $validated['status_payto_research_participant'] ?? null;
        $user->role = $validated['role'];

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'แก้ไขข้อมูลผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function soft_delete(Request $request, $id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);

        if ((int) Auth::id() === (int) $user->id) {
            return redirect()->route('user.index')->with('danger', 'ไม่สามารถลบบัญชีผู้ใช้งานของตัวเองได้');
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'ลบข้อมูลผู้ใช้งานเรียบร้อยแล้ว');
    }

    public function reset_participant_data(Request $request, $id)
    {
        $this->ensureAdmin();

        $user = User::findOrFail($id);

        if ($user->role !== 'research_participant') {
            return redirect()->route('user.index')->with('danger', 'คำสั่งรีเซ็ตนี้ใช้ได้เฉพาะผู้เข้าร่วมวิจัย');
        }

        $tablesToClear = [
            'skin_image_records',
            'user_access_permissions',
            'user_consent_records',
            'system_evaluation_responses',
            'user_task_completions',
            'system_logs',
            'user_share_permissions',
            'user_data_shares',
            'skin_image_shares',
        ];

        $summary = [];

        DB::transaction(function () use ($user, $tablesToClear, &$summary) {
            foreach ($tablesToClear as $table) {
                if (! Schema::hasTable($table)) {
                    continue;
                }

                $columns = Schema::getColumnListing($table);
                if ($table === 'system_logs') {
                    $query = DB::table($table)->where(function ($nested) use ($user, $columns) {
                        if (in_array('user_id', $columns, true)) {
                            $nested->where('user_id', $user->id);
                        }
                        if (in_array('target_id', $columns, true)) {
                            $nested->orWhere('target_id', $user->id);
                        }
                        if (in_array('details', $columns, true)) {
                            $nested->orWhere('details', 'like', '%"target_user_id":' . $user->id . '%')
                                ->orWhere('details', 'like', '%"user_id":' . $user->id . '%')
                                ->orWhere('details', 'like', '%"target_id":' . $user->id . '%');
                        }
                    });

                    $summary[$table] = (clone $query)->count();
                    $query->delete();
                    continue;
                }

                if (! in_array('user_id', $columns, true)) {
                    continue;
                }

                $summary[$table] = DB::table($table)->where('user_id', $user->id)->count();
                DB::table($table)->where('user_id', $user->id)->delete();
            }
        });

        $this->writeAuditLog('reset_participant_data', 'รีเซ็ตข้อมูลผู้เข้าร่วมวิจัย', '/user', [
            'target_user_id' => $user->id,
            'target_user_name' => $user->name,
            'target_user_role' => $user->role,
            'deleted_tables' => $summary,
        ]);

        return redirect()->route('user.index')->with('success', 'รีเซ็ตข้อมูลผู้เข้าร่วมวิจัยเรียบร้อยแล้ว');
    }

    public function my_profile_edit(Request $request)
    {
        $user = Auth::user();

        return view('user.my_profile', compact('user'));
    }

    public function my_profile_update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $validated = $request->validate(
            [
                'password' => ['nullable', 'string', 'min:5', 'max:255', 'confirmed'],
                'password_confirmation' => ['nullable', 'string', 'min:5', 'max:255'],
            ],
            [
                'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 5 ตัวอักษร',
                'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
            ]
        );

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
            $user->save();
        }

        return redirect()->route('user.my_profile_edit')->with('success', 'แก้ไขโปรไฟล์เรียบร้อยแล้ว');
    }
}
