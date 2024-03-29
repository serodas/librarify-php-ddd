<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Backoffice\Shared\Infraestructure\PhpUnit;

use MyLibrary\Shared\Infrastructure\Elasticsearch\ElasticsearchClient;
use MyLibrary\Tests\Shared\Infrastructure\Arranger\EnvironmentArranger;
use MyLibrary\Tests\Shared\Infrastructure\Doctrine\MySqlDatabaseCleaner;
use MyLibrary\Tests\Shared\Infrastructure\Elastic\ElasticDatabaseCleaner;
use Doctrine\ORM\EntityManager;
use function Lambdish\Phunctional\apply;

final class BackofficeEnvironmentArranger implements EnvironmentArranger
{
    public function __construct(private ElasticsearchClient $elasticsearchClient, private EntityManager $entityManager)
    {
    }

    public function arrange(): void
    {
        apply(new ElasticDatabaseCleaner(), [$this->elasticsearchClient]);
        apply(new MySqlDatabaseCleaner(), [$this->entityManager]);
    }

    public function close(): void
    {
    }
}
