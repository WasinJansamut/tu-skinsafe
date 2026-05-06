<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

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
    protected $redirectTo = '/';

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
        $participantRegisteredCount = $this->completedParticipantCount();
        $participantTargetCount = 30;

        return view('auth.login', compact('participantRegisteredCount', 'participantTargetCount'));
    }

    private function completedParticipantCount(): int
    {
        $cacheKey = $this->completedParticipantCountCacheKey();

        return Cache::remember($cacheKey, 60, function () {
            return $this->completedParticipantCountFresh();
        });
    }

    private function completedParticipantCountFresh(): int
    {
        if (! Schema::hasTable('user_task_completions') || ! Schema::hasTable('system_evaluation_responses')) {
            return 0;
        }

        $taskKeys = [
            'system_overview',
            'skin_image_upload',
            'library_detail',
            'consent_page',
            'access_page',
            'history_page',
        ];

        $subquery = DB::table('users as u')
            ->join('user_task_completions as utc', 'u.id', '=', 'utc.user_id')
            ->join('system_evaluation_responses as ser', 'u.id', '=', 'ser.user_id')
            ->where('u.role', 'research_participant')
            ->whereIn('utc.task_key', $taskKeys)
            ->whereNotNull('utc.completed_at')
            ->groupBy('utc.user_id')
            ->select('utc.user_id')
            ->havingRaw('COUNT(DISTINCT utc.task_key) = ?', [count($taskKeys)]);

        return DB::query()
            ->fromSub($subquery, 'completed_participants')
            ->count();
    }

    private function completedParticipantCountCacheKey(): string
    {
        return 'completed_participant_count_v1';
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
