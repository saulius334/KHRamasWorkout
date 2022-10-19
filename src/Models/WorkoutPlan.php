<?php

declare(strict_types=1);

namespace Saulius\KhRamasWorkout\Models;

use Illuminate\Support\Facades\Schema;

class WorkoutPlan {
    public function __construct()
    {
        if (!Schema::hasTable('workoutPlans')) {
            return;
        }
        return [];
    }

}