<?php
// File: app/Actions/RevealReward.php
namespace App\Actions;

use App\Models\Reward;
use App\Models\User;
use App\Services\RewardService;

class RevealReward
{
    protected RewardService $rewardService;

    public function __construct(RewardService $rewardService)
    {
        $this->rewardService = $rewardService;
    }

    public function execute(User $user, Reward $reward): bool
    {
        return $this->rewardService->claimReward($user, $reward);
    }
}