<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Authors\Application\Find;

use MyLibrary\Shared\Domain\Bus\Query\Query;

final class FindAuthorQuery implements Query
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
