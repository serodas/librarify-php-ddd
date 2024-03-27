<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Authors\Application\Find;

use MyLibrary\Librarify\Authors\Application\Find\AuthorFinder;
use MyLibrary\Librarify\Authors\Application\Find\FindAuthorQueryHandler;
use MyLibrary\Librarify\Authors\Domain\AuthorNotFound;
use MyLibrary\Shared\Domain\Bus\Query\Query;
use MyLibrary\Tests\Librarify\Authors\AuthorsModuleUnitTestCase;
use MyLibrary\Tests\Librarify\Authors\Domain\AuthorMother;

final class FindAuthorQueryHandlerTest extends AuthorsModuleUnitTestCase
{
    /** @var FindAuthorQueryHandler */
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new FindAuthorQueryHandler(new AuthorFinder($this->repository(), $this->eventBus()));
    }

    /** @test */
    public function it_should_find_an_existing_author(): void
    {
        $author  = AuthorMother::create();
        $query    = FindAuthorQueryMother::create($author->id());

        assert($query instanceof Query);

        $response = AuthorResponseMother::create($author->id(), $author->name());

        $this->shouldSearch($author);

        $this->assertAskResponse($response, $query, $this->handler);
    }

    /** @test */
    public function it_should_throw_an_exception_when_author_does_not_exists(): void
    {
        $query = FindAuthorQueryMother::random();

        assert($query instanceof Query);

        $this->shouldSearch(null);

        $this->assertAskThrowsException(AuthorNotFound::class, $query, $this->handler);
    }
}
