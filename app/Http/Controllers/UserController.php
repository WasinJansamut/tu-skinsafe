<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BillMaster;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Level;
use App\Models\UserBranchRelate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
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
            $old_user = $user->replicate();

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

    public function logout_my_others(Request $request)
    {
        try {
            $session_file = $request->input('session_file');
            $user_id = Auth::id(); // user ปัจจุบัน

            $path = storage_path('framework/sessions/' . $session_file);

            if (!File::exists($path)) {
                return redirect()->back()->with('info', 'Session ที่เลือกไม่พบหรือถูกลบไปแล้ว');
            }

            // อ่านไฟล์ session เพื่อตรวจสอบ user_id
            $contents = File::get($path);
            $data = @unserialize($contents);

            if (!isset($data['user_id']) || $data['user_id'] != $user_id) {
                return redirect()->back()->with('danger', 'ไม่สามารถออกจากระบบของผู้ใช้อื่นได้');
            }

            // ตรวจสอบไม่ให้ logout session ปัจจุบัน
            if ($session_file === session()->getId()) {
                return redirect()->back()->with('warning', 'ไม่สามารถออกจากระบบปัจจุบันได้');
            }

            // ลบไฟล์ session
            File::delete($path);
            return redirect()->route('user.my_profile_edit')->with('success', 'ออกจากระบบเรียบร้อยแล้ว');
        } catch (\Throwable $e) {
            $error = $e->getMessage() . "<br>";
            $error .= "ไฟล์: " . basename($e->getFile()) . " บรรทัดที่ " . $e->getLine();
            return redirect()->route('user.my_profile_edit')->with('danger', $error);
        }
    }

    public function logout_my_all_others(Request $request)
    {
        try {
            $current_session_id = session()->getId();
            $user_id = Auth::id();
            foreach (File::files(storage_path('framework/sessions')) as $file) {
                $contents = File::get($file->getPathname());
                if (strpos($contents, 'user_id";i:' . $user_id . ';') !== false) { // ตรวจว่าไฟล์ session นี้เป็นของ user ปัจจุบัน
                    if ($file->getFilename() !== $current_session_id) { // ถ้าไม่ใช่ session ปัจจุบัน → ลบไฟล์
                        File::delete($file->getPathname());
                    }
                }
            }
            return redirect()->route('user.my_profile_edit')->with('success', 'ออกจากระบบทั้งหมดเรียบร้อยแล้ว');
        } catch (\Throwable $e) {
            $error = $e->getMessage() . "<br>";
            $error .= "ไฟล์: " . basename($e->getFile()) . " บรรทัดที่ " . $e->getLine();
            return redirect()->route('user.my_profile_edit')->with('danger', $error);
        }
    }

    public function save_branch(Request $request)
    {
        $user_id = $request->user_id;
        $branch_id = $request->branch_id;
        if ($branch_id) {
            $branch_data = [];
            foreach ($branch_id as $key => $value) {
                $branch_data[] = [
                    'user_id' => $user_id,
                    'branch_id' => $key,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            // ลบแคชที่เกี่ยวข้องหลังจากแก้ไขสาขา
            Cache::forget('branch_user_relate_' . Auth::user()->id);
            if (!empty($branch_data)) {
                UserBranchRelate::where('user_id', $user_id)->delete();
                UserBranchRelate::insert($branch_data);
                // return redirect()->route('user.edit', $user_id)->with('success', 'อัปเดตสาขาเรียบร้อยแล้ว');
            } else {
                // return redirect()->route('user.edit', $user_id)->with('danger', 'กรุณาเลือกสาขา');
            }
        }
    }

    public function change_main_branch(Request $request, $branch_id)
    {
        $user_id = Auth::user()->id;
        $user_branch_relate = UserBranchRelate::where('user_id', $user_id)
            ->where('branch_id', $branch_id)->first();
        $branch = Branch::get()->keyBy('id');
        if ($user_branch_relate) {
            $user = User::findOrFail($user_id);
            $user_branch_id_old = [
                'branch_id' => $user->branch_id,
                'branch_code' => $branch[$user->branch_id]->code ?? null,
                'branch_name' => $branch[$user->branch_id]->name ?? null,
            ];
            $user_branch_id_new = [
                'branch_id' => $branch_id,
                'branch_code' => $branch[$branch_id]->code ?? null,
                'branch_name' => $branch[$branch_id]->name ?? null,
            ];

            $user->branch_id = $branch_id;
            $user->update();

            // รีเฟรชข้อมูลใน Auth::user()
            Auth::setUser($user->refresh());

            $code_and_name = '[' . ($branch[$branch_id]->code ?? '') . '] ' . $branch[$branch_id]->name ?? '';

            // [Start] เก็บ Log
            $request->merge([
                'log_data_id' => $user->id,
                'log_page_name' => 'change_main_branch',
                'log_page_name_th' => 'ย้ายสาขา',
                'log_detail' => 'ย้ายสาขา',
                'log_raw_data' => json_encode($user_branch_id_old),
                'log_raw_data_edit' => json_encode($user_branch_id_new),
            ]);
            (new LogController)->update($request);
            // [End] เก็บ Log

            return redirect()->back()->with('success', 'ย้ายเป็นสาขา ' . $code_and_name . ' เรียบร้อยแล้ว');
        } else {
            return redirect()->back()->with('danger', 'เกิดข้อผิดพลาดในการเปลี่ยนสาขา');
        }
    }

    public function ajax_get_auth_user()
    {
        return response()->json([
            'result' => User::with('_branch')->findOrFail(Auth::user()->id) ?? null
        ]);
    }

    public function ajax_update_auth_user_branch_id(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|integer|exists:branches,id',
        ]);

        $user = User::findOrFail(Auth::user()->id);
        $user->branch_id = $request->branch_id;
        $user->update();

        return response()->json(['success' => true]);
    }

    public function ajax_check_and_update_ip(Request $request)
    {
        // ถ้ายังไม่ได้ล็อกอิน
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $currentIp = $request->input('ip'); // ดึงค่า IP จาก request

        // ✅ ตรวจสอบรูปแบบ IP (IPv4 / IPv6)
        if (!filter_var($currentIp, FILTER_VALIDATE_IP)) {
            return response()->json(['status' => 'invalid_ip'], 422);
        }

        // ถ้า IP ไม่เหมือนเดิม → อัปเดต
        if ($user->ip !== $currentIp) {
            try {
                $user->timestamps = false; // ปิด timestamps ชั่วคราว
                $user->ip = $currentIp;
                $user->save();

                return response()->json(['status' => 'updated']);
            } catch (\Throwable $e) {
                // ✅ กันกรณี DB หรือ model พัง
                return response()->json(['status' => 'error', 'message' => $e->getMessage(),], 500);
            }
        }

        return response()->json(['status' => 'no_change']); // ✅ กรณี IP เดิมอยู่แล้ว ไม่ต้องอัปเดต
    }

    public function salesTransfer(Request $request)
    {
        // ดึงเฉพาะผู้ใช้ที่มี department_code เป็น SSALES หรือ SALES เท่านั้น
        $users = User::whereHas('_department', function ($query) {
            $query->whereIn('code', ['SSALES', 'SALES']);
        })->orderBy('name', 'ASC')->get();

        if ($request->isMethod('post')) {

            $request->validate([
                'old_sales_id' => 'required|exists:users,id',
                'new_sales_id' => 'required|exists:users,id',
            ], [
                'old_sales_id.required' => 'กรุณาเลือก Sales เก่า',
                'new_sales_id.required' => 'กรุณาเลือก Sales ใหม่',
            ]);

            $old_sales_id = $request->old_sales_id;
            $new_sales_id = $request->new_sales_id;

            // โอนย้ายงานในตาราง bill_master ให้ Sales ใหม่
            BillMaster::where('user_id', $old_sales_id)
                ->update(['user_id' => $new_sales_id]);

            return redirect()->route('user.sales_transfer')->with('success', 'โอนย้ายงาน Sales สำเร็จ');
        }

        return view('user.sales_transfer', compact('users'));
    }
}
