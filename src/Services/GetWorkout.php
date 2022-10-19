<?php

declare(strict_types=1);

use Saulius\KhRamasWorkout\Models\Workout;
use App\Services\RandomOrder;

class GetWorkout {
    public function getWorkout(string $type, Workout $workouts)
    {
        if ($type == 'Random') {
            $rnd = new RandomOrder();
            return $rnd->inRandomOrder($workouts);
        }
    }
}