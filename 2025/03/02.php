<?php

use App\SolutionInterface;

return new class () implements SolutionInterface {
    public function solve(string $data): string
    {
        $banks = explode("\n", $data);

        $totalJoltage = 0;

        foreach ($banks as $bank) {
            $joltage = '';
            $start = 0;

            for ($i = 11; $i >= 0; $i--) {

                if ($i > 0) {
                    $window = substr($bank, $start, strlen($bank) - $start - $i);
                } else {
                    $window = substr($bank, $start);
                }

                $batteries = str_split($window);
                $value = max($batteries);

                $start = strpos($bank, $value, $start) + 1;

                $joltage .= $value;
            }

            $totalJoltage += (int) $joltage;
        }

        return (string) $totalJoltage;
    }
};
