<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Categories;

use MyLibrary\Librarify\Categories\Domain\CategoryRepository;
use MyLibrary\Tests\Librarify\Shared\Infrastructure\PhpUnit\LibrarifyContextInfrastructureTestCase;

abstract class CategoriesModuleInfrastructureTestCase extends LibrarifyContextInfrastructureTestCase
{
    protected function repository(): CategoryRepository
    {
        return $this->service(CategoryRepository::class);
    }
}
