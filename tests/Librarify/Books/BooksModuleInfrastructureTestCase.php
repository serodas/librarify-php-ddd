<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Books;

use MyLibrary\Librarify\Books\Domain\BookRepository;
use MyLibrary\Tests\Librarify\Shared\Infrastructure\PhpUnit\LibrarifyContextInfrastructureTestCase;

abstract class BooksModuleInfrastructureTestCase extends LibrarifyContextInfrastructureTestCase
{
    protected function repository(): BookRepository
    {
        return $this->service(BookRepository::class);
    }
}
