<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Categories\Application\Find;

use MyLibrary\Librarify\Categories\Application\Find\CategoryFinder;
use MyLibrary\Librarify\Categories\Application\Find\FindCategoryQueryHandler;
use MyLibrary\Librarify\Categories\Domain\CategoryNotFound;
use MyLibrary\Shared\Domain\Bus\Query\Query;
use MyLibrary\Tests\Librarify\Categories\CategoriesModuleUnitTestCase;
use MyLibrary\Tests\Librarify\Categories\Domain\CategoryMother;

final class FindCategoryQueryHandlerTest extends CategoriesModuleUnitTestCase
{
    /** @var FindCategoryQueryHandler */
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new FindCategoryQueryHandler(new CategoryFinder($this->repository(), $this->eventBus()));
    }

    /** @test */
    public function it_should_find_an_existing_category(): void
    {
        $category   = CategoryMother::create();
        $query      = FindCategoryQueryMother::create($category->id());

        assert($query instanceof Query);

        $response = CategoryResponseMother::create($category->id(), $category->name());

        $this->shouldSearch($category);

        $this->assertAskResponse($response, $query, $this->handler);
    }

    /** @test */
    public function it_should_throw_an_exception_when_category_does_not_exists(): void
    {
        $query = FindCategoryQueryMother::random();

        assert($query instanceof Query);

        $this->shouldSearch(null);

        $this->assertAskThrowsException(CategoryNotFound::class, $query, $this->handler);
    }
}
