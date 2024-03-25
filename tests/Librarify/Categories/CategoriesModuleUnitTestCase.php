<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Categories;

use Mockery\MockInterface;
use MyLibrary\Librarify\Categories\Domain\Category;
use MyLibrary\Librarify\Categories\Domain\CategoryRepository;
use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;

abstract class CategoriesModuleUnitTestCase extends UnitTestCase
{
    private CategoryRepository|MockInterface|null $repository;

    protected function shouldSave(Category $author): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->with($this->similarTo($author))
            ->once()
            ->andReturnNull();
    }

    protected function shouldSearch(CategoryId $id, ?Category $author): void
    {
        $this->repository()
            ->shouldReceive('search')
            ->with($this->similarTo($id))
            ->once()
            ->andReturn($author);
    }

    protected function repository(): CategoryRepository|MockInterface
    {
        return $this->repository = $this->repository ?? $this->mock(CategoryRepository::class);
    }
}
