<?php

declare(strict_types = 1);

namespace MyLibrary\Librarify\Authors\Domain;

use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Shared\Domain\DomainError;

final class AuthorNotFound extends DomainError
{
    private $id;

    public function __construct(AuthorId $id)
    {
        $this->id = $id;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'author_not_found';
    }

    protected function errorMessage(): string
    {
        return sprintf('The author <%s> has not been found', $this->id->value());
    }
}