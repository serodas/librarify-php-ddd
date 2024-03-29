<?php

declare(strict_types=1);

namespace MyLibrary\Backoffice\Books\Infrastructure\Persistence;

use MyLibrary\Backoffice\Books\Domain\BackofficeBook;
use MyLibrary\Backoffice\Books\Domain\BackofficeBookRepository;
use MyLibrary\Shared\Domain\Criteria\Criteria;
use function Lambdish\Phunctional\get;

final class InMemoryCacheBackofficeBookRepository implements BackofficeBookRepository
{
    private static array               $allBooksCache = [];
    private static array               $matchingCache   = [];

    public function __construct(private readonly BackofficeBookRepository $repository)
    {
    }

    public function save(BackofficeBook $book): void
    {
        $this->repository->save($book);
    }

    public function searchAll(): array
    {
        return empty(self::$allBooksCache) ? $this->searchAllAndFillCache() : self::$allBooksCache;
    }

    public function matching(Criteria $criteria): array
    {
        return get($criteria->serialize(), self::$matchingCache) ?: $this->searchMatchingAndFillCache($criteria);
    }

    private function searchAllAndFillCache(): array
    {
        return self::$allBooksCache = $this->repository->searchAll();
    }

    private function searchMatchingAndFillCache(Criteria $criteria): array
    {
        return self::$matchingCache[$criteria->serialize()] = $this->repository->matching($criteria);
    }
}
