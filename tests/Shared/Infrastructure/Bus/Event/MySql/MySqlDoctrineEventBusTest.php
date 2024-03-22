<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Infrastructure\Bus\Event\MySql;

use MyLibrary\Apps\Librarify\Backend\LibrarifyBackendKernel;
use MyLibrary\Shared\Infrastructure\Bus\Event\DomainEventMapping;
use MyLibrary\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineDomainEventsConsumer;
use MyLibrary\Shared\Infrastructure\Bus\Event\MySql\MySqlDoctrineEventBus;
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

    protected function kernelClass(): string
    {
        return LibrarifyBackendKernel::class;
    }
}
