<?php

declare(strict_types=1);

namespace App;

class Workout {
    public function __construct(
        private array $walkerWorkouts,
        private array $beginnerWorkouts,
        private array $intermediateWorkouts,
        private array $advancedWorkouts,
        private array $proWorkouts
    )
    {
        return array_merge(
            $this->walkerWorkouts,
            $this->beginnerWorkouts,
            $this->intermediateWorkouts,
            $this->advancedWorkouts,
            $this->proWorkouts,
        );
    }

}