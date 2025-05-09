<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $activitiesCount = rand(10, 50); // Each user gets 10–50 activities

            for ($i = 0; $i < $activitiesCount; $i++) {
                Activity::create([
                    'user_id' => $user->id,
                    'performed_at' => Carbon::now()->subDays(rand(0, 365))->setTime(rand(5, 20), rand(0, 59)),
                    'points' => 20,
                ]);
            }
        }
    }
}

