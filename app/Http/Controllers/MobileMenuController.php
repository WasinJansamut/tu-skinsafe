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
    private const CONSENT_RECORDS_TABLE = 'user_consent_records';
    private const ACCESS_PERMISSIONS_TABLE = 'user_access_permissions';

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

        $payload = [
            'user_id' => $userId,
            'action_key' => $actionKey,
            'action_label' => $actionLabel,
            'page_path' => $pagePath,
            'details' => ! empty($details) ? json_encode($details, JSON_UNESCAPED_UNICODE) : null,
            'created_at' => now(),
        ];

        $actorName = auth()->user()?->name ?? null;
        $actorRole = auth()->user()?->role ?? null;
        $targetType = null;
        $targetId = null;

        foreach (['record_id', 'permission_id', 'target_id'] as $key) {
            if (isset($details[$key])) {
                $targetId = is_numeric($details[$key]) ? (int) $details[$key] : (string) $details[$key];
                $targetType = match ($key) {
                    'record_id' => 'skin_image_record',
                    'permission_id' => 'access_permission',
                    default => 'target',
                };
                break;
            }
        }

        if (Schema::hasColumn('system_logs', 'actor_name')) {
            $payload['actor_name'] = $actorName;
        }

        if (Schema::hasColumn('system_logs', 'actor_role')) {
            $payload['actor_role'] = $actorRole;
        }

        if (Schema::hasColumn('system_logs', 'action_type')) {
            $payload['action_type'] = $this->resolveActionType($actionKey);
        }

        if (Schema::hasColumn('system_logs', 'target_type')) {
            $payload['target_type'] = $targetType;
        }

        if (Schema::hasColumn('system_logs', 'target_id')) {
            $payload['target_id'] = $targetId;
        }

        if (Schema::hasColumn('system_logs', 'description')) {
            $payload['description'] = $actionLabel;
        }

        if (Schema::hasColumn('system_logs', 'is_read')) {
            $payload['is_read'] = 0;
        }

        DB::table('system_logs')->insert($payload);
    }

    private function resolveActionType(string $actionKey): string
    {
        return match ($actionKey) {
            'view_upload_page', 'save_skin_image' => 'upload',
            'edit_skin_image', 'update_skin_image', 'edit_access_permission', 'update_access_permission' => 'edit',
            'delete_skin_image', 'soft_delete_skin_image', 'remove_skin_image' => 'delete',
            'view_consent_page', 'user_gave_consent', 'user_withdrew_consent' => 'consent',
            'user_added_access_permission' => 'share',
            'view_access_page', 'view_skin_image_detail', 'view_library_page', 'view_system_overview', 'complete_system_overview', 'view_notifications_page' => 'access',
            'user_revoked_access_permission' => 'revoke',
            default => 'access',
        };
    }

    private function getConsentRecord(?int $userId): ?object
    {
        if (! $userId || ! Schema::hasTable(self::CONSENT_RECORDS_TABLE)) {
            return null;
        }

        return DB::table(self::CONSENT_RECORDS_TABLE)
            ->where('user_id', $userId)
            ->first();
    }

    private function formatConsentDate(?string $value): ?string
    {
        return $value ? \Illuminate\Support\Carbon::parse($value)->addYears(543)->format('d/m/y H:i') : null;
    }

    private function markConsentTaskCompleted(int $userId): void
    {
        $this->recordTaskCompletion($userId, self::CONSENT_PAGE_TASK_KEY);
    }

    private function revokeActiveSharesIfAny(int $userId): void
    {
        $tablesToCheck = [
            'user_access_permissions',
            'user_share_permissions',
            'user_data_shares',
            'skin_image_shares',
        ];

        foreach ($tablesToCheck as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            $columns = Schema::getColumnListing($table);

            if (! in_array('user_id', $columns, true)) {
                continue;
            }

            if (in_array('is_active', $columns, true)) {
                DB::table($table)
                    ->where('user_id', $userId)
                    ->where('is_active', 1)
                    ->update([
                        'is_active' => 0,
                        'updated_at' => now(),
                    ]);
                continue;
            }

            if (in_array('status', $columns, true)) {
                DB::table($table)
                    ->where('user_id', $userId)
                    ->whereIn('status', ['active', 'shared', 'granted'])
                    ->update([
                        'status' => 'revoked',
                        'updated_at' => now(),
                    ]);

                if ($table === self::ACCESS_PERMISSIONS_TABLE && in_array('revoked_at', $columns, true)) {
                    DB::table($table)
                        ->where('user_id', $userId)
                        ->where('status', 'revoked')
                        ->whereNull('revoked_at')
                        ->update([
                            'revoked_at' => now(),
                            'updated_at' => now(),
                        ]);
                }
            }
        }
    }

    private function revokeSharesForRecordIfAny(int $userId, int $recordId): void
    {
        if (! Schema::hasTable(self::ACCESS_PERMISSIONS_TABLE)) {
            return;
        }

        $columns = Schema::getColumnListing(self::ACCESS_PERMISSIONS_TABLE);
        if (! in_array('image_id', $columns, true)) {
            return;
        }

        $update = ['status' => 'revoked'];
        if (in_array('revoked_at', $columns, true)) {
            $update['revoked_at'] = now();
        }
        if (in_array('updated_at', $columns, true)) {
            $update['updated_at'] = now();
        }

        DB::table(self::ACCESS_PERMISSIONS_TABLE)
            ->where('user_id', $userId)
            ->where('image_id', $recordId)
            ->where('status', 'active')
            ->update($update);
    }

    private function getAccessPermissions(int $userId)
    {
        if (! Schema::hasTable(self::ACCESS_PERMISSIONS_TABLE)) {
            return collect();
        }

        return DB::table(self::ACCESS_PERMISSIONS_TABLE)
            ->leftJoin('skin_image_records', 'user_access_permissions.image_id', '=', 'skin_image_records.id')
            ->where('user_access_permissions.user_id', $userId)
            ->orderByDesc('user_access_permissions.permission_id')
            ->select([
                'user_access_permissions.permission_id as id',
                'user_access_permissions.permission_id',
                'user_access_permissions.user_id',
                'user_access_permissions.image_id',
                'user_access_permissions.image_group_id',
                'user_access_permissions.grantee_name',
                'user_access_permissions.grantee_role',
                'user_access_permissions.permission_level',
                'user_access_permissions.purpose',
                'user_access_permissions.status',
                'user_access_permissions.created_at',
                'user_access_permissions.revoked_at',
                'user_access_permissions.updated_at',
                'skin_image_records.primary_image_path as image_primary_path',
                'skin_image_records.image_paths as image_paths_json',
                'skin_image_records.image_count as image_count',
                'skin_image_records.created_at as image_created_at',
            ])
            ->get()
            ->map(function ($permission) {
                $paths = json_decode($permission->image_paths_json ?? '[]', true) ?: [];

                $permission->image_label = $permission->image_group_id
                    ? 'ชุดข้อมูล #' . $permission->image_group_id
                    : ($permission->image_id ? 'ภาพ #' . $permission->image_id : '-');
                $permission->grantee_role_label = $this->formatRoleLabel($permission->grantee_role ?? null);
                $permission->status_label = $permission->status === 'active' ? 'active' : 'revoked';
                $permission->permission_level_label = $permission->permission_level === 'view_only'
                    ? 'View Only'
                    : (string) ($permission->permission_level ?? '-');
                $permission->image_total = (int) ($permission->image_count ?? count($paths));
                $permission->image_thumbnail = ! empty($permission->image_primary_path)
                    ? Storage::url($permission->image_primary_path)
                    : (! empty($paths[0]) ? Storage::url($paths[0]) : null);
                $permission->created_at_text = ! empty($permission->created_at)
                    ? \Illuminate\Support\Carbon::parse($permission->created_at)->addYears(543)->format('d/m/y H:i')
                    : '-';
                $permission->revoked_at_text = ! empty($permission->revoked_at)
                    ? \Illuminate\Support\Carbon::parse($permission->revoked_at)->addYears(543)->format('d/m/y H:i')
                    : null;

                return $permission;
            });
    }

    private function getRecordActivityLogs(int $userId, int $recordId)
    {
        if (! Schema::hasTable('system_logs')) {
            return collect();
        }

        $query = DB::table('system_logs')
            ->where('user_id', $userId)
            ->orderByDesc('id');

        if (Schema::hasColumn('system_logs', 'target_type') && Schema::hasColumn('system_logs', 'target_id')) {
            $query->where('target_type', 'skin_image_record')->where('target_id', $recordId);
        } elseif (Schema::hasColumn('system_logs', 'details')) {
            $query->where(function ($nested) use ($recordId) {
                $nested->where('details', 'like', '%"record_id":' . $recordId . '%')
                    ->orWhere('details', 'like', '%"target_id":' . $recordId . '%');
            });
        }

        if (Schema::hasColumn('system_logs', 'action_type')) {
            $query->select('*');
        }

        return $query->limit(5)->get()->map(fn($log) => $this->prepareActivityLog($log));
    }

    private function getImageShareSummary(int $userId, int $recordId): array
    {
        if (! Schema::hasTable(self::ACCESS_PERMISSIONS_TABLE)) {
            return [
                'label' => 'ยังไม่แชร์',
                'class' => 'is-warning',
                'active_count' => 0,
                'total_count' => 0,
            ];
        }

        $permissions = DB::table(self::ACCESS_PERMISSIONS_TABLE)
            ->where('user_id', $userId)
            ->where('image_id', $recordId)
            ->get(['status']);

        $totalCount = $permissions->count();
        $activeCount = $permissions->where('status', 'active')->count();

        return [
            'label' => $activeCount > 0 ? 'แชร์แล้ว' : 'ยังไม่แชร์',
            'class' => $activeCount > 0 ? 'is-shared' : 'is-warning',
            'active_count' => $activeCount,
            'total_count' => $totalCount,
        ];
    }

    private function getImageShareSummaryMap(int $userId): array
    {
        if (! Schema::hasTable(self::ACCESS_PERMISSIONS_TABLE)) {
            return [];
        }

        $summary = [];

        DB::table(self::ACCESS_PERMISSIONS_TABLE)
            ->where('user_id', $userId)
            ->whereNotNull('image_id')
            ->get(['image_id', 'status'])
            ->each(function ($permission) use (&$summary) {
                $imageId = (int) $permission->image_id;
                if (! isset($summary[$imageId])) {
                    $summary[$imageId] = [
                        'label' => 'ยังไม่แชร์',
                        'class' => 'is-warning',
                        'active_count' => 0,
                        'total_count' => 0,
                    ];
                }

                $summary[$imageId]['total_count']++;
                if (($permission->status ?? null) === 'active') {
                    $summary[$imageId]['active_count']++;
                }
            });

        foreach ($summary as $imageId => $item) {
            $summary[$imageId]['label'] = $item['active_count'] > 0 ? 'แชร์แล้ว' : 'ยังไม่แชร์';
            $summary[$imageId]['class'] = $item['active_count'] > 0 ? 'is-shared' : 'is-warning';
        }

        return $summary;
    }

    private function formatRoleLabel(?string $role): string
    {
        return match ($role) {
            'doctor' => 'แพทย์',
            'researcher' => 'นักวิจัย',
            'other' => 'อื่น ๆ',
            default => '-',
        };
    }

    private function markAccessTaskCompleted(int $userId): void
    {
        $this->recordTaskCompletion($userId, self::ACCESS_PAGE_TASK_KEY);
    }

    private function activityTypeLabels(): array
    {
        return [
            'upload' => 'Upload',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'consent' => 'Consent',
            'share' => 'Share',
            'access' => 'Access',
            'revoke' => 'Revoke',
        ];
    }

    private function activityActionKeysByType(string $type): array
    {
        return match ($type) {
            'upload' => ['view_upload_page', 'save_skin_image'],
            'edit' => ['edit_skin_image', 'update_skin_image', 'edit_access_permission', 'update_access_permission'],
            'delete' => ['delete_skin_image', 'soft_delete_skin_image', 'remove_skin_image'],
            'consent' => ['view_consent_page', 'user_gave_consent', 'user_withdrew_consent'],
            'share' => ['user_added_access_permission'],
            'access' => ['view_access_page', 'view_skin_image_detail', 'view_library_page', 'view_system_overview', 'complete_system_overview', 'view_notifications_page'],
            'revoke' => ['user_revoked_access_permission'],
            default => [],
        };
    }

    private function activityLogLabel(string $actionKey, ?array $details = null): string
    {
        return match ($actionKey) {
            'view_upload_page' => 'เปิดหน้าถ่าย/อัปโหลดภาพ',
            'save_skin_image' => 'คุณได้บันทึกภาพใหม่',
            'view_system_overview' => 'เปิดหน้าแนะนำภาพรวมของระบบต้นแบบ',
            'complete_system_overview' => 'รับทราบและบันทึกขั้นแนะนำภาพรวมของระบบต้นแบบ',
            'view_consent_page' => 'เปิดหน้าการยินยอมและการแชร์ข้อมูล',
            'user_gave_consent' => 'คุณได้ให้ความยินยอมในการใช้ข้อมูล',
            'user_withdrew_consent' => 'คุณได้ถอนความยินยอม',
            'view_access_page' => 'เปิดหน้าสิทธิ์การเข้าถึงข้อมูล',
            'user_added_access_permission' => 'คุณได้แชร์ภาพให้แพทย์',
            'user_revoked_access_permission' => 'คุณได้ยกเลิกสิทธิ์การเข้าถึง',
            'view_library_page' => 'เปิดหน้าคลังภาพของฉัน',
            'view_skin_image_detail' => 'เปิดดูรายละเอียดรายการภาพ',
            'view_history_page' => 'เปิดหน้าประวัติการเข้าถึงและการแจ้งเตือน',
            default => $actionKey,
        };
    }

    private function prepareActivityLog(object $log): object
    {
        $details = [];
        if (! empty($log->details)) {
            $decoded = json_decode((string) $log->details, true);
            $details = is_array($decoded) ? $decoded : [];
        }

        $log->details_array = $details;
        $log->actor_name = $log->actor_name ?? auth()->user()?->name ?? '-';
        $log->actor_role = $log->actor_role ?? auth()->user()?->role ?? '-';
        $log->action_type = $log->action_type ?? $this->resolveActionType($log->action_key ?? '');
        $log->description = $log->description ?? $log->action_label ?? $this->activityLogLabel($log->action_key ?? '', $details);
        $targetType = $log->target_type ?? ($details['target_type'] ?? null);
        if (! $targetType && (isset($details['record_id']) || isset($details['permission_id']) || isset($details['target_id']))) {
            $targetType = 'target';
        }
        $log->target_type = $targetType;
        $log->target_id = $log->target_id ?? $details['record_id'] ?? $details['permission_id'] ?? $details['target_id'] ?? null;
        $log->target_label = match ($log->target_type) {
            'skin_image_record' => $log->target_id ? 'ภาพ #' . $log->target_id : 'ภาพ',
            'access_permission' => $log->target_id ? 'สิทธิ์ #' . $log->target_id : 'สิทธิ์',
            default => $log->target_id ? 'รายการ #' . $log->target_id : null,
        };
        $log->is_read = (bool) ($log->is_read ?? 0);
        $log->created_at_text = ! empty($log->created_at)
            ? \Illuminate\Support\Carbon::parse($log->created_at)->addYears(543)->format('d/m/y H:i')
            : '-';

        return $log;
    }

    private function buildActivityLogsQuery(int $userId)
    {
        $query = DB::table('system_logs')
            ->where('user_id', $userId)
            ->orderByDesc('id');

        if (Schema::hasColumn('system_logs', 'action_type')) {
            $query->select('*');
        } else {
            $query->select([
                'id',
                'user_id',
                'action_key',
                'action_label',
                'page_path',
                'details',
                'created_at',
            ]);
        }

        return $query;
    }

    private function activityNotificationActionKeys(): array
    {
        return [
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
        $shareSummaryMap = $this->getImageShareSummaryMap($user->id);

        if (Schema::hasTable('skin_image_records')) {
            $records = DB::table('skin_image_records')
                ->where('user_id', $user->id)
                ->when(Schema::hasColumn('skin_image_records', 'deleted_at'), function ($query) {
                    $query->whereNull('deleted_at');
                })
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
                    $record->share_status_label = $shareSummaryMap[$record->id]['label'] ?? 'ยังไม่แชร์';
                    $record->share_status_class = $shareSummaryMap[$record->id]['class'] ?? 'is-warning';
                    $record->share_active_count = $shareSummaryMap[$record->id]['active_count'] ?? 0;
                    $record->share_total_count = $shareSummaryMap[$record->id]['total_count'] ?? 0;

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
            ->when(Schema::hasColumn('skin_image_records', 'deleted_at'), function ($query) {
                $query->whereNull('deleted_at');
            })
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
        $shareSummary = $this->getImageShareSummary($user->id, (int) $record->id);
        $record->share_status_label = $shareSummary['label'];
        $record->share_status_class = $shareSummary['class'];
        $record->share_active_count = $shareSummary['active_count'];
        $record->share_total_count = $shareSummary['total_count'];

        $this->writeLog($user->id, 'view_skin_image_detail', 'เปิดดูรายละเอียดรายการภาพผิวหนัง', '/app/library/' . $record->id, [
            'record_id' => $record->id,
        ]);
        $this->recordTaskCompletion($user->id, self::LIBRARY_DETAIL_TASK_KEY);
        $recordLogs = $this->getRecordActivityLogs($user->id, (int) $record->id);

        return view('mobile.library_show', [
            'page_title' => 'รายละเอียดรายการภาพ',
            'record' => $record,
            'recordLogs' => $recordLogs,
        ]);
    }

    public function editLibrary(int $id)
    {
        $user = auth()->user();

        if (! Schema::hasTable('skin_image_records')) {
            abort(404);
        }

        $record = DB::table('skin_image_records')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->when(Schema::hasColumn('skin_image_records', 'deleted_at'), function ($query) {
                $query->whereNull('deleted_at');
            })
            ->first();

        if (! $record) {
            abort(404);
        }

        $paths = json_decode($record->image_paths ?? '[]', true) ?: [];
        $record->paths = $paths;
        $record->thumbnail_url = ! empty($record->primary_image_path)
            ? Storage::url($record->primary_image_path)
            : (! empty($paths[0]) ? Storage::url($paths[0]) : null);
        $record->created_at_text = ! empty($record->created_at)
            ? \Illuminate\Support\Carbon::parse($record->created_at)->addYears(543)->format('d/m/y H:i')
            : '-';
        $record->updated_at_text = ! empty($record->updated_at)
            ? \Illuminate\Support\Carbon::parse($record->updated_at)->addYears(543)->format('d/m/y H:i')
            : '-';
        $shareSummary = $this->getImageShareSummary($user->id, (int) $record->id);
        $record->share_status_label = $shareSummary['label'];
        $record->share_status_class = $shareSummary['class'];
        $record->share_active_count = $shareSummary['active_count'];

        $this->writeLog($user->id, 'edit_skin_image', 'เปิดหน้าแก้ไขข้อมูลภาพ', '/app/library/' . $record->id . '/edit', [
            'record_id' => $record->id,
        ]);

        return view('mobile.library_edit', [
            'page_title' => 'แก้ไขข้อมูลภาพ',
            'record' => $record,
        ]);
    }

    public function updateLibrary(Request $request, int $id)
    {
        $user = $request->user();

        if (! Schema::hasTable('skin_image_records')) {
            abort(404);
        }

        $record = DB::table('skin_image_records')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->when(Schema::hasColumn('skin_image_records', 'deleted_at'), function ($query) {
                $query->whereNull('deleted_at');
            })
            ->first();

        if (! $record) {
            abort(404);
        }

        $validated = $request->validate([
            'symptoms' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::table('skin_image_records')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->update([
                'symptoms' => $validated['symptoms'],
                'location' => $validated['location'],
                'notes' => $validated['notes'] ?? null,
                'updated_at' => now(),
            ]);

        $this->writeLog($user->id, 'edit_skin_image', 'ผู้ใช้แก้ไขข้อมูลภาพ', '/app/library/' . $id . '/edit', [
            'record_id' => $id,
        ]);

        return redirect()
            ->route('app.library.show', $id)
            ->with('success', 'แก้ไขข้อมูลภาพเรียบร้อยแล้ว');
    }

    public function destroyLibrary(Request $request, int $id)
    {
        $user = $request->user();

        if (! Schema::hasTable('skin_image_records')) {
            abort(404);
        }

        $record = DB::table('skin_image_records')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->when(Schema::hasColumn('skin_image_records', 'deleted_at'), function ($query) {
                $query->whereNull('deleted_at');
            })
            ->first();

        if (! $record) {
            abort(404);
        }

        $shareSummary = $this->getImageShareSummary($user->id, (int) $id);

        $update = [];
        if (Schema::hasColumn('skin_image_records', 'deleted_at')) {
            $update['deleted_at'] = now();
        } elseif (Schema::hasColumn('skin_image_records', 'is_deleted')) {
            $update['is_deleted'] = 1;
        } elseif (Schema::hasColumn('skin_image_records', 'status')) {
            $update['status'] = 'deleted';
        } else {
            abort(500, 'ยังไม่ได้เตรียมฟิลด์สำหรับลบภาพแบบ soft delete');
        }

        $update['updated_at'] = now();

        DB::table('skin_image_records')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->update($update);

        if ($shareSummary['active_count'] > 0) {
            $this->revokeSharesForRecordIfAny($user->id, $id);
        }

        $this->writeLog($user->id, 'delete_skin_image', 'ผู้ใช้ลบภาพ', '/app/library/' . $id, [
            'record_id' => $id,
            'shared_before_delete' => $shareSummary['active_count'] > 0 ? 1 : 0,
        ]);

        return redirect()
            ->route('app.library')
            ->with('success', 'ลบภาพเรียบร้อยแล้ว');
    }

    public function consent()
    {
        $user = auth()->user();
        $consentRecord = $this->getConsentRecord($user->id);
        $this->writeLog($user->id, 'view_consent_page', 'เปิดหน้าการยินยอมและการแชร์ข้อมูล', '/app/consent');
        $this->markConsentTaskCompleted($user->id);

        $status = 'not_given';
        if ($consentRecord?->consent_status === 'consented') {
            $status = 'consented';
        } elseif ($consentRecord?->consent_status === 'withdrawn') {
            $status = 'withdrawn';
        }

        return view('mobile.consent', [
            'page_title' => 'การยินยอมและการแชร์ข้อมูล',
            'consentRecord' => $consentRecord,
            'consentStatus' => $status,
            'consentGivenAtText' => $this->formatConsentDate($consentRecord?->consent_given_at ?? null),
            'consentWithdrawnAtText' => $this->formatConsentDate($consentRecord?->consent_withdrawn_at ?? null),
        ]);
    }

    public function storeConsent(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'consent_storage' => ['accepted'],
            'consent_treatment' => ['accepted'],
            'consent_doctor' => ['accepted'],
            'consent_research' => ['nullable'],
            'consent_note' => ['nullable', 'string', 'max:2000'],
        ]);

        if (! Schema::hasTable(self::CONSENT_RECORDS_TABLE)) {
            abort(500, 'ยังไม่ได้สร้างตาราง user_consent_records');
        }

        DB::table(self::CONSENT_RECORDS_TABLE)->updateOrInsert(
            ['user_id' => $user->id],
            [
                'consent_storage' => 1,
                'consent_treatment' => 1,
                'consent_research' => $request->boolean('consent_research') ? 1 : 0,
                'consent_status' => 'consented',
                'consent_given_at' => now(),
                'consent_withdrawn_at' => null,
                'consent_note' => $validated['consent_note'] ?? null,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $this->markConsentTaskCompleted($user->id);
        $this->writeLog($user->id, 'user_gave_consent', 'ผู้ใช้ให้ความยินยอม', '/app/consent', [
            'consent_storage' => 1,
            'consent_treatment' => 1,
            'consent_research' => $request->boolean('consent_research') ? 1 : 0,
        ]);

        return redirect()
            ->route('app.consent')
            ->with('success', 'บันทึกความยินยอมเรียบร้อยแล้ว');
    }

    public function withdrawConsent(Request $request)
    {
        $user = $request->user();

        if (! Schema::hasTable(self::CONSENT_RECORDS_TABLE)) {
            abort(500, 'ยังไม่ได้สร้างตาราง user_consent_records');
        }

        $existing = $this->getConsentRecord($user->id);

        DB::table(self::CONSENT_RECORDS_TABLE)->updateOrInsert(
            ['user_id' => $user->id],
            [
                'consent_storage' => $existing?->consent_storage ?? 0,
                'consent_treatment' => $existing?->consent_treatment ?? 0,
                'consent_research' => $existing?->consent_research ?? 0,
                'consent_status' => 'withdrawn',
                'consent_given_at' => $existing?->consent_given_at ?? null,
                'consent_withdrawn_at' => now(),
                'consent_note' => $request->input('consent_note', $existing?->consent_note),
                'updated_at' => now(),
                'created_at' => $existing?->created_at ?? now(),
            ]
        );

        $this->revokeActiveSharesIfAny($user->id);
        $this->markConsentTaskCompleted($user->id);
        $this->writeLog($user->id, 'user_withdrew_consent', 'ผู้ใช้ถอนความยินยอม', '/app/consent');

        return redirect()
            ->route('app.consent')
            ->with('success', 'ถอนความยินยอมเรียบร้อยแล้ว');
    }

    public function access()
    {
        $user = auth()->user();
        $permissions = $this->getAccessPermissions($user->id);

        $this->writeLog($user->id, 'view_access_page', 'เปิดหน้าสิทธิ์การเข้าถึงข้อมูล', '/app/access');

        $currentConsent = $this->getConsentRecord($user->id);
        $consentStatus = $currentConsent?->consent_status ?? 'not_given';

        $selectedPurpose = request()->query('purpose', 'doctor');
        if (! in_array($selectedPurpose, ['doctor', 'research'], true)) {
            $selectedPurpose = 'doctor';
        }

        $availableImages = collect();
        if (Schema::hasTable('skin_image_records')) {
            $availableImages = DB::table('skin_image_records')
                ->where('user_id', $user->id)
                ->when(Schema::hasColumn('skin_image_records', 'deleted_at'), function ($query) {
                    $query->whereNull('deleted_at');
                })
                ->orderByDesc('id')
                ->get()
                ->map(function ($record) {
                    $paths = json_decode($record->image_paths ?? '[]', true) ?: [];
                    $record->display_label = 'ภาพ #' . $record->id
                        . (! empty($record->symptoms) ? ' - ' . $record->symptoms : '');
                    $record->created_at_text = ! empty($record->created_at)
                        ? \Illuminate\Support\Carbon::parse($record->created_at)->addYears(543)->format('d/m/y H:i')
                        : '-';
                    $record->thumbnail_url = ! empty($record->primary_image_path)
                        ? Storage::url($record->primary_image_path)
                        : (! empty($paths[0]) ? Storage::url($paths[0]) : null);
                    return $record;
                });
        }

        return view('mobile.access', [
            'page_title' => 'สิทธิ์การเข้าถึงข้อมูล',
            'consentStatus' => $consentStatus,
            'currentConsent' => $currentConsent,
            'permissions' => $permissions,
            'availableImages' => $availableImages,
            'selectedPurpose' => $selectedPurpose,
        ]);
    }

    public function storeAccess(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'image_id' => ['required', 'integer'],
            'grantee_name' => ['required', 'string', 'max:255'],
            'grantee_role' => ['required', 'in:doctor,researcher,other'],
            'purpose' => ['required', 'string', 'max:500'],
            'permission_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $consentRecord = $this->getConsentRecord($user->id);
        if (! $consentRecord || $consentRecord->consent_status !== 'consented') {
            return redirect()
                ->route('app.access')
                ->with('error', 'กรุณาให้ความยินยอมก่อนกำหนดสิทธิ์การเข้าถึงข้อมูล');
        }

        if (! Schema::hasTable(self::ACCESS_PERMISSIONS_TABLE)) {
            abort(500, 'ยังไม่ได้สร้างตาราง user_access_permissions');
        }

        if (! Schema::hasTable('skin_image_records')) {
            abort(500, 'ยังไม่ได้สร้างตาราง skin_image_records');
        }

        $recordExists = DB::table('skin_image_records')
            ->where('id', $validated['image_id'])
            ->where('user_id', $user->id)
            ->when(Schema::hasColumn('skin_image_records', 'deleted_at'), function ($query) {
                $query->whereNull('deleted_at');
            })
            ->exists();

        if (! $recordExists) {
            return redirect()
                ->route('app.access')
                ->with('error', 'ไม่พบภาพที่เลือก หรือไม่ใช่รายการของคุณ');
        }

        DB::table(self::ACCESS_PERMISSIONS_TABLE)->insert([
            'user_id' => $user->id,
            'image_id' => $validated['image_id'],
            'image_group_id' => null,
            'grantee_name' => $validated['grantee_name'],
            'grantee_role' => $validated['grantee_role'],
            'permission_level' => 'view_only',
            'purpose' => $validated['purpose'],
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->markAccessTaskCompleted($user->id);
        $this->writeLog($user->id, 'user_added_access_permission', 'ผู้ใช้กำหนดสิทธิ์การเข้าถึง', '/app/access', [
            'image_id' => (int) $validated['image_id'],
            'grantee_name' => $validated['grantee_name'],
            'grantee_role' => $validated['grantee_role'],
            'permission_level' => 'view_only',
        ]);

        return redirect()
            ->route('app.access')
            ->with('success', 'บันทึกสิทธิ์การเข้าถึงเรียบร้อยแล้ว');
    }

    public function revokeAccess(Request $request, int $id)
    {
        $user = $request->user();

        if (! Schema::hasTable(self::ACCESS_PERMISSIONS_TABLE)) {
            abort(500, 'ยังไม่ได้สร้างตาราง user_access_permissions');
        }

        $permission = DB::table(self::ACCESS_PERMISSIONS_TABLE)
            ->where('permission_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (! $permission) {
            abort(404);
        }

        DB::table(self::ACCESS_PERMISSIONS_TABLE)
            ->where('permission_id', $id)
            ->where('user_id', $user->id)
            ->update([
                'status' => 'revoked',
                'revoked_at' => now(),
                'updated_at' => now(),
            ]);

        $this->markAccessTaskCompleted($user->id);
        $this->writeLog($user->id, 'user_revoked_access_permission', 'ผู้ใช้ยกเลิกสิทธิ์การเข้าถึง', '/app/access', [
            'permission_id' => $id,
        ]);

        return redirect()
            ->route('app.access')
            ->with('success', 'ยกเลิกสิทธิ์เรียบร้อยแล้ว');
    }

    public function history(Request $request)
    {
        $user = auth()->user();
        $this->writeLog($user->id, 'view_history_page', 'เปิดหน้าประวัติการเข้าถึงและการแจ้งเตือน', '/app/history');
        $this->recordTaskCompletion($user->id, self::HISTORY_PAGE_TASK_KEY);

        $filter = (string) $request->query('filter', 'all');
        $from = $request->query('from');
        $to = $request->query('to');
        $allowedFilters = array_keys($this->activityTypeLabels());
        if (! in_array($filter, array_merge(['all'], $allowedFilters), true)) {
            $filter = 'all';
        }

        $query = $this->buildActivityLogsQuery($user->id);

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        if ($filter !== 'all') {
            $query->whereIn('action_key', $this->activityActionKeysByType($filter));
        }

        $unreadCountQuery = clone $query;
        $unreadCount = Schema::hasColumn('system_logs', 'is_read')
            ? (clone $unreadCountQuery)->where(function ($nested) {
                $nested->whereNull('is_read')->orWhere('is_read', 0);
            })->count()
            : (clone $unreadCountQuery)->count();

        $logs = $query->paginate(15)->through(fn($log) => $this->prepareActivityLog($log));

        return view('mobile.history', [
            'page_title' => 'ประวัติการเข้าถึงและการแจ้งเตือน',
            'logs' => $logs,
            'filter' => $filter,
            'from' => $from,
            'to' => $to,
            'filterLabels' => $this->activityTypeLabels(),
            'unreadCount' => $unreadCount,
        ]);
    }

    public function showHistory(int $id)
    {
        $user = auth()->user();

        $log = DB::table('system_logs')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        abort_unless($log, 404);

        $log = $this->prepareActivityLog($log);

        if (Schema::hasColumn('system_logs', 'is_read') && ! $log->is_read) {
            $update = ['is_read' => 1];
            if (Schema::hasColumn('system_logs', 'updated_at')) {
                $update['updated_at'] = now();
            }

            DB::table('system_logs')
                ->where('id', $id)
                ->where('user_id', $user->id)
                ->update($update);
        }

        return view('mobile.history_show', [
            'page_title' => 'รายละเอียดประวัติ',
            'log' => $log,
        ]);
    }

    public function notifications(Request $request)
    {
        $user = auth()->user();
        $this->writeLog($user->id, 'view_notifications_page', 'เปิดหน้าการแจ้งเตือน', '/app/notifications');

        $query = $this->buildActivityLogsQuery($user->id)
            ->whereIn('action_key', $this->activityNotificationActionKeys());

        $notifications = $query->paginate(10)->through(fn($log) => $this->prepareActivityLog($log));

        $unreadCountQuery = DB::table('system_logs')
            ->where('user_id', $user->id)
            ->whereIn('action_key', $this->activityNotificationActionKeys());

        if (Schema::hasColumn('system_logs', 'is_read')) {
            $unreadCount = (clone $unreadCountQuery)->where(function ($query) {
                $query->whereNull('is_read')->orWhere('is_read', 0);
            })->count();
        } else {
            $unreadCount = $notifications->total();
        }

        $this->recordTaskCompletion($user->id, self::HISTORY_PAGE_TASK_KEY);

        return view('mobile.notifications', [
            'page_title' => 'การแจ้งเตือน',
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function markNotificationRead(int $id)
    {
        $user = auth()->user();

        if (! Schema::hasColumn('system_logs', 'is_read')) {
            return redirect()->route('app.notifications');
        }

        $update = ['is_read' => 1];
        if (Schema::hasColumn('system_logs', 'updated_at')) {
            $update['updated_at'] = now();
        }

        DB::table('system_logs')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->update($update);

        return redirect()->route('app.notifications')->with('success', 'ทำเครื่องหมายว่าอ่านแล้ว');
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
        $evaluationResponse = null;
        $evaluationSummary = [
            'scale_average' => null,
            'scale_total' => 0,
        ];

        if ($completed && Schema::hasTable('system_evaluation_responses')) {
            $evaluationResponse = DB::table('system_evaluation_responses')
                ->where('user_id', $user->id)
                ->first();

            if ($evaluationResponse) {
                $evaluationResponse->general_answers = json_decode($evaluationResponse->general_answers_json ?? '{}', true) ?: [];
                $evaluationResponse->scale_answers = json_decode($evaluationResponse->scale_answers_json ?? '[]', true) ?: [];
                $evaluationResponse->open_answers = json_decode($evaluationResponse->open_answers_json ?? '{}', true) ?: [];

                $scaleValues = array_values(array_filter($evaluationResponse->scale_answers, fn($value) => is_numeric($value)));
                $evaluationSummary['scale_total'] = count($scaleValues);
                $evaluationSummary['scale_average'] = ! empty($scaleValues)
                    ? round(array_sum($scaleValues) / count($scaleValues), 2)
                    : null;
            }
        }

        $this->writeLog($user->id, 'view_evaluation_page', 'เปิดหน้าแบบประเมินผลการใช้งานระบบต้นแบบ', '/app/evaluation');

        return view('mobile.evaluation', [
            'page_title' => 'แบบประเมินผลการใช้งานระบบต้นแบบ',
            'ready' => $ready,
            'completed' => $completed,
            'evaluationResponse' => $evaluationResponse,
            'evaluationSummary' => $evaluationSummary,
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
                    'title' => 'จริยธรรมการวิจัย',
                    'meta' => 'ผู้วิจัยได้ผ่านการอบรมจริยธรรมการวิจัยในมนุษย์แล้ว',
                    'icon' => 'fa-shield-heart',
                    'color' => '#16834d',
                    'bg' => 'rgba(34, 197, 94, 0.16)',
                    'image_url' => asset('assets/images/about/ethics-training-certificate.jpg'),
                    'image_alt' => 'ใบรับรองการอบรมจริยธรรมการวิจัย',
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
                    'phone_url' => 'tel:0800808714',
                    'phone_label' => 'กดโทร',
                ],
                [
                    'title' => 'อีเมล',
                    'meta' => 'wasin.jan@dome.tu.ac.th',
                    'icon' => 'fa-envelope',
                    'color' => '#c2410c',
                    'bg' => 'rgba(251, 191, 36, 0.18)',
                    'email_url' => 'mailto:wasin.jan@dome.tu.ac.th',
                    'email_label' => 'ส่ง',
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
            'video_url' => asset('assets/images/pro/plugins/tutor.mp4'),
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

    public function shares()
    {
        $user = auth()->user();
        $permissions = $this->getAccessPermissions($user->id)->take(5)->map(function ($permission) {
            return [
                'title' => trim(($permission->grantee_name ?? '-') . ' · ' . ($permission->grantee_role_label ?? '-')),
                'meta' => trim(($permission->image_label ?? '-') . ' · ' . ($permission->created_at_text ?? '-')),
                'state' => $permission->status_label ?? '-',
                'state_class' => ($permission->status ?? '') === 'active' ? '' : 'is-revoked',
                'icon' => $permission->status === 'active' ? 'fa-share-nodes' : 'fa-user-slash',
                'bg' => $permission->status === 'active' ? 'rgba(69, 82, 208, 0.10)' : 'rgba(194, 65, 12, 0.12)',
                'color' => $permission->status === 'active' ? '#4552d0' : '#c2410c',
            ];
        });

        return $this->page([
            'page_title' => 'สถานะการแชร์ข้อมูล',
            'page_icon' => 'fa-share-nodes',
            'page_subtitle' => 'รายการการแชร์ข้อมูลล่าสุด',
            'hero_title' => 'สถานะการแชร์ข้อมูล',
            'hero_text' => 'แสดงผู้รับข้อมูลและสถานะการแชร์ที่บันทึกไว้จริง',
            'primary_label' => 'กำหนดสิทธิ์',
            'primary_url' => route('app.access'),
            'items' => $permissions,
        ]);
    }
}
