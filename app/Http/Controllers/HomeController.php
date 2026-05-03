<?php

namespace App\Http\Controllers;

use App\Models\UserTaskCompletion;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $overviewTaskKey = 'system_overview';
        $overviewTaskCompleted = false;

        if ($user?->role === 'research_participant') {
            $overviewTaskCompleted = UserTaskCompletion::query()
                ->where('user_id', $user->id)
                ->where('task_key', $overviewTaskKey)
                ->whereNotNull('completed_at')
                ->exists();

            return view('home', compact('overviewTaskCompleted'));
        }

        return view('admin.home', [
            'user' => $user,
        ]);
    }
}
