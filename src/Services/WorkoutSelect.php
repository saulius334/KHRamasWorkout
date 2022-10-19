<?php

namespace App\Services;

use Saulius\KhRamasWorkout\Models\Client;
use Saulius\KhRamasWorkout\Models\Workout;

class WorkoutSelect
{
    private array $walkerWorkouts;
    private array $beginnerWorkouts;
    private array $intermediateWorkouts;
    private array $advancedWorkouts;
    private array $proWorkouts;

    public function __construct()
    {
        $this->walkerWorkouts = Workout::whereBetween('level', Client::WALKER_RANGE)->pluck('id')->toArray();
        $this->beginnerWorkouts = Workout::whereBetween('level', Client::BEGINNER_RANGE)->pluck('id')->toArray();
        $this->intermediateWorkouts = Workout::whereBetween('level', Client::INTERMEDIATE_RANGE)->pluck('id')->toArray();
        $this->advancedWorkouts = Workout::whereBetween('level', Client::ADVANCED_RANGE)->pluck('id')->toArray();
        $this->proWorkouts = Workout::whereBetween('level', Client::PRO_RANGE)->pluck('id')->toArray();
    }
    public function getRandomWorkout(): Workout
    {
        $workout = Workout::inRandomOrder()->first();
        if (!$workout) {
            throw new RuntimeException('No workout has been found');
        }
        return $workout;
    }





    public function getRandomVisibleWorkout(): Workout
    {
        $workout = Workout::where('is_visible', true)->inRandomOrder()->first();
        if (!$workout) {
            throw new RuntimeException('No workout has been found');
        }
        return $workout;
    }





    public function getWorkoutIdByScore(int $score): ?int
    {
        if (Client::BEGINNER_RANGE[0] <= $score && $score <= Client::BEGINNER_RANGE[1]) {
            if (empty($this->beginnerWorkouts)) {
                return null;
            }

            return $this->beginnerWorkouts[array_rand($this->beginnerWorkouts)];
        }

        if (Client::INTERMEDIATE_RANGE[0] <= $score && $score <= Client::INTERMEDIATE_RANGE[1]) {
            if (empty($this->intermediateWorkouts)) {
                return null;
            }

            return $this->intermediateWorkouts[array_rand($this->intermediateWorkouts)];
        }

        if (Client::ADVANCED_RANGE[0] <= $score && $score <= Client::ADVANCED_RANGE[1]) {
            if (empty($this->advancedWorkouts)) {
                return null;
            }

            return $this->advancedWorkouts[array_rand($this->advancedWorkouts)];
        }

        if (Client::PRO_RANGE[0] <= $score && $score <= Client::PRO_RANGE[1]) {
            if (empty($this->proWorkouts)) {
                return null;
            }

            return $this->proWorkouts[array_rand($this->proWorkouts)];
        }

        if (empty($this->walkerWorkouts)) {
            return null;
        }

        return $this->walkerWorkouts[array_rand($this->walkerWorkouts)];
    }






    

    public function getWorkoutByScore(int $score): ?Workout
    {
        $id = $this->getWorkoutIdByScore($score);
        if (!$id) {
            return null;
        }

        return Workout::find($id);
    }
}
