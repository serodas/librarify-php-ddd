<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Books\Application\Create;

use MyLibrary\Librarify\Books\Application\Create\BookCreator;
use MyLibrary\Librarify\Books\Application\Create\CreateBookCommandHandler;
use MyLibrary\Tests\Librarify\Books\BooksModuleUnitTestCase;
use MyLibrary\Tests\Librarify\Books\Domain\BookCreatedDomainEventMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookMother;

final class CreateBookCommandHandlerTest extends BooksModuleUnitTestCase
{
    private CreateBookCommandHandler|null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CreateBookCommandHandler(new BookCreator($this->repository(), $this->eventBus()));
    }

    /** @test */
    public function it_should_create_a_valid_book(): void
    {
        $command = CreateBookCommandMother::create();

        $book        = BookMother::fromRequest($command);

        $domainEvent = BookCreatedDomainEventMother::fromBook($book);

        $this->shouldSearch(null);
        $this->shouldSave($book);
        $this->shouldPublishDomainEvent($domainEvent);

        $this->dispatch($command, $this->handler);
    }
}
