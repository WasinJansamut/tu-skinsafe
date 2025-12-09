<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @method \Illuminate\Routing\Controller middleware($middleware, array $options = [])
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validation
        $request->validate(
            [
                'username' => 'required|string|max:30',
                'password' => 'required|string',
            ],
            [
                'username.required' => 'กรุณากรอกชื่อผู้ใช้งาน',
                'username.string' => 'รูปแบบชื่อผู้ใช้งานต้องเป็นข้อความเท่านั้น',
                'username.max' => 'ชื่อผู้ใช้งานต้องไม่เกิน 30 ตัวอักษร',
                'password.required' => 'กรุณากรอกรหัสผ่าน',
                'password.string' => 'รูปแบบรหัสผ่านต้องเป็นข้อความเท่านั้น',
            ]
        );

        // Custom authentication logic using username
        $credentials = $request->only('username', 'password');

        // Attempt to log the user in
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            return redirect()->intended($this->redirectPath());
        }

        // Login failed
        return redirect()->back()->withErrors([
            'username' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่',
        ]);
    }
}
