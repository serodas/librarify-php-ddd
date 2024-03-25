<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Categories\Application\Create;

use MyLibrary\Librarify\Categories\Domain\CategoryName;
use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Shared\Domain\Bus\Command\CommandHandler;

final class CreateCategoryCommandHandler implements CommandHandler
{
    public function __construct(private readonly CategoryCreator $creator)
    {
    }

    public function __invoke(CreateCategoryCommand $command): void
    {
        $id       = new CategoryId($command->id());
        $name     = new CategoryName($command->name());

        $this->creator->__invoke($id, $name);
    }
}
