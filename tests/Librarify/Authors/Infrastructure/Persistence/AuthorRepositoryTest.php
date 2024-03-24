<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Librarify\Authors\Infrastructure\Persistence;

use MyLibrary\Librarify\Authors\Domain\AuthorRepository;
use MyLibrary\Tests\Librarify\Authors\AuthorsModuleInfrastructureTestCase;
use MyLibrary\Tests\Librarify\Authors\Domain\AuthorIdMother;
use MyLibrary\Tests\Librarify\Authors\Domain\AuthorMother;

final class AuthorRepositoryTest extends AuthorsModuleInfrastructureTestCase
{
    /** @test */
    public function it_should_save_a_author(): void
    {
        $author = AuthorMother::create();

        $this->repository()->save($author);
    }

    /** @test */
    public function it_should_return_an_existing_author(): void
    {
        $author = AuthorMother::create();

        $this->repository()->save($author);

        $this->assertEquals($author, $this->repository()->search($author->id()));
    }

    /** @test */
    public function it_should_not_return_a_non_existing_author(): void
    {
        $this->assertNull($this->repository()->search(AuthorIdMother::create()));
    }
}
