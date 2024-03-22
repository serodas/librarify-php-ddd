<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Authors\Application\Create;

use MyLibrary\Shared\Domain\Bus\Command\Command;

final class CreateAuthorCommand implements Command
{
    public function __construct(private readonly string $id, private readonly string $name)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}
