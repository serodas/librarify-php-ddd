<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Authors;

use Mockery\MockInterface;
use MyLibrary\Librarify\Authors\Domain\Author;
use MyLibrary\Librarify\Authors\Domain\AuthorRepository;
use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

abstract class AuthorsModuleUnitTestCase extends UnitTestCase
{
    private AuthorRepository|MockInterface|null $repository;

    protected function shouldSave(Author $author): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->with($this->similarTo($author))
            ->once()
            ->andReturnNull();
    }

    protected function shouldSearch(AuthorId $id, ?Author $author): void
    {
        $this->repository()
            ->shouldReceive('search')
            ->with($this->similarTo($id))
            ->once()
            ->andReturn($author);
    }

    protected function repository(): AuthorRepository|MockInterface
    {
        return $this->repository = $this->repository ?? $this->mock(AuthorRepository::class);
    }
}
