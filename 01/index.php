<?php

require __DIR__.'/../vendor/autoload.php';

$handle = fopen('input.txt', 'r');
if ($handle === false) {
    throw new \Exception("Cannot read input.txt file!");
}

$zeros = 0;
$dial = 50;

while (($line = fgets($handle)) !== false)
{
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

    $rotateBy = (int)$matches[2];

    // using brute force, surely there is a better way
    for ($i = 0; $i < $rotateBy; $i++)
    {
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

fclose($handle);

echo(sprintf("Password is: %d \r\n", $zeros));

exit(0);
