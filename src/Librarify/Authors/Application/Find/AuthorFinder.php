<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Authors\Application\Find;

use MyLibrary\Librarify\Authors\Domain\AuthorFinder as DomainAuthorFinder;
use MyLibrary\Librarify\Authors\Domain\AuthorRepository;
use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;

final class AuthorFinder
{
    private $finder;

    public function __construct(AuthorRepository $repository)
    {
        $this->finder = new DomainAuthorFinder($repository);
    }

    public function __invoke(AuthorId $id)
    {
        return $this->finder->__invoke($id);
    }
}
