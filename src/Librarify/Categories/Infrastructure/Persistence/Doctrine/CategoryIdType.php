<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Categories\Infrastructure\Persistence\Doctrine;

use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Shared\Infrastructure\Persistence\Doctrine\UuidType;

final class CategoryIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return CategoryId::class;
    }
}
