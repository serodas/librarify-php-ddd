<?php

declare(strict_types=1);

namespace MyLibrary\Backoffice\Books\Infrastructure\Persistence;

use MyLibrary\Backoffice\Books\Domain\BackofficeBook;
use MyLibrary\Backoffice\Books\Domain\BackofficeBookRepository;
use MyLibrary\Shared\Domain\Criteria\Criteria;
use MyLibrary\Shared\Infrastructure\Persistence\Elasticsearch\ElasticsearchRepository;
use function Lambdish\Phunctional\map;

final class ElasticsearchBackofficeBookRepository extends ElasticsearchRepository implements BackofficeBookRepository
{
    public function save(BackofficeBook $book): void
    {
        $this->persist($book->id(), $book->toPrimitives());
    }

    public function searchAll(): array
    {
        return map($this->toBook(), $this->searchAllInElastic());
    }

    public function matching(Criteria $criteria): array
    {
        return map($this->toBook(), $this->searchByCriteria($criteria));
    }

    protected function aggregateName(): string
    {
        return 'books';
    }

    private function toBook(): callable
    {
        return static fn (array $primitives) => BackofficeBook::fromPrimitives($primitives);
    }
}
