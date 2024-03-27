<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Authors\Application\Find;

use Mylibrary\Librarify\Authors\Domain\Author;

final class AuthorResponseConverter
{
    public function __invoke(Author $author): AuthorResponse
    {
        return new AuthorResponse(
            $author->id()->value(),
            $author->name()->value(),
        );
    }
}
