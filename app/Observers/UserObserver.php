<?php
// File: app/Observers/UserObserver.php
namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        $user->referral_code = \App\Helpers\RetroHelper::generateReferralCode();
        $user->saveQuietly();

        Streak::create(['user_id' => $user->id]);
    }
}