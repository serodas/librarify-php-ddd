<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Infrastructure\Bus\Event\RabbitMq;

use MyLibrary\Apps\Librarify\Backend\LibrarifyBackendKernel;
use MyLibrary\Shared\Domain\Bus\Event\DomainEvent;
use MyLibrary\Shared\Infrastructure\Bus\Event\DomainEventJsonDeserializer;
use MyLibrary\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineEventBus;
use MyLibrary\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqConfigurer;
use MyLibrary\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqConnection;
use MyLibrary\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqDomainEventsConsumer;
use MyLibrary\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqEventBus;
use MyLibrary\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqQueueNameFormatter;
use MyLibrary\Tests\Librarify\Books\Domain\BookCreatedDomainEventMother;
use MyLibrary\Tests\Librarify\BooksCounter\Domain\BooksCounterIncrementedDomainEventMother;
use MyLibrary\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;
use RuntimeException;
use Throwable;

final class RabbitMqEventBusTest extends InfrastructureTestCase
{
    private $connection;
    private $exchangeName;
    private $configurer;
    private $publisher;
    private $consumer;
    private $fakeSubscriber;
    private $consumerHasBeenExecuted;

    protected function setUp(): void
    {
        parent::setUp();

        $this->connection = $this->service(RabbitMqConnection::class);

        $this->exchangeName            = 'test_domain_events';
        $this->configurer              = new RabbitMqConfigurer($this->connection);
        $this->publisher               = new RabbitMqEventBus(
            $this->connection,
            $this->exchangeName,
            $this->service(MySqlDoctrineEventBus::class)
        );
        $this->consumer                = new RabbitMqDomainEventsConsumer(
            $this->connection,
            $this->service(DomainEventJsonDeserializer::class),
            $this->exchangeName,
            $maxRetries = 1
        );
        $this->fakeSubscriber          = new TestAllWorksOnRabbitMqEventsPublished();
        $this->consumerHasBeenExecuted = false;

        $this->cleanEnvironment($this->connection);
    }

    /** @test */
    public function it_should_publish_and_consume_domain_events_from_rabbitmq(): void
    {
        $domainEvent = BookCreatedDomainEventMother::create();

        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);

        $this->publisher->publish($domainEvent);

        $this->consumer->consume(
            $this->assertConsumer($domainEvent),
            RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
        );

        $this->assertTrue($this->consumerHasBeenExecuted);
    }

    /** @test */
    public function it_should_throw_an_exception_consuming_non_existing_domain_events(): void
    {
        $this->expectException(RuntimeException::class);

        $domainEvent = BooksCounterIncrementedDomainEventMother::create();

        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);

        $this->publisher->publish($domainEvent);

        $this->consumer->consume(
            $this->assertConsumer($domainEvent),
            RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
        );

        $this->assertTrue($this->consumerHasBeenExecuted);
    }

    /** @test */
    public function it_should_retry_failed_domain_events(): void
    {
        $domainEvent = BookCreatedDomainEventMother::create();

        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);

        $this->publisher->publish($domainEvent);

        $this->simulateErrorConsuming();

        sleep(1);

        $this->consumer->consume(
            $this->assertConsumer($domainEvent),
            RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
        );

        $this->assertTrue($this->consumerHasBeenExecuted);
    }

    /** @test */
    public function it_should_send_events_to_dead_letter_after_retry_failed_domain_events(): void
    {
        $domainEvent = BookCreatedDomainEventMother::create();

        $this->configurer->configure($this->exchangeName, $this->fakeSubscriber);

        $this->publisher->publish($domainEvent);

        $this->simulateErrorConsuming();

        sleep(1);

        $this->simulateErrorConsuming();

        $this->assertDeadLetterContainsEvent(1);
    }

    protected function kernelClass(): string
    {
        return LibrarifyBackendKernel::class;
    }

    private function assertConsumer(DomainEvent ...$expectedDomainEvents): callable
    {
        return function (DomainEvent $domainEvent) use ($expectedDomainEvents): void {
            $this->assertContainsEquals($domainEvent, $expectedDomainEvents);

            $this->consumerHasBeenExecuted = true;
        };
    }

    private function failingConsumer(): callable
    {
        return static function (DomainEvent $domainEvent): void {
            throw new RuntimeException('To test');
        };
    }

    private function simulateErrorConsuming(): void
    {
        try {
            $this->consumer->consume(
                $this->failingConsumer(),
                RabbitMqQueueNameFormatter::format($this->fakeSubscriber)
            );
        } catch (Throwable $error) {
            $this->assertInstanceOf(RuntimeException::class, $error);
        }
    }

    private function cleanEnvironment(RabbitMqConnection $connection): void
    {
        $connection->queue(RabbitMqQueueNameFormatter::format($this->fakeSubscriber))->delete();
        $connection->queue(RabbitMqQueueNameFormatter::formatRetry($this->fakeSubscriber))->delete();
        $connection->queue(RabbitMqQueueNameFormatter::formatDeadLetter($this->fakeSubscriber))->delete();
    }

    private function assertDeadLetterContainsEvent(int $expectedNumberOfEvents): void
    {
        $totalEventsInDeadLetter = 0;

        while ($this->connection->queue(RabbitMqQueueNameFormatter::formatDeadLetter($this->fakeSubscriber))->get(
            AMQP_AUTOACK
        )) {
            $totalEventsInDeadLetter++;
        }

        $this->assertSame($expectedNumberOfEvents, $totalEventsInDeadLetter);
    }
}
