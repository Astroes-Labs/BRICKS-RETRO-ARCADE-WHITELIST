<?php
// File: app/Actions/CalculateReferralMultiplier.php
namespace App\Actions;

use App\Models\User;
use App\Services\ReferralService;

class CalculateReferralMultiplier
{
    protected ReferralService $referralService;

    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }

    public function execute(User $user): float
    {
        return $this->referralService->getMultiplier($user);
    }
}