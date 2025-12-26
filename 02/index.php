<?php

require __DIR__ . '/../vendor/autoload.php';

class Id
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function isInvalidPart1(): bool
    {
        $str = (string) $this->value;
        $size = strlen($str);

        $isLengthOdd = $size % 2 === 1;

        if ($isLengthOdd) {
            return false;
        }

        $mid = intval($size / 2);
        $left = substr($str, 0, $mid);
        $right = substr($str, $mid);

        for ($i = 0; $i < $mid; ++$i) {
            if (substr($left, $i, 1) !== substr($right, $i, 1)) {
                return false;
            }
        }

        return true;
    }
}

class IdRange implements IteratorAggregate
{
    public const SEPARATOR = '-';

    public function __construct(
        public readonly int $min,
        public readonly int $max,
    ) {
    }

    public static function fromString(string $range): self
    {
        assert(str_contains($range, self::SEPARATOR) === true);

        [$min, $max] = explode(self::SEPARATOR, $range);

        assert(is_numeric($min), 'Min is not a number');
        assert(is_numeric($max), 'Max is not a number');

        return new self(
            min: (int) $min,
            max: (int) $max,
        );
    }

    public function inRange(Id $id): bool
    {
        return $id->getValue() >= $this->min && $id->getValue() <= $this->max;
    }

    /**
     * @return \ArrayIterator<Id>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator(
            array_map(
                static fn(int $value): Id => new Id($value),
                range($this->min, $this->max),
            )
        );
    }
}

$input = file_get_contents('input.txt');
assert($input !== false, 'Could not load input file');

$strRanges = explode(',', $input);

/** @var IdRange[] $ranges */
$ranges = [];
foreach ($strRanges as $rangeAsString) {
    $ranges[] = IdRange::fromString($rangeAsString);
}

$sumPart1 = 0;
foreach ($ranges as $range) {
    foreach ($range as $id) {
        /** @var Id $id */
        if ($id->isInvalidPart1()) {
            $sumPart1 += $id->getValue();
        }
    }
}

echo (sprintf("The part1 sum of invalid ids is: %d \r\n", $sumPart1)); // 28146997880

$sumPart2Items = [];

for ($i = 1; $i <= 100_000; $i++) {
    for ($repeat = 2; $repeat <= 11; $repeat++) {
        $candidate = (int) str_repeat($i, $repeat);

        if ($candidate > 10_000_000_000) {
            break;
        }

        foreach ($ranges as $range) {
            if ($range->inRange(new Id($candidate))) {
                $sumPart2Items[$candidate] = true;
                break;
            }
        }
    }
}

$sumPart2 = array_sum(array_keys($sumPart2Items));

echo (sprintf("The part2 sum of invalid ids is: %d \r\n", $sumPart2));

exit(0);
