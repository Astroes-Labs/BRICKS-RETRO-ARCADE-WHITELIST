<?php
// File: app/Policies/RewardPolicy.php
namespace App\Policies;

use App\Models\Reward;
use App\Models\User;

class RewardPolicy
{
    public function claim(User $user, Reward $reward): bool
    {
        return $reward->user_id === $user->id && !$reward->claimed;
    }
}