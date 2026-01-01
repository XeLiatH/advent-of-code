<?php

declare(strict_types=1);

namespace App;

final class SolutionResult
{
    public function success(): bool
    {
        return true;
    }

    public function failure(): bool
    {
        return false;
    }
}
