<?php

use App\SolutionInterface;

return new class () implements SolutionInterface {
    public function solve(string $data): string
    {
        $lines = explode("\n", $data);

        $spaceKey = array_search('', $lines);

        $inclusiveRanges = array_slice($lines, 0, $spaceKey);
        $ingredientIds = array_slice($lines, $spaceKey + 1, count($lines));

        $freshCount = 0;

        foreach ($ingredientIds as $ingredientId) {
            $isInRange = false;

            foreach ($inclusiveRanges as $inclusiveRange) {
                [$min, $max] = explode('-', $inclusiveRange);

                if ($ingredientId >= $min && $ingredientId <= $max) {
                    $isInRange = true;
                    break;
                }
            }

            if ($isInRange) {
                $freshCount++;
            }
        }

        return (string) $freshCount;
    }
};
