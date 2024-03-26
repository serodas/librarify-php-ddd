<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Books\Domain;

use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Shared\Domain\Aggregate\AggregateRoot;
use function Lambdish\Phunctional\search;

final class Book extends AggregateRoot
{
    /**
     * @param AuthorId[]|null $authors
     * @param CategoryId[]|null $categories
     */
    public function __construct(
        private readonly BookId $id,
        private BookTitle $title,
        private BookDescription $description,
        private BookScore $score,
        private array $authors,
        private array $categories,
    ) {
    }

    public static function create(
        BookId $id,
        BookTitle $title,
        BookDescription $description,
        BookScore $score,
        $authors,
        $categories
    ): self {
        $Book = new self($id, $title, $description, $score, $authors, $categories);

        $Book->record(new BookCreatedDomainEvent($id->value(), $title->value(), $description->value(), $score->value()));

        return $Book;
    }

    public function id(): BookId
    {
        return $this->id;
    }

    public function title(): BookTitle
    {
        return $this->title;
    }

    public function description(): BookDescription
    {
        return $this->description;
    }

    public function score(): BookScore
    {
        return $this->score;
    }

    public function authors(): array
    {
        return $this->authors;
    }

    public function categories(): array
    {
        return $this->categories;
    }

    public function addAuthor(AuthorId $authorId): void
    {
        $this->authors[] = $authorId;
    }

    public function addCategory(CategoryId $categoryId): void
    {
        $this->categories[] = $categoryId;
    }

    public function hasAuthor(AuthorId $authorId): bool
    {
        $author = search($this->authorIdComparator($authorId), $this->authors());

        return null !== $author;
    }

    public function hasCategory(CategoryId $categoryId): bool
    {
        $category = search($this->categoryIdComparator($categoryId), $this->categories());

        return null !== $category;
    }

    private function authorIdComparator(AuthorId $authorId): callable
    {
        return static fn (AuthorId $other) => $authorId->equals($other);
    }

    private function categoryIdComparator(CategoryId $categoryId): callable
    {
        return static fn (CategoryId $other) => $categoryId->equals($other);
    }
}
