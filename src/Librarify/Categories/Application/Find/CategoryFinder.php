<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Categories\Application\Find;

use MyLibrary\Librarify\Categories\Domain\CategoryFinder as DomainCategoryFinder;
use MyLibrary\Librarify\Categories\Domain\CategoryRepository;
use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;

final class CategoryFinder
{
    private $finder;

    public function __construct(private CategoryRepository $repository)
    {
        $this->finder = new DomainCategoryFinder($repository);
    }

    public function __invoke(CategoryId $id)
    {
        return $this->finder->__invoke($id);
    }
}
