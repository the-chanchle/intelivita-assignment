<?php

namespace App\Http\Controllers;

use App\Models\UserRanking;
use App\Models\User;
use App\Services\LeaderboardService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $query = UserRanking::with('user')->orderBy('rank');

        // Filtering
        if ($request->filter) {
            $dateColumn = 'performed_at';
            $filteredUserIds = User::whereHas('activities', function ($q) use ($request, $dateColumn) {
                if ($request->filter === 'day') {
                    $q->whereDate($dateColumn, Carbon::today());
                } elseif ($request->filter === 'month') {
                    $q->whereMonth($dateColumn, Carbon::now()->month)
                      ->whereYear($dateColumn, Carbon::now()->year);
                } elseif ($request->filter === 'year') {
                    $q->whereYear($dateColumn, Carbon::now()->year);
                }
            })->pluck('id');

            $query->whereIn('user_id', $filteredUserIds);
        }

        // Search
        if ($request->search_id) {
            $userRank = UserRanking::with('user')->where('user_id', $request->search_id)->first();
            if ($userRank) {
                $results = $query->where('user_id', '!=', $request->search_id)->get();
                $leaderboard = collect([$userRank])->merge($results);
            } else {
                $leaderboard = $query->get();
            }
        } else {
            $leaderboard = $query->get();
        }

        $leaderboardData = [];
        foreach($leaderboard as $row => $value) {
            $leaderboardData[] = [
                'user_id' => $value->user->id,
                'rank' => $row + 1,
                'user_name' => $value->user->name,
                'total_points' => $value->total_points
            ]; 
        }

        return view('leaderboard.index', compact('leaderboardData'));
    }

    public function recalculate(LeaderboardService $leaderboardService)
    {
        $leaderboardService->recalculate();
        return redirect()->route('leaderboard.index')->with('success', 'Leaderboard recalculated successfully.');
    }
}
