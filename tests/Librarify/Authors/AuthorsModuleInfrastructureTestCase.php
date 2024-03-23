<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Authors;

use MyLibrary\Librarify\Authors\Domain\AuthorRepository;
use MyLibrary\Tests\Librarify\Shared\Infrastructure\PhpUnit\LibrarifyContextInfrastructureTestCase;

abstract class AuthorsModuleInfrastructureTestCase extends LibrarifyContextInfrastructureTestCase
{
    protected function repository(): AuthorRepository
    {
        return $this->service(AuthorRepository::class);
    }
}
