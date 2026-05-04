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
        $uploadTaskKey = 'skin_image_upload';
        $libraryTaskKey = 'library_detail';
        $consentTaskKey = 'consent_page';
        $accessTaskKey = 'access_page';
        $historyTaskKey = 'history_page';
        $evaluationTaskKey = 'evaluation_form';
        $overviewTaskCompleted = false;
        $uploadTaskCompleted = false;
        $libraryTaskCompleted = false;
        $consentTaskCompleted = false;
        $accessTaskCompleted = false;
        $historyTaskCompleted = false;
        $evaluationTaskCompleted = false;
        $evaluationReady = false;

        if ($user?->role === 'research_participant') {
            $overviewTaskCompleted = UserTaskCompletion::query()
                ->where('user_id', $user->id)
                ->where('task_key', $overviewTaskKey)
                ->whereNotNull('completed_at')
                ->exists();

            $uploadTaskCompleted = UserTaskCompletion::query()
                ->where('user_id', $user->id)
                ->where('task_key', $uploadTaskKey)
                ->whereNotNull('completed_at')
                ->exists();

            $libraryTaskCompleted = UserTaskCompletion::query()
                ->where('user_id', $user->id)
                ->where('task_key', $libraryTaskKey)
                ->whereNotNull('completed_at')
                ->exists();

            $consentTaskCompleted = UserTaskCompletion::query()
                ->where('user_id', $user->id)
                ->where('task_key', $consentTaskKey)
                ->whereNotNull('completed_at')
                ->exists();

            $accessTaskCompleted = UserTaskCompletion::query()
                ->where('user_id', $user->id)
                ->where('task_key', $accessTaskKey)
                ->whereNotNull('completed_at')
                ->exists();

            $historyTaskCompleted = UserTaskCompletion::query()
                ->where('user_id', $user->id)
                ->where('task_key', $historyTaskKey)
                ->whereNotNull('completed_at')
                ->exists();

            $evaluationTaskCompleted = UserTaskCompletion::query()
                ->where('user_id', $user->id)
                ->where('task_key', $evaluationTaskKey)
                ->whereNotNull('completed_at')
                ->exists();

            $evaluationReady = $overviewTaskCompleted
                && $uploadTaskCompleted
                && $libraryTaskCompleted
                && $consentTaskCompleted
                && $accessTaskCompleted
                && $historyTaskCompleted;

            return view('home', compact(
                'overviewTaskCompleted',
                'uploadTaskCompleted',
                'libraryTaskCompleted',
                'consentTaskCompleted',
                'accessTaskCompleted',
                'historyTaskCompleted',
                'evaluationTaskCompleted',
                'evaluationReady'
            ));
        }

        return view('admin.home', [
            'user' => $user,
        ]);
    }
}
