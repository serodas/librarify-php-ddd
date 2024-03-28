<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\BooksCounter\Application\Find;

use MyLibrary\Shared\Domain\Bus\Query\QueryHandler;

final class FindBooksCounterQueryHandler implements QueryHandler
{
    public function __construct(private readonly BooksCounterFinder $finder)
    {
    }

    public function __invoke(FindBooksCounterQuery $query): BooksCounterResponse
    {
        return $this->finder->__invoke();
    }
}
