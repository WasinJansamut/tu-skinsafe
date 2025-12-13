<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Level;
use App\Models\UserBranchRelate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    // protected $profile_path;

    // public function __construct()
    // {
    //     $this->profile_path = 'assets/images/user/';
    // }

    private function profile_path() // Path ที่อยู่ของรูปภาพโปรไฟล์
    {
        return 'assets/images/user/';
    }


    public function index(Request $request)
    {
        $users = User::orderby('created_at', 'DESC')->with('_branch', '_department', '_level')->get();

        return view('user.index', compact('users'));
    }

    public function create(Request $request)
    {
        try {
            $user = new User;
            $departments = Department::orderBy('name_th', 'DESC')->get();
            $branches = Branch::orderBy('name', 'ASC')->get();
            $branch_relate_array = [];
            $levels = Level::orderBy('name', 'ASC')->get();

            return view('user.create', compact('user', 'departments', 'branches', 'branch_relate_array', 'levels'));
        } catch (\Throwable $e) {
            $error = $e->getMessage() . "<br>";
            $error .= "ไฟล์: " . basename($e->getFile()) . " บรรทัดที่ " . $e->getLine();
            return redirect()->route('user.index')->with('danger', $error);
        }
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'employee_id' => [
                    'required',
                    'string',
                    'max:30',
                    Rule::unique('users')->whereNull('deleted_at'),
                ],
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('users')->whereNull('deleted_at'),
                ],
                'password' => 'required|min:5|max:255|confirmed',
                'password_confirmation' => 'required|min:5|max:255',
                'department_id' => 'required',
                'level_id' => 'required',
                'profile_image' => 'nullable|mimes:jpg,jpeg,png,svg',
                'phone_no' => 'nullable|string|max:20',
            ],
            [
                'employee_id.required' => 'กรุณากรอกรหัสพนักงาน',
                'employee_id.string' => 'รูปแบบรหัสพนักงานต้องเป็นข้อความเท่านั้น',
                'employee_id.max' => 'รหัสพนักงานต้องไม่เกิน 30 ตัวอักษร',
                'employee_id.unique' => 'มีรหัสพนักงานนี้ในระบบแล้ว',
                'name.required' => 'กรุณากรอกชื่อ-นามสกุล',
                'name.string' => 'รูปแบบชื่อ-นามสกุลต้องเป็นข้อความเท่านั้น',
                'name.max' => 'ชื่อ-นามสกุลต้องไม่เกิน 255 ตัวอักษร',
                'name.unique' => 'มีชื่อ-นามสกุลนี้ในระบบแล้ว',
                'email.required' => 'กรุณากรอกอีเมล',
                'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
                'email.max' => 'อีเมลต้องไม่เกิน 255 ตัวอักษร',
                'email.unique' => 'มีอีเมลนี้ในระบบแล้ว',
                'password.required' => 'กรุณากรอกรหัสผ่าน',
                'password.min' => 'รหัสผ่านต้องมากกว่า 5 ตัวอักษร',
                'password.max' => 'รหัสผ่านต้องไม่เกิน 255 ตัวอักษร',
                'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
                'password_confirmation.required' => 'กรุณากรอกยืนยันรหัสผ่าน',
                'password_confirmation.min' => 'ยืนยันรหัสผ่านต้องมากกว่า 5 ตัวอักษร',
                'password_confirmation.max' => 'ยืนยันรหัสผ่านต้องไม่เกิน 255 ตัวอักษร',
                'department_id.required' => 'กรุณาเลือกแผนก',
                'level_id.required' => 'กรุณาเลือกระดับ',
                'profile_image.mimes' => 'รูปโปรไฟล์รองรับ JPG, JPEG, PNG, SVG เท่านั้น',
                'phone_no.string' => 'เบอร์โทรต้องเป็นข้อความเท่านั้น',
                'phone_no.max' => 'เบอร์โทรต้องไม่เกิน 20 ตัวอักษร',
            ]
        );

        try {
            $user = new User;
            $user->employee_id = strtolower($request->employee_id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_no = $request->phone_no;
            $user->password = bcrypt($request->password);
            $user->department_id = $request->department_id;
            $user->level_id = $request->level_id;
            $user->branch_id = $request->branch_id_main;
            if ($request->hasFile('profile_image')) {
                $profile_image = $request->file('profile_image');
                $profile_gen = "profile_" . date('YmdHis');
                $profile_ext = strtolower($profile_image->getClientOriginalExtension());
                $profile_name = $this->profile_path() . $profile_gen . "." . $profile_ext;
                $profile_image->move("{$this->profile_path()}", $profile_name);
                $user->profile_image = $profile_name;
            }
            $roles = is_array($request->input('department_role'))
                ? $request->input('department_role')
                : [optional(Department::find($request->department_id))->code];
            $roles = array_filter($roles); // กรองค่า null ออกกรณีไม่มี department
            $user->department_role = $roles; // ถ้า cast เป็น array แล้วใน model จะ auto json
            $user->affiliation = $request->affiliation;
            $user->user_id = Auth::user()->id;
            $user->save();

            // เรียกฟังก์ชัน save_branch เพื่อบันทึกสาขาที่สามารถเข้าถึงได้
            $this->save_branch($request->merge(['user_id' => $user->id]));

            return redirect()->route('user.index')->with('success', 'เพิ่มข้อมูลผู้ใช้งาน ' . $user->name . ' เรียบร้อยแล้ว');
        } catch (\Throwable $e) {
            $error = $e->getMessage() . "<br>";
            $error .= "ไฟล์: " . basename($e->getFile()) . " บรรทัดที่ " . $e->getLine();
            return redirect()->route('user.index')->with('danger', $error);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $departments = Department::orderBy('name_th', 'DESC')->get();
            $branches = Branch::orderBy('name', 'ASC')->get();
            $users_branch_relate = UserBranchRelate::select('branch_id')->where('user_id', $id)->get();
            $branch_relate_array = [];
            if (!empty($users_branch_relate)) {
                foreach ($users_branch_relate as $user_branch_relate) {
                    $branch_relate_array[] = $user_branch_relate->branch_id;
                }
            }
            $levels = Level::orderBy('name', 'ASC')->get();

            return view('user.edit', compact('user', 'departments', 'branches', 'branch_relate_array', 'levels'));
        } catch (\Throwable $e) {
            $error = $e->getMessage() . "<br>";
            $error .= "ไฟล์: " . basename($e->getFile()) . " บรรทัดที่ " . $e->getLine();
            return redirect()->route('user.index')->with('danger', $error);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'employee_id' => [
                    'required',
                    'string',
                    'max:30',
                    Rule::unique('users')->ignore($id)->whereNull('deleted_at'),
                ],
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('users')->ignore($id)->whereNull('deleted_at'),
                ],
                'password' => 'nullable|min:5|max:255|confirmed',
                'password_confirmation' => 'nullable|min:5|max:255',
                'department_id' => 'required',
                'level_id' => 'required',
                'profile_image' => 'nullable|mimes:jpg,jpeg,png,svg',
                'phone_no' => 'nullable|string|max:20',
            ],
            [
                'employee_id.required' => 'กรุณากรอกรหัสพนักงาน',
                'employee_id.string' => 'รูปแบบรหัสพนักงานต้องเป็นข้อความเท่านั้น',
                'employee_id.max' => 'รหัสพนักงานต้องไม่เกิน 30 ตัวอักษร',
                'employee_id.unique' => 'มีรหัสพนักงานนี้ในระบบแล้ว',
                'name.required' => 'กรุณากรอกชื่อ-นามสกุล',
                'name.string' => 'รูปแบบชื่อ-นามสกุลต้องเป็นข้อความเท่านั้น',
                'name.max' => 'ชื่อ-นามสกุลต้องไม่เกิน 255 ตัวอักษร',
                'name.unique' => 'มีชื่อ-นามสกุลนี้ในระบบแล้ว',
                'email.required' => 'กรุณากรอกอีเมล',
                'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
                'email.max' => 'อีเมลต้องไม่เกิน 255 ตัวอักษร',
                'email.unique' => 'มีอีเมลนี้ในระบบแล้ว',
                'password.min' => 'รหัสผ่านต้องมากกว่า 5 ตัวอักษร',
                'password.max' => 'รหัสผ่านต้องไม่เกิน 255 ตัวอักษร',
                'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
                'password_confirmation.min' => 'ยืนยันรหัสผ่านต้องมากกว่า 5 ตัวอักษร',
                'password_confirmation.max' => 'ยืนยันรหัสผ่านต้องไม่เกิน 255 ตัวอักษร',
                'department_id.required' => 'กรุณาเลือกแผนก',
                'level_id.required' => 'กรุณาเลือกระดับ',
                'profile_image.mimes' => 'รูปโปรไฟล์รองรับ JPG, JPEG, PNG, SVG เท่านั้น',
                'phone_no.string' => 'เบอร์โทรต้องเป็นข้อความเท่านั้น',
                'phone_no.max' => 'เบอร์โทรต้องไม่เกิน 20 ตัวอักษร',
            ]
        );

        try {
            $user = User::findOrFail($id);

            $user->employee_id = strtolower($request->employee_id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_no = $request->phone_no;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->department_id = $request->department_id;
            $user->level_id = $request->level_id;
            $user->branch_id = $request->branch_id_main;
            if ($request->hasFile('profile_image')) {
                $profile_image = $request->file('profile_image');
                $profile_gen = "profile_" . date('YmdHis');
                $profile_ext = strtolower($profile_image->getClientOriginalExtension());
                $profile_name = $this->profile_path() . $profile_gen . "." . $profile_ext;
                $profile_image->move("{$this->profile_path()}", $profile_name);
                @unlink($user->profile_image);
                $user->profile_image = $profile_name;
            }
            $roles = is_array($request->input('department_role')) ? $request->input('department_role') : [optional(Department::find($request->department_id))->code];
            $roles = array_filter($roles); // กรองค่า null ออกกรณีไม่มี department
            $user->department_role = $roles; // ถ้า cast เป็น array แล้วใน model จะ auto json
            $user->affiliation = $request->affiliation;
            $user->user_id_edit = Auth::user()->id;
            $user->update();

            // เรียกฟังก์ชัน save_branch เพื่อบันทึกสาขาที่สามารถเข้าถึงได้
            $this->save_branch($request->merge(['user_id' => $user->id]));

            return redirect()->route('user.index')->with('success', 'แก้ไขข้อมูลผู้ใช้งาน ' . $user->name . ' เรียบร้อยแล้ว');
        } catch (\Throwable $e) {
            $error = $e->getMessage() . "<br>";
            $error .= "ไฟล์: " . basename($e->getFile()) . " บรรทัดที่ " . $e->getLine();
            return redirect()->route('user.index')->with('danger', $error);
        }
    }

    public function soft_delete(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('user.index')->with('success', 'ลบข้อมูลผู้ใช้งาน ' . $user->name . ' เรียบร้อยแล้ว');
        } catch (\Throwable $e) {
            $error = $e->getMessage() . "<br>";
            $error .= "ไฟล์: " . basename($e->getFile()) . " บรรทัดที่ " . $e->getLine();
            return redirect()->route('user.index')->with('danger', $error);
        }
    }

    public function my_profile_edit(Request $request)
    {
        try {
            $id = Auth::user()->id;
            $user = User::with('_branch', '_department', '_level')->findOrFail($id);

            // [Start] แสดง Session
            $sessions = [];
            $session_lifetime = config('session.lifetime') * 60; // นาที → วินาที
            $now = time();
            foreach (File::files(storage_path('framework/sessions')) as $file) {
                $contents = File::get($file->getPathname());

                if (strpos($contents, 'user_id";i:' . $id . ';') !== false) {
                    $data = @unserialize($contents);

                    // ตรวจ last_activity_at (timestamp)
                    $last_activity_at = $data['last_activity_at'] ?? null;
                    if ($last_activity_at) {
                        if (!is_numeric($last_activity_at)) { // ถ้าเป็น datetime string → แปลงเป็น timestamp
                            $last_activity_at = strtotime($last_activity_at);
                        }
                        if ((now()->timestamp - $last_activity_at) > $session_lifetime) { // ถ้า session หมดอายุ → ข้าม
                            continue;
                        }
                    }

                    $sessions[] = (object)[
                        'session_file'     => $file->getFilename(),
                        'session_id'       => $data['session_id'] ?? null,
                        'user_id'          => $data['user_id'] ?? null,
                        'ip_address'       => $data['ip_address'] ?? null,
                        'device'           => $data['device'] ?? null,
                        'device_type'      => $data['device_type'] ?? null,
                        'device_category'  => $data['device_category'] ?? null,
                        'browser'          => $data['browser'] ?? null,
                        'user_agent'       => $data['user_agent'] ?? null,
                        'country'          => $data['country'] ?? null,
                        'city'             => $data['city'] ?? null,
                        'login_at'         => $data['login_at'] ?? null,
                        'last_activity_at' => $data['last_activity_at'] ?? null,
                    ];
                }
            }
            $currentSessionId = session()->getId(); // แยก session ปัจจุบัน
            $current = null;
            $others = [];
            foreach ($sessions as $session) {
                if ($session->session_file === $currentSessionId) {
                    $current = $session;
                } else {
                    $others[] = $session;
                }
            }
            usort($others, function ($a, $b) { // เรียง others ตาม login_at DESC (ใหม่ → เก่า)
                return strtotime($b->login_at) <=> strtotime($a->login_at);
            });
            $sessions = $current ? array_merge([$current], $others) : $others; // รวม session ปัจจุบันไว้หน้าแรก
            // [End] แสดง Session

            return view('user.my_profile', compact('user', 'sessions'));
        } catch (\Throwable $e) {
            $error = $e->getMessage() . "<br>";
            $error .= "ไฟล์: " . basename($e->getFile()) . " บรรทัดที่ " . $e->getLine();
            return redirect()->route('home')->with('danger', $error);
        }
    }

    public function my_profile_update(Request $request)
    {
        $request->validate(
            [
                'password' => 'nullable|min:5|max:255|confirmed',
                'password_confirmation' => 'nullable|min:5|max:255',
                'profile_image' => 'nullable|mimes:jpg,jpeg,png,svg',
                'phone_no' => 'nullable|string|max:20',
            ],
            [
                'password.min' => 'รหัสผ่านต้องมากกว่า 5 ตัวอักษร',
                'password.max' => 'รหัสผ่านต้องไม่เกิน 255 ตัวอักษร',
                'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
                'password_confirmation.min' => 'ยืนยันรหัสผ่านต้องมากกว่า 5 ตัวอักษร',
                'password_confirmation.max' => 'ยืนยันรหัสผ่านต้องไม่เกิน 255 ตัวอักษร',
                'profile_image.mimes' => 'รูปโปรไฟล์รองรับ JPG, JPEG, PNG, SVG เท่านั้น',
                'phone_no.string' => 'เบอร์โทรต้องเป็นข้อความเท่านั้น',
                'phone_no.max' => 'เบอร์โทรต้องไม่เกิน 20 ตัวอักษร',
            ]
        );

        try {
            $id = Auth::user()->id;
            $user = User::findOrFail($id);
            $old_user = $user->replicate();

            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            if ($request->hasFile('profile_image')) {
                $profile_image = $request->file('profile_image');
                $profile_gen = "profile_" . date('YmdHis');
                $profile_ext = strtolower($profile_image->getClientOriginalExtension());
                $profile_name = $this->profile_path() . $profile_gen . "." . $profile_ext;
                $profile_image->move("{$this->profile_path()}", $profile_name);
                @unlink($user->profile_image);
                $user->profile_image = $profile_name;
            }
            $user->phone_no = $request->phone_no;
            $user->update();

            return redirect()->route('user.my_profile_edit')->with('success', 'แก้ไขโปรไฟล์เรียบร้อยแล้ว');
        } catch (\Throwable $e) {
            $error = $e->getMessage() . "<br>";
            $error .= "ไฟล์: " . basename($e->getFile()) . " บรรทัดที่ " . $e->getLine();
            return redirect()->route('user.my_profile_edit')->with('danger', $error);
        }
    }

    public function restore(Request $request, $id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->restore();

            return redirect()->route('user.index')->with('success', 'กู้คืนข้อมูลผู้ใช้งาน ' . $user->name . ' เรียบร้อยแล้ว');
        } catch (\Throwable $e) {
            $error = $e->getMessage() . "<br>";
            $error .= "ไฟล์: " . basename($e->getFile()) . " บรรทัดที่ " . $e->getLine();
            return redirect()->route('user.index')->with('danger', $error);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($id);
            @unlink($user->profile_image);
            $user->forceDelete();

            return redirect()->route('user.index')->with('success', 'ลบข้อมูลผู้ใช้งาน ' . $user->name . ' ถาวรเรียบร้อยแล้ว');
        } catch (\Throwable $e) {
            $error = $e->getMessage() . "<br>";
            $error .= "ไฟล์: " . basename($e->getFile()) . " บรรทัดที่ " . $e->getLine();
            return redirect()->route('user.index')->with('danger', $error);
        }
    }

    public function logout(Request $request)
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
}
