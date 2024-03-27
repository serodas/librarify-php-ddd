<?php

declare(strict_types = 1);

namespace MyLibrary\Librarify\Categories\Domain;

use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Shared\Domain\DomainError;

final class CategoryNotFound extends DomainError
{
    public function __construct(private CategoryId $id)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'category_not_found';
    }

    protected function errorMessage(): string
    {
        return sprintf('The category <%s> has not been found', $this->id->value());
    }
}