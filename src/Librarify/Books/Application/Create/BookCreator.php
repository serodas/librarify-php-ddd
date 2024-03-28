<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Books\Application\Create;

use MyLibrary\Librarify\Authors\Application\Find\FindAuthorQuery;
use MyLibrary\Librarify\Books\Domain\Book;
use MyLibrary\Librarify\Books\Domain\BookDescription;
use MyLibrary\Librarify\Books\Domain\BookRepository;
use MyLibrary\Librarify\Books\Domain\BookScore;
use MyLibrary\Librarify\Books\Domain\BookTitle;
use MyLibrary\Librarify\Categories\Application\Find\FindCategoryQuery;
use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Shared\Domain\Bus\Event\EventBus;
use MyLibrary\Shared\Domain\Bus\Query\QueryBus;

final class BookCreator
{
    public function __construct(
        private readonly BookRepository $repository,
        private readonly QueryBus $queryBus,
        private readonly EventBus $bus
    ) {
    }

    /**
     * @param AuthorId[] $authors.
     * @param CategoryId[] $categories.
     */
    public function __invoke(
        BookId $id,
        BookTitle $title,
        BookDescription $description,
        BookScore $score,
        $authors,
        $categories
    ): void {
        foreach ($authors as $authorId) {
            $this->ensureAuthorExist($authorId);
        }

        foreach ($categories as $categoryId) {
            $this->ensureCategoryExist($categoryId);
        }

        $book = Book::create($id, $title, $description, $score, $authors, $categories);

        $this->repository->save($book);
        $this->bus->publish(...$book->pullDomainEvents());
    }

    private function ensureAuthorExist(AuthorId $authorId): void
    {
        $this->queryBus->ask(new FindAuthorQuery($authorId->value()));
    }

    private function ensureCategoryExist(CategoryId $categoryId): void
    {
        $this->queryBus->ask(new FindCategoryQuery($categoryId->value()));
    }
}
