<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\BooksCounter\Application\Find;

use MyLibrary\Librarify\BooksCounter\Application\Find\BooksCounterFinder;
use MyLibrary\Librarify\BooksCounter\Application\Find\FindBooksCounterQuery;
use MyLibrary\Librarify\BooksCounter\Application\Find\FindBooksCounterQueryHandler;
use MyLibrary\Librarify\BooksCounter\Domain\BooksCounterNotFound;
use MyLibrary\Tests\Librarify\BooksCounter\BooksCounterModuleUnitTestCase;
use MyLibrary\Tests\Librarify\BooksCounter\Domain\BooksCounterMother;

final class FindBooksCounterQueryHandlerTest extends BooksCounterModuleUnitTestCase
{
    private FindBooksCounterQueryHandler|null $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new FindBooksCounterQueryHandler(new BooksCounterFinder($this->repository()));
    }

    /** @test */
    public function it_should_find_an_existing_books_counter(): void
    {
        $counter  = BooksCounterMother::create();
        $query    = new FindBooksCounterQuery();
        $response = BooksCounterResponseMother::create($counter->total());

        $this->shouldSearch($counter);

        $this->assertAskResponse($response, $query, $this->handler);
    }

    /** @test */
    public function it_should_throw_an_exception_when_books_counter_does_not_exists(): void
    {
        $query = new FindBooksCounterQuery();

        $this->shouldSearch(null);

        $this->assertAskThrowsException(BooksCounterNotFound::class, $query, $this->handler);
    }
}