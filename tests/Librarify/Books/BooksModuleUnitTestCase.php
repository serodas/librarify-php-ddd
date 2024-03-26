<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Books;

use Mockery\MockInterface;
use MyLibrary\Librarify\Books\Domain\Book;
use MyLibrary\Librarify\Books\Domain\BookRepository;
use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

abstract class BooksModuleUnitTestCase extends UnitTestCase
{
    private BookRepository|MockInterface|null $repository;

    protected function shouldSave(Book $book): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->with($this->similarTo($book))
            ->once()
            ->andReturnNull();
    }

    protected function shouldSearch(?Book $book): void
    {
        $this->repository()
            ->shouldReceive('search')
            ->once()
            ->andReturn($book);
    }

    protected function repository(): BookRepository|MockInterface
    {
        return $this->repository = $this->repository ?? $this->mock(BookRepository::class);
    }
}
