<?php

declare(strict_types=1);

namespace MyLibrary\Apps\Librarify\Backend\Command\DomainEvents\RabbitMq;

use MyLibrary\Shared\Infrastructure\Bus\Event\DomainEventSubscriberLocator;
use MyLibrary\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqDomainEventsConsumer;
use MyLibrary\Shared\Infrastructure\Doctrine\DatabaseConnections;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Lambdish\Phunctional\repeat;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'mylibrary:domain-events:rabbitmq:consume',
    description: 'Consume domain events from the RabbitMQ'
)]
final class ConsumeRabbitMqDomainEventsCommand extends Command
{
    protected static $defaultName = 'mylibrary:domain-events:rabbitmq:consume';

    public function __construct(
        private RabbitMqDomainEventsConsumer $consumer,
        private DatabaseConnections $connections,
        private DomainEventSubscriberLocator $locator
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Consume domain events from the RabbitMQ')
            ->addArgument('queue', InputArgument::REQUIRED, 'Queue name')
            ->addArgument('quantity', InputArgument::REQUIRED, 'Quantity of events to process');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $queueName       = (string) $input->getArgument('queue');
        $eventsToProcess = (int) $input->getArgument('quantity');

        repeat($this->consumer($queueName), $eventsToProcess);

        return 0;
    }

    private function consumer(string $queueName): callable
    {
        return function () use ($queueName): void {
            $subscriber = $this->locator->withRabbitMqQueueNamed($queueName);

            $this->consumer->consume($subscriber, $queueName);

            $this->connections->clear();
        };
    }
}
