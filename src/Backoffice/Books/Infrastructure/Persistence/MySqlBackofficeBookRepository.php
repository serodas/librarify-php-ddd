<?php

declare(strict_types=1);

namespace MyLibrary\Backoffice\Books\Infrastructure\Persistence;

use MyLibrary\Backoffice\Books\Domain\BackofficeBook;
use MyLibrary\Backoffice\Books\Domain\BackofficeBookRepository;
use MyLibrary\Shared\Domain\Criteria\Criteria;
use MyLibrary\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
use MyLibrary\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class MySqlBackofficeBookRepository extends DoctrineRepository implements BackofficeBookRepository
{
    public function save(BackofficeBook $Book): void
    {
        $this->persist($Book);
    }

    public function searchAll(): array
    {
        return $this->repository(BackofficeBook::class)->findAll();
    }

    public function matching(Criteria $criteria): array
    {
        $doctrineCriteria = DoctrineCriteriaConverter::convert($criteria);

        return $this->repository(BackofficeBook::class)->matching($doctrineCriteria)->toArray();
    }
}
