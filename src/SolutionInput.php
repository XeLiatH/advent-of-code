<?php

declare(strict_types=1);

namespace App;

final class SolutionInput
{
    /**
     * @param array<SolutionInputScenario> $scenarios
     */
    public function __construct(
        public readonly array $scenarios
    ) {
    }

    public static function fromJsonFile(string $file): self
    {
        $jsonString = file_get_contents($file);
        if ($jsonString === false) {
            throw new \InvalidArgumentException(
                sprintf('Reading json file failed (file: "%s")', $file)
            );
        }

        $data = json_decode($jsonString, true);
        if ($data === false) {
            throw new \InvalidArgumentException(
                sprintf('Could not decode valid json (file: "%s")', $file)
            );
        }

        /** @var SolutionInputScenario[] $scenarios */
        $scenarios = [];

        foreach ($data as $scenario) {
            $scenarios[] = new SolutionInputScenario(
                data: $scenario['data'],
                expectedPart1: $scenario['expected_part_1'],
                expectedPart2: $scenario['expected_part_2'],
            );
        }

        return new self($scenarios);
    }
}
