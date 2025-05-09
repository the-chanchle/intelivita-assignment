<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LeaderboardService;

class RecalculateLeaderboard extends Command
{
    protected $signature = 'leaderboard:recalculate';
    protected $description = 'Recalculate the leaderboard and store user ranks';

    public function __construct(private LeaderboardService $leaderboardService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->leaderboardService->recalculate();
        $this->info('Leaderboard recalculated successfully.');
        return 0;
    }
}
