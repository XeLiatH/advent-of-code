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

        $sum = 0;
        foreach ($ranges as $range) {
            foreach ($range as $id) {
                /** @var Id $id */
                if ($id->isInvalidPart1()) {
                    $sum += $id->getValue();
                }
            }
        }

        return (string) $sum;
    }
};
