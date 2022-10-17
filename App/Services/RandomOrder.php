<?php

declare(strict_types=1);

namespace App\Services;

class RandomOrder
{
    public function inRandomOrder(array $data): array
    {
        shuffle($data);
        return $data;
    }
}