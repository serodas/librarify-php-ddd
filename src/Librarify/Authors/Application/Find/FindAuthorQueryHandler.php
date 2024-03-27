<?php

declare(strict_types = 1);

namespace MyLibrary\Librarify\Authors\Application\Find;

use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Shared\Domain\Bus\Query\QueryHandler;

use function Lambdish\Phunctional\apply;
use function Lambdish\Phunctional\pipe;

final class FindAuthorQueryHandler implements QueryHandler
{
    private $finder;

    public function __construct(AuthorFinder $finder)
    {
        $this->finder = pipe($finder, new AuthorResponseConverter());
    }

    public function __invoke(FindAuthorQuery $query): AuthorResponse
    {
        $id = new AuthorId($query->id());

        return apply($this->finder, [$id]);
    }
}
