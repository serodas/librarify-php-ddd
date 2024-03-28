<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\BooksCounter\Domain;

use RuntimeException;

final class BooksCounterNotFound extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('The books counter not exist');
    }
}