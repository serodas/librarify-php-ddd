<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\BooksCounter\Infrastructure\Persistence;

use MyLibrary\Librarify\BooksCounter\Domain\BooksCounter;
use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterRepository;
use MyLibrary\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineBooksCounterRepository extends DoctrineRepository implements BooksCounterRepository
{
    public function save(BooksCounter $counter): void
    {
        $this->persist($counter);
    }

    public function search(): ?BooksCounter
    {
        return $this->repository(BooksCounter::class)->findOneBy([]);
    }
}
