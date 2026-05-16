<?php
// File: app/Services/ReferralService.php
namespace App\Services;

use App\Models\User;
use App\Models\Referral;
use Illuminate\Support\Facades\DB;

class ReferralService
{
    public function processReferral(User $referrer, User $referee): void
    {
        if ($referrer->id === $referee->id) return;

        DB::transaction(function () use ($referrer, $referee) {
            Referral::create([
                'referrer_id' => $referrer->id,
                'referee_id' => $referee->id,
            ]);

            // Give bonus XP to referrer
            $referrer->increment('total_xp', 150);
        });
    }

    public function getMultiplier(User $user): float
    {
        $count = $user->referrals()->count();
        
        if ($count >= 500) return 2.2;
        if ($count >= 100) return 2.1;
        if ($count >= 50) return 2.0;
        if ($count >= 25) return 1.85;
        if ($count >= 10) return 1.6;
        if ($count >= 5) return 1.45;
        if ($count >= 1) return 1.2;
        return 1.0;
    }
}