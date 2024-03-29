<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Backoffice\Books;

use MyLibrary\Backoffice\Books\Infrastructure\Persistence\ElasticsearchBackofficeBookRepository;
use MyLibrary\Backoffice\Books\Infrastructure\Persistence\MySqlBackofficeBookRepository;
use MyLibrary\Tests\Backoffice\Shared\Infraestructure\PhpUnit\BackofficeContextInfrastructureTestCase;
use Doctrine\ORM\EntityManager;

abstract class BackofficeBooksModuleInfrastructureTestCase extends BackofficeContextInfrastructureTestCase
{
    protected function mySqlRepository(): MySqlBackofficeBookRepository
    {
        return new MySqlBackofficeBookRepository($this->service(EntityManager::class));
    }

    protected function elasticRepository(): ElasticsearchBackofficeBookRepository
    {
        return $this->service(ElasticsearchBackofficeBookRepository::class);
    }
}
