<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\BooksCounter\Domain;

interface BooksCounterRepository
{
    public function save(BooksCounter $counter): void;

    public function search(): ?BooksCounter;
}
