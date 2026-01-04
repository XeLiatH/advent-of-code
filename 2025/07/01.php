<?php

use App\SolutionInterface;

return new class () implements SolutionInterface {
    public function solve(string $data): string
    {
        $lines = explode("\n", $data);

        $start = 'S';
        $beam = '|';
        $splitter = '^';

        $startingIndex = (int) array_search($start, str_split($lines[0]));

        $activeBeamIndices = [$startingIndex];

        $timesSplit = 0;

        for ($i = 1; $i < count($lines); $i++) {
            $line = $lines[$i];

            $chars = str_split($line);

            foreach ($activeBeamIndices as $beamIndex) {

                if ($chars[$beamIndex] === $splitter) {
                    $activeBeamIndices[] = $beamIndex - 1;
                    $activeBeamIndices[] = $beamIndex + 1;

                    $lines[$i][$beamIndex - 1] = $beam;
                    $lines[$i][$beamIndex + 1] = $beam;

                    $removeIndex = array_search($beamIndex, $activeBeamIndices);
                    array_splice($activeBeamIndices, $removeIndex, 1);

                    $activeBeamIndices = array_unique($activeBeamIndices);
                    sort($activeBeamIndices);

                    $timesSplit++;
                } else {
                    $lines[$i][$beamIndex] = $beam;
                }
            }
        }

        return (string) $timesSplit;
    }
};
