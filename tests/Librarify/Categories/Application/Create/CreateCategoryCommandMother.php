<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Categories\Application\Create;

use MyLibrary\Librarify\Categories\Application\Create\CreateCategoryCommand;
use MyLibrary\Librarify\Categories\Domain\CategoryName;
use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Tests\Librarify\Categories\Domain\CategoryIdMother;
use MyLibrary\Tests\Librarify\Categories\Domain\CategoryNameMother;

final class CreateCategoryCommandMother
{
    public static function create(
        ?CategoryId $id = null,
        ?CategoryName $name = null,
    ): CreateCategoryCommand {
        return new CreateCategoryCommand(
            $id?->value() ?? CategoryIdMother::create()->value(),
            $name?->value() ?? CategoryNameMother::create()->value(),
        );
    }
}
