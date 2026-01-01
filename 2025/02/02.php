<?php

require_once 'classes.php';

use App\SolutionInterface;

return new class () implements SolutionInterface {
    public function solve(string $data): string
    {
        $strRanges = explode(',', $data);

        /** @var IdRange[] $ranges */
        $ranges = [];
        foreach ($strRanges as $rangeAsString) {
            $ranges[] = IdRange::fromString($rangeAsString);
        }

        $items = [];

        for ($i = 1; $i <= 100_000; $i++) {
            for ($repeat = 2; $repeat <= 11; $repeat++) {
                $candidate = (int) str_repeat($i, $repeat);

                if ($candidate > 10_000_000_000) {
                    break;
                }

                foreach ($ranges as $range) {
                    if ($range->inRange(new Id($candidate))) {
                        $items[$candidate] = true;
                        break;
                    }
                }
            }
        }

        $sum = array_sum(array_keys($items));

        return (string) $sum;
    }
};