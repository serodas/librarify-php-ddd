<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Categories\Domain;

use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;

final class CategoryFinder
{
    public function __construct(private CategoryRepository $repository)
    {
    }

    public function __invoke(CategoryId $id): Category
    {
        $Category = $this->repository->search($id);

        $this->ensureCategoryExists($id, $Category);

        return $Category;
    }

    private function ensureCategoryExists(CategoryId $id, Category $Category = null): void
    {
        if (null === $Category) {
            throw new CategoryNotFound($id);
        }
    }
}
