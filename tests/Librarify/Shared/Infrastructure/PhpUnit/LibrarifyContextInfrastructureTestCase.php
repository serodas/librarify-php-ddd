<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Shared\Infrastructure\PhpUnit;

use MyLibrary\Apps\Librarify\Backend\LibrarifyBackendKernel;
use MyLibrary\Tests\Shared\Infrastructure\PhpUnit\InfrastructureTestCase;
use Doctrine\ORM\EntityManager;

abstract class LibrarifyContextInfrastructureTestCase extends InfrastructureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $arranger = new LibrarifyEnvironmentArranger($this->service(EntityManager::class));

        $arranger->arrange();
    }

    protected function tearDown(): void
    {
        $arranger = new LibrarifyEnvironmentArranger($this->service(EntityManager::class));

        $arranger->close();

        parent::tearDown();
    }

    protected function kernelClass(): string
    {
        return LibrarifyBackendKernel::class;
    }
}
