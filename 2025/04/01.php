<?php

use App\SolutionInterface;

return new class () implements SolutionInterface {
    public function solve(string $data): string
    {
        $lines = explode("\n", $data);

        $rollOfPaper = '@';

        $grid = [];
        foreach ($lines as $line) {
            $grid[] = str_split($line);
        }

        $total = 0;

        for ($i = 0; $i < count($grid); $i++) {
            $row = $grid[$i];

            for ($j = 0; $j < count($row); $j++) {
                $cellValue = $grid[$i][$j];

                if ($cellValue !== $rollOfPaper) {
                    continue;
                }

                $top = $grid[$i - 1][$j] ?? '';
                $bottom = $grid[$i + 1][$j] ?? '';

                $left = $grid[$i][$j - 1] ?? '';
                $right = $grid[$i][$j + 1] ?? '';

                $topLeft = $grid[$i - 1][$j - 1] ?? '';
                $topRight = $grid[$i - 1][$j + 1] ?? '';

                $bottomLeft = $grid[$i + 1][$j - 1] ?? '';
                $bottomRight = $grid[$i + 1][$j + 1] ?? '';

                $around = [$top, $bottom, $left, $right, $topLeft, $topRight, $bottomLeft, $bottomRight];

                $numOfRollsAround = count(array_filter($around, fn (string $c) => $c === $rollOfPaper));
                if ($numOfRollsAround < 4) {
                    $total++;
                }
            }
        }

        return (string) $total;
    }
};
