<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Categories\Application\Find;

use MyLibrary\Shared\Domain\Bus\Query\Response;

final class CategoryResponse implements Response
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
