<?php

declare(strict_types=1);

namespace Saulius\KhRamasWorkout\Services;

use Saulius\KhRamasWorkout\Models\WorkoutPlan;

class WorkoutPlanSelect {
    public function __construct()
    {
        
    }
    public function getOneByVersionScoreAndCount(int $version, int $score, int $workoutCount): ?WorkoutPlan
    {
        $version = $version === 1 ? null : $version;

        return WorkoutPlan::where('training_plan->version', $version)
            ->where('running_level', $score)
            ->where('workout_count', $workoutCount)
            ->first();
    }

    /**
     * @return Collection|WorkoutPlan[]
     */
    public function getAllByVersionScoreAndCount(int $version, int $score, int $workoutCount): Collection
    {
        $version = $version === 1 ? null : $version;

        return WorkoutPlan::where('training_plan->version', $version)
            ->where('running_level', $score)
            ->where('workout_count', $workoutCount)
            ->get();
    }

    public function getByVersionAndScore(int $version, int $score): ?WorkoutPlan
    {
        $version = $version === 1 ? null : $version;

        return WorkoutPlan::where('training_plan->version', $version)
            ->where('running_level', $score)
            ->first();
    }

    public function getByVersionAndCount(int $version, int $score): ?WorkoutPlan
    {
        $version = $version === 1 ? null : $version;

        return WorkoutPlan::where('training_plan->version', $version)
            ->where('workout_count', $score)
            ->first();
    }
}