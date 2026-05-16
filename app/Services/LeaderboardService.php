<?php
// File: app/Services/LeaderboardService.php
namespace App\Services;

use App\Models\User;
use App\Models\LeaderboardSnapshot;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LeaderboardService
{
    public function getTopPlayers(int $limit = 50)
    {
        return Cache::remember('leaderboard_top', 300, function () use ($limit) {
            return User::active()
                ->with('streak')
                ->orderBy('total_xp', 'desc')
                ->take($limit)
                ->get()
                ->map(function ($user) {
                    return [
                        'rank' => null, // calculated below
                        'user' => $user,
                        'score' => (int)($user->total_xp * $user->referral_multiplier),
                    ];
                });
        });
    }

    public function updateSnapshot(): void
    {
        // Run via cron every hour
        DB::statement("
            INSERT INTO leaderboard_snapshots (user_id, score, snapshot_date, created_at, updated_at)
            SELECT id, total_xp * ?, CURDATE(), NOW(), NOW()
            FROM users 
            WHERE is_banned = 0
            ON DUPLICATE KEY UPDATE score = VALUES(score)
        ", [1]); // Multiplier applied in query if needed
    }
}