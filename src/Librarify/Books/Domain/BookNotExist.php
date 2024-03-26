<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Books\Domain;

use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Shared\Domain\DomainError;

final class BookNotExist extends DomainError
{
    public function __construct(private readonly BookId $id)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'book_not_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('The Book <%s> does not exist', $this->id->value());
    }
}
