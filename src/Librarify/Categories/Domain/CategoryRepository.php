<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Categories\Domain;

use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;

interface CategoryRepository
{
    public function save(Category $author): void;

    public function search(CategoryId $id): ?Category;
}
