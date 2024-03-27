<?php

declare(strict_types = 1);

namespace MyLibrary\Librarify\Categories\Application\Find;

use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Shared\Domain\Bus\Query\QueryHandler;

use function Lambdish\Phunctional\apply;
use function Lambdish\Phunctional\pipe;

final class FindCategoryQueryHandler implements QueryHandler
{
    private $finder;

    public function __construct(CategoryFinder $finder)
    {
        $this->finder = pipe($finder, new CategoryResponseConverter());
    }

    public function __invoke(FindCategoryQuery $query): CategoryResponse
    {
        $id = new CategoryId($query->id());

        return apply($this->finder, [$id]);
    }
}
