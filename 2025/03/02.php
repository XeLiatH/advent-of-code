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
                $window = substr($bank, $start, strlen($bank) - $start - $i);

                $batteries = str_split($window);
                $battery = max($batteries);

                $start = strpos($bank, $battery, $start) + 1;

                $joltage .= $battery;
            }

            $totalJoltage += (int) $joltage;
        }

        return (string) $totalJoltage;
    }
};
