<?php

declare(strict_types=1);

namespace App;

interface SolutionInterface
{
    public function solve(string $data): string;
}