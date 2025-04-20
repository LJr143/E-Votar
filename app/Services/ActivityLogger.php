<?php
namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(
        string $action,
        string $description,
        ?Model $model = null,
        array $data = [],
        ?int $impersonatorId = null
    ): ActivityLog {
        $userId = Auth::id();
        $performedBy = null;
        $roleNames = [];
        $permissionNames = [];

        if ($userId) {
            $performedBy = User::with(['roles', 'permissions'])->find($userId);

            // Get role and permission names safely
            if ($performedBy) {
                $roleNames = $performedBy->getRoleNames()->toArray();
                $permissionNames = $performedBy->getPermissionNames()->toArray();
            }
        }

        return ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'data' => array_merge($data, [
                'performed_by' => $performedBy ? [
                    'id' => $performedBy->id,
                    'name' => $performedBy->name,
                    'email' => $performedBy->email,
                    'roles' => $roleNames,
                    'permissions' => $permissionNames
                ] : null,
                'impersonator_id' => $impersonatorId,
                'ip_details' => [
                    'ip' => Request::ip(),
                    'forwarded_for' => Request::header('X-Forwarded-For'),
                    'user_agent' => Request::header('User-Agent'),
                    'device' => self::parseUserAgent(Request::header('User-Agent'))
                ]
            ]),
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
            'is_system_action' => is_null($userId) && is_null($impersonatorId)
        ]);
    }

    protected static function parseUserAgent(?string $userAgent): array
    {
        if (!$userAgent) {
            return ['type' => 'unknown'];
        }

        return [
            'type' => str_contains($userAgent, 'Mobile') ? 'mobile' : 'desktop',
            'browser' => self::getBrowser($userAgent),
            'os' => self::getOS($userAgent)
        ];
    }

    protected static function getBrowser(string $userAgent): string
    {
        $userAgent = strtolower($userAgent);

        if (strpos($userAgent, 'msie') !== false || strpos($userAgent, 'trident') !== false) return 'Internet Explorer';
        if (strpos($userAgent, 'edg') !== false) return 'Edge';
        if (strpos($userAgent, 'brave') !== false) return 'Brave';
        if (strpos($userAgent, 'tor') !== false || strpos($userAgent, 'tbb') !== false) return 'Tor Browser';
        if (strpos($userAgent, 'firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'chrome') !== false && strpos($userAgent, 'edg') === false && strpos($userAgent, 'brave') === false) return 'Chrome';
        if ((strpos($userAgent, 'safari') !== false && strpos($userAgent, 'chrome') === false) ||
            strpos($userAgent, 'iphone') !== false ||
            strpos($userAgent, 'ipad') !== false ||
            strpos($userAgent, 'macintosh') !== false) return 'Safari / Apple Browser';

        return 'Unknown';
    }



    protected static function getOS(string $userAgent): string
    {
        if (strpos($userAgent, 'Windows') !== false) return 'Windows';
        if (strpos($userAgent, 'Mac') !== false) return 'MacOS';
        if (strpos($userAgent, 'Linux') !== false) return 'Linux';
        if (strpos($userAgent, 'Android') !== false) return 'Android';
        if (strpos($userAgent, 'iOS') !== false) return 'iOS';
        return 'Unknown';
    }
}
