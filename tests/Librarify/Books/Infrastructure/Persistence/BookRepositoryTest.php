<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Books\Infrastructure\Persistence;

use MyLibrary\Tests\Librarify\Books\BooksModuleInfrastructureTestCase;
use MyLibrary\Tests\Librarify\Books\Domain\BookIdMother;
use MyLibrary\Tests\Librarify\Books\Domain\BookMother;

final class BookRepositoryTest extends BooksModuleInfrastructureTestCase
{
    /** @test */
    public function it_should_save_a_book(): void
    {
        $book = BookMother::create();

        $this->repository()->save($book);
    }

    /** @test */
    public function it_should_return_an_existing_book(): void
    {
        $book = BookMother::create();

        $this->repository()->save($book);

        $this->assertEquals($book, $this->repository()->search($book->id()));
    }

    /** @test */
    public function it_should_not_return_a_non_existing_book(): void
    {
        $this->assertNull($this->repository()->search(BookIdMother::create()));
    }
}
