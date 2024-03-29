<?php

declare(strict_types=1);

namespace MyLibrary\Backoffice\Books\Application\SearchByCriteria;

use MyLibrary\Backoffice\Books\Application\BackofficeBookResponse;
use MyLibrary\Backoffice\Books\Application\BackofficeBooksResponse;
use MyLibrary\Backoffice\Books\Domain\BackofficeBook;
use MyLibrary\Backoffice\Books\Domain\BackofficeBookRepository;
use MyLibrary\Shared\Domain\Criteria\Criteria;
use MyLibrary\Shared\Domain\Criteria\Filters;
use MyLibrary\Shared\Domain\Criteria\Order;
use function Lambdish\Phunctional\map;

final class BackofficeBooksByCriteriaSearcher
{
    public function __construct(private readonly BackofficeBookRepository $repository)
    {
    }

    public function search(Filters $filters, Order $order, ?int $limit, ?int $offset): BackofficeBooksResponse
    {
        $criteria = new Criteria($filters, $order, $offset, $limit);

        return new BackofficeBooksResponse(...map($this->toResponse(), $this->repository->matching($criteria)));
    }

    private function toResponse(): callable
    {
        return static fn (BackofficeBook $book) => new BackofficeBookResponse(
            $book->id(),
            $book->title(),
            $book->description(),
            $book->score()
        );
    }
}
