<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\BooksCounter\Application\Increment;

use MyLibrary\Librarify\BooksCounter\Application\Increment\BooksCounterIncrementer;
use MyLibrary\Librarify\BooksCounter\Application\Increment\IncrementBooksCounterOnBookCreated;
use MyLibrary\Tests\Librarify\Books\Domain\BookCreatedDomainEventMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookIdMother;
use MyLibrary\Tests\Librarify\BooksCounter\BooksCounterModuleUnitTestCase;
use MyLibrary\Tests\Librarify\BooksCounter\Domain\BooksCounterIncrementedDomainEventMother;
use MyLibrary\Tests\Librarify\BooksCounter\Domain\BooksCounterMother;

final class IncrementBooksCounterOnBookCreatedTest extends BooksCounterModuleUnitTestCase
{
    private IncrementBooksCounterOnBookCreated|null $subscriber;

    protected function setUp(): void
    {
        parent::setUp();

        $this->subscriber = new IncrementBooksCounterOnBookCreated(
            new BooksCounterIncrementer(
                $this->repository(),
                $this->uuidGenerator(),
                $this->eventBus()
            )
        );
    }

    /** @test */
    public function it_should_initialize_a_new_counter(): void
    {
        $event = BookCreatedDomainEventMother::create();

        $bookId      = BookIdMother::create($event->aggregateId());
        $newCounter  = BooksCounterMother::withOne($bookId);
        $domainEvent = BooksCounterIncrementedDomainEventMother::fromCounter($newCounter);

        $this->shouldSearch(null);
        $this->shouldGenerateUuid($newCounter->id()->value());
        $this->shouldSave($newCounter);
        $this->shouldPublishDomainEvent($domainEvent);

        $this->notify($event, $this->subscriber);
    }

    /** @test */
    public function it_should_increment_an_existing_counter(): void
    {
        $event = BookCreatedDomainEventMother::create();

        $bookId             = BookIdMother::create($event->aggregateId());
        $existingCounter    = BooksCounterMother::create();
        $incrementedCounter = BooksCounterMother::incrementing($existingCounter, $bookId);
        $domainEvent        = BooksCounterIncrementedDomainEventMother::fromCounter($incrementedCounter);

        $this->shouldSearch($existingCounter);
        $this->shouldSave($incrementedCounter);
        $this->shouldPublishDomainEvent($domainEvent);

        $this->notify($event, $this->subscriber);
    }

    /** @test */
    public function it_should_not_increment_an_already_incremented_book(): void
    {
        $event = BookCreatedDomainEventMother::create();

        $bookId          = BookIdMother::create($event->aggregateId());
        $existingCounter = BooksCounterMother::withOne($bookId);

        $this->shouldSearch($existingCounter);

        $this->notify($event, $this->subscriber);
    }
}
