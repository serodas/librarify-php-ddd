<?php

declare(strict_types=1);

namespace MyLibrary\Apps\Librarify\Backend\Command\DomainEvents\RabbitMq;

use MyLibrary\Shared\Infrastructure\Bus\Event\RabbitMq\RabbitMqConfigurer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Traversable;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'mylibrary:domain-events:rabbitmq:configure',
    description: 'Configure the RabbitMQ to allow publish & consume domain events'
)]
final class ConfigureRabbitMqCommand extends Command
{
    protected static $defaultName = 'mylibrary:domain-events:rabbitmq:configure';

    public function __construct(
        private RabbitMqConfigurer $configurer,
        private string $exchangeName,
        private Traversable $subscribers
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Configure the RabbitMQ to allow publish & consume domain events');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->configurer->configure($this->exchangeName, ...iterator_to_array($this->subscribers));

        return 0;
    }
}
