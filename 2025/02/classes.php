<?php

if (!class_exists('Id')) {
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
}

if (!class_exists('IdRange')) {
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
}
