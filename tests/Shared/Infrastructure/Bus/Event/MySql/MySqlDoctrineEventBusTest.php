<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Infrastructure\Bus\Event\MySql;

use MyLibrary\Apps\Librarify\Backend\LibrarifyBackendKernel;
use MyLibrary\Shared\Domain\Bus\Event\DomainEvent;
use MyLibrary\Shared\Infrastructure\Bus\Event\DomainEventMapping;
use MyLibrary\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineDomainEventsConsumer;
use MyLibrary\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineEventBus;
use MyLibrary\Tests\Librarify\Books\Domain\BookCreatedDomainEventMother;
use MyLibrary\Tests\Librarify\BooksCounter\Domain\BooksCounterIncrementedDomainEventMother;
use MyLibrary\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;
use Doctrine\ORM\EntityManager;

final class MySqlDoctrineEventBusTest extends InfrastructureTestCase
{
    private MySqlDoctrineEventBus|null             $bus;
    private MySqlDoctrineDomainEventsConsumer|null $consumer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bus      = new MySqlDoctrineEventBus($this->service(EntityManager::class));
        $this->consumer = new MySqlDoctrineDomainEventsConsumer(
            $this->service(EntityManager::class),
            $this->service(DomainEventMapping::class)
        );
    }

    /** @test */
    public function it_should_publish_and_consume_domain_events_from_msql(): void
    {
        $domainEvent        = BookCreatedDomainEventMother::create();
        $anotherDomainEvent = BooksCounterIncrementedDomainEventMother::create();

        $this->bus->publish($domainEvent, $anotherDomainEvent);

        $this->consumer->consume(
            subscribers: fn (DomainEvent ...$expectedEvents) => $this->assertContainsEquals($domainEvent, $expectedEvents),
            eventsToConsume:  2
        );
    }

    protected function kernelClass(): string
    {
        return LibrarifyBackendKernel::class;
    }
}