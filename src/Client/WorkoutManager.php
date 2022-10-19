<?php 

declare(strict_types=1);

namespace Saulius\KhRamasWorkout\Services;

use App\Services\WorkoutSelect;
use Saulius\KhRamasWorkout\Models\Workout;
use Saulius\KhRamasWorkout\Models\WorkoutPlan;

class WorkoutManager {
    public function __construct(Workout $workouts, WorkoutPlan $workoutPlans)
    {
        if (! Schema::hasTable('workouts')) {
            return;
        }
        $this->workouts = $workouts;
        $this->workoutPlans = $workoutPlans;
    }


    public function getWorkout($type) {
        $workout = new WorkoutSelect();
        return $workout;
    }
    public function getWorkoutPlan($type) {
        $workoutPlan = new WorkoutPlanSelect($type);
        return $workoutPlan;
    }

}