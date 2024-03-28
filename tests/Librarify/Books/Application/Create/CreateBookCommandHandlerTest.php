<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Books\Application\Create;

use MyLibrary\Librarify\Books\Application\Create\BookCreator;
use MyLibrary\Librarify\Books\Application\Create\CreateBookCommandHandler;
use MyLibrary\Tests\Librarify\Authors\Application\Find\AuthorResponseMother;
use MyLibrary\Tests\Librarify\Authors\Application\Find\FindAuthorQueryMother;
use MyLibrary\Tests\Librarify\Books\BooksModuleUnitTestCase;
use MyLibrary\Tests\Librarify\Books\Domain\BookCreatedDomainEventMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookDescriptionMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookIdMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookScoreMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookTitleMother;
use MyLibrary\Tests\Librarify\Categories\Application\Find\CategoryResponseMother;
use MyLibrary\Tests\Librarify\Categories\Application\Find\FindCategoryQueryMother;

final class CreateBookCommandHandlerTest extends BooksModuleUnitTestCase
{
    private CreateBookCommandHandler|null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new CreateBookCommandHandler(new BookCreator($this->repository(), $this->queryBus(), $this->eventBus()));
    }

    /** @test */
    public function it_should_create_a_valid_book(): void
    {
        $command            = CreateBookCommandMother::create();
        $bookId             = BookIdMother::create($command->id());
        $bookTitle          = BookTitleMother::create($command->title());
        $bookDescription    = BookDescriptionMother::create($command->description());
        $bookScore          = BookScoreMother::create($command->score());
        $authors            = $command->authors();
        $categories         = $command->categories();

        foreach ($authors as $authorId) {
            $this->shouldAsk(FindAuthorQueryMother::create($authorId), AuthorResponseMother::withId($authorId));
        }

        foreach ($categories as $categoryId) {
            $this->shouldAsk(FindCategoryQueryMother::create($categoryId), CategoryResponseMother::withId($categoryId));
        }

        $book        = BookMother::create($bookId, $bookTitle, $bookDescription, $bookScore, $authors, $categories);

        $domainEvent = BookCreatedDomainEventMother::fromBook($book);

        $this->shouldSave($book);
        $this->shouldPublishDomainEvent($domainEvent);

        $this->dispatch($command, $this->handler);
    }
}
