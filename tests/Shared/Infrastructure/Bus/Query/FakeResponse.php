<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Infrastructure\Bus\Query;

use MyLibrary\Shared\Domain\Bus\Query\Response;

final class FakeResponse implements Response
{
    public function __construct(private int $number)
    {
    }

    public function number(): int
    {
        return $this->number;
    }
}
