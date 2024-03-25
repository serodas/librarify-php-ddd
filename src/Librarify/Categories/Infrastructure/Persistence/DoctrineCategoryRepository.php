<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Categories\Infrastructure\Persistence;

use MyLibrary\Librarify\Categories\Domain\Category;
use MyLibrary\Librarify\Categories\Domain\CategoryRepository;
use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineCategoryRepository extends DoctrineRepository implements CategoryRepository
{
    public function save(Category $category): void
    {
        $this->persist($category);
    }

    public function search(CategoryId $id): ?Category
    {
        return $this->repository(Category::class)->find($id);
    }
}
