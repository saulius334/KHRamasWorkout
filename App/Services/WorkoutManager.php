<?php 

declare(strict_types=1);

namespace App\Services;

class WorkoutManager {
    public function __construct()
    {
        if (! Schema::hasTable('workouts')) {
            return;
        }
        $this->walkerWorkouts = Workout::whereBetween('level', Client::WALKER_RANGE)->pluck('id')->toArray();
        $this->beginnerWorkouts = Workout::whereBetween('level', Client::BEGINNER_RANGE)->pluck('id')->toArray();
        $this->intermediateWorkouts = Workout::whereBetween('level', Client::INTERMEDIATE_RANGE)->pluck('id')->toArray();
        $this->advancedWorkouts = Workout::whereBetween('level', Client::ADVANCED_RANGE)->pluck('id')->toArray();
        $this->proWorkouts = Workout::whereBetween('level', Client::PRO_RANGE)->pluck('id')->toArray();
    
    }
    public function getWorkout($workoutType) {
        $workout = new WorkoutSelect($workoutType);
        return $workout;
    }

}