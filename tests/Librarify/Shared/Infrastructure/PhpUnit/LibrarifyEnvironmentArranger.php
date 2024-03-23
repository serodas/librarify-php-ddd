<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Shared\Infrastructure\PhpUnit;

use MyLibrary\Tests\Shared\Infrastructure\Arranger\EnvironmentArranger;
use MyLibrary\Tests\Shared\Infrastructure\Doctrine\MySqlDatabaseCleaner;
use Doctrine\ORM\EntityManager;
use function Lambdish\Phunctional\apply;

final class LibrarifyEnvironmentArranger implements EnvironmentArranger
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    public function arrange(): void
    {
        apply(new MySqlDatabaseCleaner(), [$this->entityManager]);
    }

    public function close(): void
    {
    }
}
