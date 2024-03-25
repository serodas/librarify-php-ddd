<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Categories\Application\Create;

use MyLibrary\Librarify\Categories\Domain\Category;
use MyLibrary\Librarify\Categories\Domain\CategoryName;
use MyLibrary\Librarify\Categories\Domain\CategoryRepository;
use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Shared\Domain\Bus\Event\EventBus;

final class CategoryCreator
{
    public function __construct(private readonly CategoryRepository $repository, private readonly EventBus $bus)
    {
    }

    public function __invoke(CategoryId $id, CategoryName $name): void
    {
        $category = Category::create($id, $name);

        $this->repository->save($category);
        $this->bus->publish(...$category->pullDomainEvents());
    }
}
