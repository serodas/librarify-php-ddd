<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\BooksCounter\Application\Find;

use MyLibrary\Librarify\BooksCounter\Application\Find\BooksCounterResponse;
use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterTotal;
use MyLibrary\Tests\Librarify\BooksCounter\Domain\BooksCounterTotalMother;

final class BooksCounterResponseMother
{
    public static function create(?BooksCounterTotal $total = null): BooksCounterResponse
    {
        return new BooksCounterResponse($total?->value() ?? BooksCounterTotalMother::create()->value());
    }
}