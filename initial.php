<?php

declare(strict_types=1);

namespace App\Services;

use App\Client;
use App\Workout;
use App\WorkoutPlan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

/**
 * Class TipManager
 *
 * @package App\Services
 */
class WorkoutManager
{
    private array $walkerWorkouts;

    private array $beginnerWorkouts;

    private array $intermediateWorkouts;

    private array $advancedWorkouts;

    private array $proWorkouts;

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

    public function getRandomWorkout(): Workout
    {
        $workout = Workout::inRandomOrder()->first();
        if (! $workout) {
            throw new RuntimeException('No workout has been found');
        }
        return $workout;
    }

    public function getRandomVisibleWorkout(): Workout
    {
        $workout = Workout::where('is_visible', true)->inRandomOrder()->first();
        if (! $workout) {
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
        if (! $id) {
            return null;
        }

        return Workout::find($id);
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