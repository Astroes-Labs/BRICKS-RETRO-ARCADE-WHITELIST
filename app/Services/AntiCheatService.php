<?php
// File: app/Services/AntiCheatService.php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class AntiCheatService
{
    public function canPerformAction(User $user, string $action): bool
    {
        $key = "user_action_{$user->id}_{$action}";
        
        if (Cache::has($key)) {
            return false; // Rate limited
        }

        Cache::put($key, true, 5); // 5 second cooldown per action type
        return true;
    }

    public function validateCheckIn(User $user): bool
    {
        if (!$user->canCheckIn()) {
            return false;
        }

        return $this->canPerformAction($user, 'checkin');
    }
}