<?php
// File: app/Services/StreakService.php
namespace App\Services;

use App\Models\User;
use App\Models\Streak;
use Illuminate\Support\Facades\DB;

class StreakService
{
    public function processCheckIn(User $user): void
    {
        DB::transaction(function () use ($user) {
            $streak = $user->streak ?? Streak::create(['user_id' => $user->id]);

            $hoursSinceLast = $user->last_checkin_at 
                ? $user->last_checkin_at->diffInHours(now()) 
                : 999;

            if ($hoursSinceLast < 12) {
                $streak->increment('current_streak');
                if ($streak->current_streak > $streak->longest_streak) {
                    $streak->longest_streak = $streak->current_streak;
                }
            } else {
                $streak->current_streak = 1;
                $streak->streak_broken_at = now();
            }

            $streak->last_checkin_at = now();
            $streak->save();
        });
    }

    public function getStreakMultiplier(User $user): float
    {
        $streak = $user->streak;
        if (!$streak) return 1.0;

        return min(1 + ($streak->current_streak * 0.08), 2.5); // Max 2.5x
    }
}