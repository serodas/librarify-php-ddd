<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Infrastructure\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use MyLibrary\Shared\Infrastructure\Bus\Event\DomainEventJsonDeserializer;
use MyLibrary\Shared\Infrastructure\Bus\Event\InMemory\InMemorySymfonyEventBus;
use MyLibrary\Shared\Infrastructure\Doctrine\DatabaseConnections;

final class ApplicationFeatureContext implements Context
{
    public function __construct(
        private DatabaseConnections $connections,
        private InMemorySymfonyEventBus $bus,
        private DomainEventJsonDeserializer $deserializer
    ) {
    }

    /** @BeforeScenario */
    public function cleanEnvironment(): void
    {
        $this->connections->clear();
        $this->connections->truncate();
    }

    /**
     * @Given /^I send an event to the event bus:$/
     */
    public function iSendAnEventToTheEventBus(PyStringNode $event): void
    {
        $domainEvent = $this->deserializer->deserialize($event->getRaw());

        $this->bus->publish($domainEvent);
    }
}
