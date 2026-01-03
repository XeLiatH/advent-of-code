<?php

use App\SolutionInterface;

return new class () implements SolutionInterface {
    public function solve(string $data): string
    {
        $lines = explode("\n", $data);

        $operators = array_values(array_filter(preg_split('/\s+/', array_splice($lines, -1)[0])));

        $problemIndex = 0;
        $problems = [];

        for ($i = 0; $i < strlen($lines[0]); $i++) {
            $column = [];
            for ($j = 0; $j < count($lines); $j++) {
                $column[] = $lines[$j][$i];
            }

            $cleanColumn = array_filter($column, fn (string $c) => $c !== ' ');

            if (empty($cleanColumn)) {
                $problemIndex++;
                continue;
            }

            $problems[$problemIndex][] = (int) implode('', $cleanColumn);
        }

        assert(count($problems) === count($operators));

        $total = 0;

        foreach ($problems as $i => $problem) {
            $operator = $operators[$i];

            $subResult = $operator === '+' ? 0 : 1;

            foreach ($problem as $operand) {
                if ($operator === '+') {
                    $subResult += $operand;
                }

                if ($operator === '*') {
                    $subResult *= $operand;
                }
            }

            $total += $subResult;
        }

        return (string) $total;
    }
};
