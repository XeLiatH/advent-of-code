<?php

use App\SolutionInterface;

return new class () implements SolutionInterface {
    public function solve(string $data): string
    {
        $lines = explode("\n", $data);

        $spaceKey = array_search('', $lines);

        $inclusiveRanges = array_slice($lines, 0, $spaceKey);
        sort($inclusiveRanges, SORT_NUMERIC);

        $freshCount = 0;

        $prevMax = -1;

        foreach ($inclusiveRanges as $inclusiveRange) {
            [$min, $max] = explode('-', $inclusiveRange);

            $min = (int) $min;
            $max = (int) $max;

            if ($max <= $prevMax) {
                continue;
            }

            $freshCount += $max - max($min, $prevMax + 1) + 1;
            $prevMax = max($max, $prevMax);
        }

        return (string) $freshCount;
    }
};
