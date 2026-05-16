<?php
// File: app/Actions/UpdateLeaderboard.php
namespace App\Actions;

use App\Services\LeaderboardService;

class UpdateLeaderboard
{
    protected LeaderboardService $leaderboardService;

    public function __construct(LeaderboardService $leaderboardService)
    {
        $this->leaderboardService = $leaderboardService;
    }

    public function execute(): void
    {
        $this->leaderboardService->updateSnapshot();
    }
}