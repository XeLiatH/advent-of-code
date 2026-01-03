<?php

use App\SolutionInterface;

return new class () implements SolutionInterface {
    public function solve(string $data): string
    {
        $lines = explode("\n", $data);

        $terms = [];
        foreach ($lines as $line) {
            $terms[] = array_values(array_filter(preg_split('/\s+/', $line)));
        }

        $total = 0;

        for ($i = 0; $i < count($terms[0]); $i++) {
            $column = array_column($terms, $i);
            $operator = array_splice($column, -1)[0];

            $result = $operator === '+' ? 0 : 1;

            foreach ($column as $operand) {
                if ($operator === '+') {
                    $result += $operand;
                }

                if ($operator === '*') {
                    $result *= $operand;
                }
            }

            $total += $result;
        }

        return (string) $total;
    }
};
