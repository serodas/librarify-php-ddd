<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\BooksCounter\Application\Find;

use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterNotFound;
use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterRepository;

final class BooksCounterFinder
{
    public function __construct(private readonly BooksCounterRepository $repository)
    {
    }

    public function __invoke(): BooksCounterResponse
    {
        $counter = $this->repository->search();

        if (null === $counter) {
            throw new BooksCounterNotFound();
        }

        return new BooksCounterResponse($counter->total()->value());
    }
}