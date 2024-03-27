<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Categories\Application\Find;

use MyLibrary\Shared\Domain\Bus\Query\Query;

final class FindCategoryQuery implements Query
{
    public function __construct(private string $id)
    {
    }

    public function id(): string
    {
        return $this->id;
    }
}
