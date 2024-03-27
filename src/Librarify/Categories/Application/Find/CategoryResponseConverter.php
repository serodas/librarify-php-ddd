<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Categories\Application\Find;

use Mylibrary\Librarify\Categories\Domain\Category;

final class CategoryResponseConverter
{
    public function __invoke(Category $category): CategoryResponse
    {
        return new CategoryResponse(
            $category->id()->value(),
            $category->name()->value(),
        );
    }
}
