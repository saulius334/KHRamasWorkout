<?php 

declare(strict_types=1);

namespace App\Services;

class WorkoutManager {
    public function __construct()
    {
        if (! Schema::hasTable('workouts')) {
            return;
        }
    }
    public function getWorkout() {
        $workout = new WorkoutSelect();
        return $workout;
    }
    public function getWorkoutPlan($workoutPlanType) {
        $workoutPlan = new WorkoutPlanSelect($workoutPlanType);
        return $workoutPlan;
    }

}