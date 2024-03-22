<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Infrastructure\PhpUnit;

use MyLibrary\Shared\Domain\Bus\Command\Command;
use MyLibrary\Shared\Domain\Bus\Event\DomainEvent;
use MyLibrary\Shared\Domain\Bus\Event\EventBus;
use MyLibrary\Shared\Domain\Bus\Query\Query;
use MyLibrary\Shared\Domain\Bus\Query\Response;
use MyLibrary\Shared\Domain\UuidGenerator;
use MyLibrary\Tests\Shared\Domain\TestUtils;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Matcher\MatcherAbstract;
use Mockery\MockInterface;

abstract class UnitTestCase extends MockeryTestCase
{
    private EventBus|MockInterface|null      $eventBus;
    private UuidGenerator|MockInterface|null $uuidGenerator;

    protected function mock(string $className): MockInterface
    {
        return Mockery::mock($className);
    }

    protected function shouldPublishDomainEvent(DomainEvent $domainEvent): void
    {
        $this->eventBus()
            ->shouldReceive('publish')
            ->with($this->similarTo($domainEvent))
            ->andReturnNull();
    }

    protected function shouldNotPublishDomainEvent(): void
    {
        $this->eventBus()
            ->shouldReceive('publish')
            ->withNoArgs()
            ->andReturnNull();
    }

    protected function eventBus(): EventBus|MockInterface
    {
        return $this->eventBus = $this->eventBus ?? $this->mock(EventBus::class);
    }

    protected function shouldGenerateUuid(string $uuid): void
    {
        $this->uuidGenerator()
            ->shouldReceive('generate')
            ->once()
            ->withNoArgs()
            ->andReturn($uuid);
    }

    protected function uuidGenerator(): UuidGenerator|MockInterface
    {
        return $this->uuidGenerator = $this->uuidGenerator ?? $this->mock(UuidGenerator::class);
    }

    protected function notify(DomainEvent $event, callable $subscriber): void
    {
        $subscriber($event);
    }

    protected function dispatch(Command $command, callable $commandHandler): void
    {
        $commandHandler($command);
    }

    protected function assertAskResponse(Response $expected, Query $query, callable $queryHandler): void
    {
        $actual = $queryHandler($query);

        $this->assertEquals($expected, $actual);
    }

    protected function assertAskThrowsException(string $expectedErrorClass, Query $query, callable $queryHandler): void
    {
        $this->expectException($expectedErrorClass);

        $queryHandler($query);
    }

    protected function isSimilar($expected, $actual): bool
    {
        return TestUtils::isSimilar($expected, $actual);
    }

    protected function assertSimilar($expected, $actual): void
    {
        TestUtils::assertSimilar($expected, $actual);
    }

    protected function similarTo($value, $delta = 0.0): MatcherAbstract
    {
        return TestUtils::similarTo($value, $delta);
    }
}
