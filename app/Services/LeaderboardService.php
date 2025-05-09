<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\UserRanking;

class LeaderboardService
{
    public function recalculate(): void
    {
        // Clear existing rankings
        UserRanking::truncate();

        // Get all activities and group by user_id using Collection
        $totals = Activity::all()
            ->groupBy('user_id')
            ->map(function ($activities, $userId) {
                return (object)[
                    'user_id' => $userId,
                    'total_points' => $activities->sum('points'),
                ];
            })
            ->sortByDesc('total_points')
            ->values();

        // Assign ranks
        $currentRank = 1;
        $previousPoints = null;
        $actualRank = 0;

        foreach ($totals as $index => $record) {
            if ($record->total_points !== $previousPoints) {
                $actualRank = $currentRank;
            }

            UserRanking::create([
                'user_id' => $record->user_id,
                'total_points' => $record->total_points,
                'rank' => $actualRank,
            ]);

            $previousPoints = $record->total_points;
            $currentRank++;
        }
    }
}
