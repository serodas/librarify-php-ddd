<?php

declare(strict_types=1);

namespace MyLibrary\Backoffice\Books\Application\SearchByCriteria;

use MyLibrary\Backoffice\Books\Application\BackofficeBooksResponse;
use MyLibrary\Shared\Domain\Bus\Query\QueryHandler;
use MyLibrary\Shared\Domain\Criteria\Filters;
use MyLibrary\Shared\Domain\Criteria\Order;

final class SearchBackofficeBooksByCriteriaQueryHandler implements QueryHandler
{
    public function __construct(private readonly BackofficeBooksByCriteriaSearcher $searcher)
    {
    }

    public function __invoke(SearchBackofficeBooksByCriteriaQuery $query): BackofficeBooksResponse
    {
        $filters = Filters::fromValues($query->filters());
        $order   = Order::fromValues($query->orderBy(), $query->order());

        return $this->searcher->search($filters, $order, $query->limit(), $query->offset());
    }
}