<?php

use App\SolutionInterface;

return new class () implements SolutionInterface {
    public function solve(string $data): string
    {
        $lines = explode("\n", $data);

        $zeros = 0;
        $dial = 50;

        foreach ($lines as $line) {
            $matched = preg_match('/([R|L])(\d+)/i', $line, $matches) !== false;
            if (!$matched) {
                continue;
            }

            assert(count($matches) === 3);

            $direction = strtolower($matches[1]);
            assert($direction === 'l' || $direction === 'r');

            $amount = (int) $matches[2];

            if ($direction === 'l') {
                $dial -= $amount;
            }

            if ($direction === 'r') {
                $dial += $amount;
            }

            $dial = $dial % 100;

            if ($dial === 0) {
                $zeros++;
            }
        }

        return (string) $zeros;
    }
};