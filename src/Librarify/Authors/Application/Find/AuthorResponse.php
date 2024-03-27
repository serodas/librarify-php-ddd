<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Authors\Application\Find;

use MyLibrary\Shared\Domain\Bus\Query\Response;

final class AuthorResponse implements Response
{
    public function __construct(private readonly string $id, private readonly string $name)
    {
        $this->id       = $id;
        $this->name     = $name;
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
