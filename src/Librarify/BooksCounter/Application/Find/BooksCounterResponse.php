<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\BooksCounter\Application\Find;

use MyLibrary\Shared\Domain\Bus\Query\Response;

final class BooksCounterResponse implements Response
{
    public function __construct(private readonly int $total)
    {
    }

    public function total(): int
    {
        return $this->total;
    }
}
