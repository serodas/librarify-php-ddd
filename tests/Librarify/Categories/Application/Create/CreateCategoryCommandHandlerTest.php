<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Categories\Application\Create;

use MyLibrary\Librarify\Categories\Application\Create\CategoryCreator;
use MyLibrary\Librarify\Categories\Application\Create\CreateCategoryCommandHandler;
use MyLibrary\Tests\Librarify\Categories\CategoriesModuleUnitTestCase;
use MyLibrary\Tests\Librarify\Categories\Domain\CategoryCreatedDomainEventMother;
use MyLibrary\Tests\Librarify\Categories\Domain\CategoryMother;

final class CreateCategoryCommandHandlerTest extends CategoriesModuleUnitTestCase
{
    private CreateCategoryCommandHandler|null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CreateCategoryCommandHandler(new CategoryCreator($this->repository(), $this->eventBus()));
    }

    /** @test */
    public function it_should_create_a_valid_category(): void
    {
        $command = CreateCategoryCommandMother::create();

        $category       = CategoryMother::fromRequest($command);
        $domainEvent    = CategoryCreatedDomainEventMother::fromCategory($category);

        $this->shouldSave($category);
        $this->shouldPublishDomainEvent($domainEvent);

        $this->dispatch($command, $this->handler);
    }
}
