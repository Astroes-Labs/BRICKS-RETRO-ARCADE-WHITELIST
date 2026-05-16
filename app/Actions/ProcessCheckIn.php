<?php
// File: app/Actions/ProcessCheckIn.php
namespace App\Actions;

use App\Models\User;
use App\Services\StreakService;
use App\Services\RewardService;
use App\Services\AntiCheatService;
use Illuminate\Support\Facades\DB;

class ProcessCheckIn
{
    protected StreakService $streakService;
    protected RewardService $rewardService;
    protected AntiCheatService $antiCheatService;

    public function __construct(
        StreakService $streakService,
        RewardService $rewardService,
        AntiCheatService $antiCheatService
    ) {
        $this->streakService = $streakService;
        $this->rewardService = $rewardService;
        $this->antiCheatService = $antiCheatService;
    }

    public function execute(User $user): array
    {
        if (!$this->antiCheatService->validateCheckIn($user)) {
            throw new \Exception('Check-in not available yet. Please wait 6 hours.');
        }

        return DB::transaction(function () use ($user) {
            // Update last check-in
            $user->update(['last_checkin_at' => now()]);

            // Process streak
            $this->streakService->processCheckIn($user);

            // Generate 4 mystery cards
            $cards = $this->rewardService->generateRewards($user, 4);

            // Log the check-in
            \App\Models\CheckIn::create([
                'user_id' => $user->id,
                'checked_in_at' => now(),
            ]);

            // Give base XP
            $baseXp = 100 + (int)($user->streak?->current_streak ?? 0) * 25;
            $user->increment('total_xp', $baseXp);

            \App\Models\XpLog::create([
                'user_id' => $user->id,
                'amount' => $baseXp,
                'source' => 'checkin',
                'description' => 'Daily Check-in Reward',
            ]);

            return [
                'success' => true,
                'cards' => $cards,
                'streak' => $user->streak->fresh(),
                'total_xp' => $user->total_xp,
            ];
        });
    }
}