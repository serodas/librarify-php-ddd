<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Authors\Application\Create;

use MyLibrary\Librarify\Authors\Application\Create\AuthorCreator;
use MyLibrary\Librarify\Authors\Application\Create\CreateAuthorCommandHandler;
use MyLibrary\Tests\Librarify\Authors\AuthorsModuleUnitTestCase;
use MyLibrary\Tests\Librarify\Authors\Domain\AuthorCreatedDomainEventMother;
use MyLibrary\Tests\Librarify\Authors\Domain\AuthorMother;

final class CreateAuthorCommandHandlerTest extends AuthorsModuleUnitTestCase
{
    private CreateAuthorCommandHandler|null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CreateAuthorCommandHandler(new AuthorCreator($this->repository(), $this->eventBus()));
    }

    /** @test */
    public function it_should_create_a_valid_author(): void
    {
        $command = CreateAuthorCommandMother::create();

        $author      = AuthorMother::fromRequest($command);
        $domainEvent = AuthorCreatedDomainEventMother::fromAuthor($author);

        $this->shouldSave($author);
        $this->shouldPublishDomainEvent($domainEvent);

        $this->dispatch($command, $this->handler);
    }
}
