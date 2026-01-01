#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\SolutionInput;
use App\SolutionInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Stopwatch\Stopwatch;

(new SingleCommandApplication())
    ->setName('Advent of code app runner')
    ->setVersion('1.0.0')
    ->addArgument(
        'path',
        InputArgument::REQUIRED,
        'Formatted as year/day. For example for year 2025 day 1 you would use "2025/01"'
    )
    ->setCode(
        function (InputInterface $input, OutputInterface $output): void {
            $path = $input->getArgument('path');

            if (!preg_match('/^(\d{4})(?:\/(\d{1,2})(?:-(\d{1,2}))?)?$/', $path, $matches)) {
                throw new InvalidArgumentException(
                    sprintf('Invalid path format (got: "%s")', $path)
                );
            }

            $dataFilename = 'data.json';

            $year = $matches[1];
            assert(!empty($year));

            $day = $matches[2] ?? null;
            $part = $matches[3] ?? null;

            $days = $day === null ? getDirectoryList(getSolutionDirectoryPath($year)) : [$day];

            $output->writeln('');

            foreach ($days as $j => $day) {
                $directory = getSolutionDirectoryPath($year, $day);

                $directoryExists = is_dir($directory);

                if (!$directoryExists) {
                    throw new InvalidArgumentException(
                        sprintf('Directory does not exist (got: "%s")', $directory)
                    );
                }

                $solutionInput = SolutionInput::fromJsonFile(
                    sprintf('%s/%s', $directory, $dataFilename)
                );

                $parts = $part === null ? ['01', '02'] : [$part];

                foreach ($parts as $part) {
                    $solutionFile = sprintf('%s/%s.php', $directory, $part);
                    if (!file_exists($solutionFile)) {
                        continue;
                    }

                    /** @var SolutionInterface $solution */
                    $solution = include $solutionFile;

                    foreach ($solutionInput->scenarios as $i => $scenario) {
                        $watch = new Stopwatch();
                        $watch->start($part);

                        $expectedValue = $scenario->getExpectedValue($part);
                        $result = $solution->solve($scenario->data);

                        $event = $watch->stop($part);

                        $success = $result === $expectedValue;

                        $output->writeln([
                            sprintf('<fg=cyan>» %s</> <fg=gray>(took %s)</>', sprintf('%d day %d part %d, scenario %d', $year, $day, (int) $part, $i + 1), formatDuration($event->getDuration())),
                            sprintf('<fg=%s>  result: %s</>', $success ? 'green' : 'red', $result),
                            sprintf('<fg=white>  expected: %s</>', $expectedValue),
                        ]);

                        $output->writeln('');
                    }
                }

                if ($j < count($days) - 1) {
                    $output->writeln(' ---');
                    $output->writeln('');
                }
            }
        }
    )
    ->run();

function getSolutionDirectoryPath(string $year, ?string $day = null): string
{
    $str = sprintf('%s/%s', __DIR__, $year);

    if (!empty($day)) {
        $str .= sprintf('/%02d', $day);
    }

    return $str;
}

/**
 * @return array<string>
 */
function getDirectoryList(string $dir): array
{
    if (!is_dir($dir)) {
        return [];
    }

    $result = [];
    foreach (new DirectoryIterator($dir) as $fileInfo) {
        if ($fileInfo->isDot()) {
            continue;
        }

        if ($fileInfo->isDir()) {
            $result[] = $fileInfo->getFilename();
        }
    }

    sort($result);

    return $result;
}

function formatDuration(int $ms): string
{
    if ($ms < 1000) {
        return $ms . ' ms';
    }

    return number_format($ms / 1000, 3) . ' s';
}
