<?php

use App\SolutionInterface;

return new class () implements SolutionInterface {
    public function solve(string $data): string
    {
        $lines = explode("\n", $data);

        $zeros = 0;
        $dial = 50;

        foreach ($lines as $line) {
            if (!trim($line)) {
                continue;
            }

            $matched = preg_match('/([R|L])(\d+)/i', $line, $matches) !== false;
            if (!$matched) {
                continue;
            }

            assert(count($matches) === 3);

            $direction = strtolower($matches[1]);
            assert($direction === 'l' || $direction === 'r');

            $rotateBy = (int) $matches[2];

            // using brute force, surely there is a better way
            for ($i = 0; $i < $rotateBy; $i++) {
                if ($direction === 'l') {
                    $dial -= 1;
                }

                if ($direction === 'r') {
                    $dial += 1;
                }

                $dial = $dial % 100;

                if ($dial == 0) {
                    $zeros++;
                }
            }
        }

        return (string) $zeros;
    }
};