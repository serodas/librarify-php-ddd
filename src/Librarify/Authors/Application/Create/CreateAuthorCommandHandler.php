<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Authors\Application\Create;

use MyLibrary\Librarify\Authors\Domain\AuthorName;
use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Shared\Domain\Bus\Command\CommandHandler;

final class CreateAuthorCommandHandler implements CommandHandler
{
    public function __construct(private readonly AuthorCreator $creator)
    {
    }

    public function __invoke(CreateAuthorCommand $command): void
    {
        $id       = new AuthorId($command->id());
        $name     = new AuthorName($command->name());

        $this->creator->__invoke($id, $name);
    }
}
