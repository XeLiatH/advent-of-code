<?php

$handle = fopen('input.txt', 'r');
if ($handle === false) {
    throw new \Exception("Cannot read input.txt file!");
}

$zeros = 0;
$dial = 50;

while (($line = fgets($handle)) !== false) {
    $matched = preg_match('/([R|L])(\d+)/i', $line, $matches) !== false;
    if (!$matched) {
        continue;
    }

    assert(count($matches) === 3);

    $direction = strtolower($matches[1]);
    assert($direction === 'l' || $direction === 'r');

    $amount = (int)$matches[2];

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

fclose($handle);

echo(sprintf("Password is: %d \r\n", $zeros));

exit(0);
