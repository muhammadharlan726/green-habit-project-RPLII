<?php

namespace App\Services;

use App\Models\User;
use App\Models\Mission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MissionAssignmentService
{
    /**
     * Get or assign missions for user today
     * 3 daily missions + 2 weekly missions
     */
    public function getAssignedMissions(User $user)
    {
        $today = now()->toDateString();
        $currentWeek = now()->format('Y-\WW');

        // Check if user already has assignments for today/this week
        $dailyMissions = $user->missions()
            ->where('frequency', 'daily')
            ->wherePivot('assigned_date', $today)
            ->get();

        $weeklyMissions = $user->missions()
            ->where('frequency', 'weekly')
            ->wherePivot('assigned_week', $currentWeek)
            ->get();

        // If assignments are stale, create new ones
        if ($dailyMissions->count() < 3) {
            $this->assignDailyMissions($user, $today);
            $dailyMissions = $user->missions()
                ->where('frequency', 'daily')
                ->wherePivot('assigned_date', $today)
                ->get();
        }

        if ($weeklyMissions->count() < 2) {
            $this->assignWeeklyMissions($user, $currentWeek);
            $weeklyMissions = $user->missions()
                ->where('frequency', 'weekly')
                ->wherePivot('assigned_week', $currentWeek)
                ->get();
        }

        return $dailyMissions->concat($weeklyMissions);
    }

    /**
     * Assign 3 random daily missions for user today
     */
    private function assignDailyMissions(User $user, string $today)
    {
        // Remove old daily assignments for this user
        $user->missions()
            ->where('frequency', 'daily')
            ->wherePivot('assigned_date', $today)
            ->detach();

        // Get random 3 daily missions
        $dailyMissions = Mission::where('frequency', 'daily')
            ->inRandomOrder()
            ->limit(3)
            ->pluck('id');

        // Attach with assignment date
        foreach ($dailyMissions as $missionId) {
            $user->missions()->attach($missionId, [
                'assigned_date' => $today,
                'status' => 'in_progress',
            ]);
        }
    }

    /**
     * Assign 2 random weekly missions for user this week
     */
    private function assignWeeklyMissions(User $user, string $currentWeek)
    {
        // Remove old weekly assignments for this user
        $user->missions()
            ->where('frequency', 'weekly')
            ->wherePivot('assigned_week', $currentWeek)
            ->detach();

        // Get random 2 weekly missions
        $weeklyMissions = Mission::where('frequency', 'weekly')
            ->inRandomOrder()
            ->limit(2)
            ->pluck('id');

        // Attach with assignment week
        foreach ($weeklyMissions as $missionId) {
            $user->missions()->attach($missionId, [
                'assigned_week' => $currentWeek,
                'status' => 'in_progress',
            ]);
        }
    }
}
