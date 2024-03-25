<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Categories\Infrastructure\Persistence;

use MyLibrary\Tests\Librarify\Categories\CategoriesModuleInfrastructureTestCase;
use MyLibrary\Tests\Librarify\Categories\Domain\CategoryIdMother;
use MyLibrary\Tests\Librarify\Categories\Domain\CategoryMother;

final class CategoryRepositoryTest extends CategoriesModuleInfrastructureTestCase
{
    /** @test */
    public function it_should_save_a_category(): void
    {
        $category = CategoryMother::create();

        $this->repository()->save($category);
    }

    /** @test */
    public function it_should_return_an_existing_category(): void
    {
        $category = CategoryMother::create();

        $this->repository()->save($category);

        $this->assertEquals($category, $this->repository()->search($category->id()));
    }

    /** @test */
    public function it_should_not_return_a_non_existing_category(): void
    {
        $this->assertNull($this->repository()->search(CategoryIdMother::create()));
    }
}
