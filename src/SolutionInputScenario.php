<?php

declare(strict_types=1);

namespace App;

final class SolutionInputScenario
{
    public function __construct(
        public readonly string $data,
        public readonly string $expectedPart1,
        public readonly string $expectedPart2,
    ) {
    }

    public function getExpectedValue(string $part): string
    {
        return match ($part) {
            '01' => $this->expectedPart1,
            '02' => $this->expectedPart2,
        };
    }
}
