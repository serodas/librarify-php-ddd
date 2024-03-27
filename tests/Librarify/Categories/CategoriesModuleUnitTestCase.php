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

    protected function shouldSave(Category $category): void
    {
        $this->repository()
            ->shouldReceive('save')
            ->with($this->similarTo($category))
            ->once()
            ->andReturnNull();
    }

    protected function shouldSearch(?Category $category): void
    {
        $this->repository()
            ->shouldReceive('search')
            ->once()
            ->andReturn($category);
    }

    protected function repository(): CategoryRepository|MockInterface
    {
        return $this->repository = $this->repository ?? $this->mock(CategoryRepository::class);
    }
}
