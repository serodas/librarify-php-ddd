<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Shared\Infrastructure\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use MyLibrary\Librarify\Authors\Domain\Author;
use MyLibrary\Librarify\Authors\Domain\AuthorName;
use MyLibrary\Librarify\Authors\Domain\AuthorRepository;
use MyLibrary\Librarify\Categories\Domain\Category;
use MyLibrary\Librarify\Categories\Domain\CategoryName;
use MyLibrary\Librarify\Categories\Domain\CategoryRepository;
use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;

final class BookContext implements Context
{
    public function __construct(
        private AuthorRepository $authorRepository,
        private CategoryRepository $categoryRepository,
    ) {
    }

    /**
     * @Given there is an author with id :authorId
     */
    public function thereIsAnAuthorWithId(string $authorId)
    {
        $author = new Author(new AuthorId($authorId), new AuthorName('Author Name'));
        $this->authorRepository->save($author);
    }

    /**
     * @Given there is a category with id :categoryId
     */
    public function thereIsACategoryWithId(string $categoryId)
    {
        $category = new Category(new CategoryId($categoryId), new CategoryName('category Name'));
        $this->categoryRepository->save($category);
    }
}
