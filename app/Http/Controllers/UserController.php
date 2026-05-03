<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function index(Request $request)
    {
        $this->ensureAdmin();

        $users = User::orderBy('created_at', 'DESC')->get();

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
                'role.required' => 'กรุณาเลือกประเภทผู้ใช้งาน',
                'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 5 ตัวอักษร',
                'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
            ]
        );

        $user->name = $validated['name'];
        $user->username = strtolower($validated['username']);
        $user->email = strtolower($validated['email']);
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
