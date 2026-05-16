<?php
// File: app/Services/RewardService.php
namespace App\Services;

use App\Enums\RewardType;
use App\Models\Reward;
use App\Models\User;
use App\Models\PuzzleFragment;
use Illuminate\Support\Facades\DB;

class RewardService
{
    public function generateRewards(User $user, int $count = 4): array
    {
        $rewards = [];

        for ($i = 0; $i < $count; $i++) {
            $type = $this->weightedRandomRewardType($user);
            
            $data = match ($type) {
                RewardType::PUZZLE_FRAGMENT => $this->generateFragmentData(),
                RewardType::XP => ['amount' => rand(50, 350)],
                RewardType::STREAK_BOOST => ['hours' => rand(2, 6)],
                RewardType::WHITELIST_POINT => ['amount' => rand(1, 3)],
                RewardType::JACKPOT => ['multiplier' => 2.5],
                default => [],
            };

            $rewards[] = [
                'type' => $type->value,
                'data' => $data,
                'hidden' => true,
            ];
        }

        // Shuffle for fairness
        shuffle($rewards);
        return $rewards;
    }

    private function weightedRandomRewardType(User $user): RewardType
    {
        $weights = [
            RewardType::EMPTY->value => 25,
            RewardType::XP->value => 35,
            RewardType::PUZZLE_FRAGMENT->value => 20,
            RewardType::STREAK_BOOST->value => 10,
            RewardType::WHITELIST_POINT->value => 7,
            RewardType::JACKPOT->value => 3,
        ];

        // Streak bonus
        if ($user->streak?->current_streak > 5) {
            $weights[RewardType::PUZZLE_FRAGMENT->value] += 8;
        }

        return RewardType::from(\App\Helpers\RetroHelper::weightedRandom($weights));
    }

    private function generateFragmentData(): array
    {
        $fragment = PuzzleFragment::inRandomOrder()->first();
        return [
            'fragment_id' => $fragment->id,
            'fragment_name' => $fragment->name,
            'set_name' => $fragment->puzzleSet->name,
        ];
    }

    public function claimReward(User $user, Reward $reward): bool
    {
        return DB::transaction(function () use ($user, $reward) {
            if ($reward->claimed || $reward->user_id !== $user->id) {
                return false;
            }

            $reward->update([
                'claimed' => true,
                'claimed_at' => now(),
            ]);

            // Process reward based on type (delegated to handlers)
            $this->processRewardPayload($user, $reward);

            return true;
        });
    }

    private function processRewardPayload(User $user, Reward $reward): void
    {
        // Implementation continues in next files...
    }
}