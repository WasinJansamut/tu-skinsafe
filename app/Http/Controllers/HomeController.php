<?php

namespace App\Http\Controllers;

use App\Models\UserTaskCompletion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

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
        $recentNotifications = collect();
        $recentShareStatus = collect();

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

            $recentNotifications = $this->buildRecentNotifications($user->id);
            $recentShareStatus = $this->buildRecentShareStatus($user->id);

            return view('home', compact(
                'overviewTaskCompleted',
                'uploadTaskCompleted',
                'libraryTaskCompleted',
                'consentTaskCompleted',
                'accessTaskCompleted',
                'historyTaskCompleted',
                'evaluationTaskCompleted',
                'evaluationReady',
                'recentNotifications',
                'recentShareStatus'
            ));
        }

        return view('admin.home', [
            'user' => $user,
        ]);
    }

    private function buildRecentNotifications(int $userId)
    {
        if (! Schema::hasTable('system_logs')) {
            return collect();
        }

        $actionKeys = [
            'user_gave_consent',
            'user_withdrew_consent',
            'user_added_access_permission',
            'user_revoked_access_permission',
            'save_skin_image',
            'delete_skin_image',
            'soft_delete_skin_image',
            'remove_skin_image',
            'view_skin_image_detail',
        ];

        $query = DB::table('system_logs')
            ->where('user_id', $userId)
            ->whereIn('action_key', $actionKeys)
            ->orderByDesc('id')
            ->limit(3);

        if (Schema::hasColumn('system_logs', 'actor_name')) {
            $query->select('*');
        }

        return $query->get()->map(function ($log) {
            $log->description = $log->description ?? $log->action_label ?? '-';
            $log->actor_name = $log->actor_name ?? '-';
            $log->actor_role = $log->actor_role ?? '-';
            $log->created_at_text = ! empty($log->created_at)
                ? \Illuminate\Support\Carbon::parse($log->created_at)->addYears(543)->format('d/m/y H:i')
                : '-';
            $log->notification_title = $log->description;
            $log->notification_meta = trim(($log->actor_name ?? '-') . ' (' . ($log->actor_role ?? '-') . ') · ' . ($log->created_at_text ?? '-'));
            [$log->notification_icon, $log->notification_color, $log->notification_bg] = match ($log->action_type ?? 'access') {
                'consent' => ['fa-file-circle-check', '#16834d', 'rgba(22, 131, 77, 0.12)'],
                'share' => ['fa-share-from-square', '#c2410c', 'rgba(194, 65, 12, 0.12)'],
                'revoke' => ['fa-user-slash', '#b42318', 'rgba(180, 35, 24, 0.12)'],
                'delete' => ['fa-trash', '#b42318', 'rgba(180, 35, 24, 0.12)'],
                'upload' => ['fa-camera', '#4552d0', 'rgba(69, 82, 208, 0.12)'],
                default => ['fa-bell', '#4552d0', 'rgba(69, 82, 208, 0.12)'],
            };

            return $log;
        });
    }

    private function buildRecentShareStatus(int $userId)
    {
        if (! Schema::hasTable('user_access_permissions')) {
            return collect();
        }

        $query = DB::table('user_access_permissions')
            ->leftJoin('skin_image_records', 'user_access_permissions.image_id', '=', 'skin_image_records.id')
            ->where('user_access_permissions.user_id', $userId)
            ->orderByDesc('user_access_permissions.permission_id')
            ->limit(3)
            ->select([
                'user_access_permissions.permission_id as id',
                'user_access_permissions.permission_id',
                'user_access_permissions.image_id',
                'user_access_permissions.image_group_id',
                'user_access_permissions.grantee_name',
                'user_access_permissions.grantee_role',
                'user_access_permissions.permission_level',
                'user_access_permissions.purpose',
                'user_access_permissions.status',
                'user_access_permissions.created_at',
                'user_access_permissions.revoked_at',
                'skin_image_records.primary_image_path as image_primary_path',
                'skin_image_records.image_paths as image_paths_json',
                'skin_image_records.image_count as image_count',
            ]);

        return $query->get()->map(function ($permission) {
            $paths = json_decode($permission->image_paths_json ?? '[]', true) ?: [];

            $permission->image_label = $permission->image_group_id
                ? 'ชุดข้อมูล #' . $permission->image_group_id
                : ($permission->image_id ? 'ภาพ #' . $permission->image_id : '-');
            $permission->grantee_role_label = match ($permission->grantee_role ?? null) {
                'doctor' => 'แพทย์',
                'researcher' => 'นักวิจัย',
                'other' => 'อื่น ๆ',
                default => '-',
            };
            $permission->status_label = $permission->status === 'active' ? 'กำลังแชร์' : 'ยกเลิกแล้ว';
            $permission->image_total = (int) ($permission->image_count ?? count($paths));
            $permission->image_thumbnail = ! empty($permission->image_primary_path)
                ? Storage::url($permission->image_primary_path)
                : (! empty($paths[0]) ? Storage::url($paths[0]) : null);
            $permission->created_at_text = ! empty($permission->created_at)
                ? \Illuminate\Support\Carbon::parse($permission->created_at)->addYears(543)->format('d/m/y H:i')
                : '-';
            $permission->share_title = trim(($permission->grantee_name ?? '-') . ' · ' . ($permission->grantee_role_label ?? '-'));
            $permission->share_meta = trim(($permission->image_label ?? '-') . ' · ' . ($permission->created_at_text ?? '-'));
            $permission->share_state = $permission->status_label ?? '-';

            return $permission;
        });
    }
}
