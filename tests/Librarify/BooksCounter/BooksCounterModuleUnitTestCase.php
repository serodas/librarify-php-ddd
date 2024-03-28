<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\BooksCounter;

use MyLibrary\Librarify\BooksCounter\Domain\BooksCounter;
use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterRepository;
use MyLibrary\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class BooksCounterModuleUnitTestCase extends UnitTestCase
{
    private BooksCounterRepository|MockInterface|null $repository;

    protected function shouldSave(BooksCounter $course): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->once()
            ->with($this->similarTo($course))
            ->andReturnNull();
    }

    protected function shouldSearch(?BooksCounter $counter): void
    {
        $this->repository()
            ->shouldReceive('search')
            ->once()
            ->andReturn($counter);
    }

    protected function repository(): BooksCounterRepository|MockInterface
    {
        return $this->repository = $this->repository ?? $this->mock(BooksCounterRepository::class);
    }
}