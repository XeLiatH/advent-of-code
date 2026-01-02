<?php

use App\SolutionInterface;

return new class () implements SolutionInterface {
    public function solve(string $data): string
    {
        $banks = explode("\n", $data);

        $joltage = 0;

        foreach ($banks as $bank) {
            $batteries = str_split($bank);

            $highestJoltageInBattery = 0;
            for ($i = 0; $i < count($batteries); $i++) {
                $left = $batteries[$i];

                for ($j = $i + 1; $j < count($batteries); $j++) {
                    $right = $batteries[$j];

                    $number = intval($left . $right);

                    if ($number > $highestJoltageInBattery) {
                        $highestJoltageInBattery = $number;
                    }
                }
            }

            $joltage += $highestJoltageInBattery;
        }

        return (string) $joltage;
    }
};
