<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Authors\Application\Create;

use MyLibrary\Librarify\Authors\Application\Create\CreateAuthorCommand;
use MyLibrary\Librarify\Authors\Domain\AuthorName;
use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Tests\Librarify\Authors\Domain\AuthorIdMother;
use MyLibrary\Tests\Librarify\Authors\Domain\AuthorNameMother;

final class CreateAuthorCommandMother
{
    public static function create(
        ?AuthorId $id = null,
        ?AuthorName $name = null,
    ): CreateAuthorCommand {
        return new CreateAuthorCommand(
            $id?->value() ?? AuthorIdMother::create()->value(),
            $name?->value() ?? AuthorNameMother::create()->value(),
        );
    }
}
