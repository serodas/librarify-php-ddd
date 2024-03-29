<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Backoffice\Books\Infrastructure\Persistence;

use MyLibrary\Tests\Backoffice\Books\BackofficeBooksModuleInfrastructureTestCase;
use MyLibrary\Tests\Backoffice\Books\Domain\BackofficeBookCriteriaMother;
use MyLibrary\Tests\Backoffice\Books\Domain\BackofficeBookMother;
use MyLibrary\Tests\Shared\Domain\Criteria\CriteriaMother;

final class ElasticsearchBackofficeBookRepositoryTest extends BackofficeBooksModuleInfrastructureTestCase
{
    /** @test */
    public function it_should_save_a_valid_book(): void
    {
        $this->elasticRepository()->save(BackofficeBookMother::create());
    }

    /** @test */
    public function it_should_search_all_existing_books(): void
    {
        $existingBook        = BackofficeBookMother::create();
        $anotherExistingBook = BackofficeBookMother::create();
        $existingBooks       = [$existingBook, $anotherExistingBook];

        $this->elasticRepository()->save($existingBook);
        $this->elasticRepository()->save($anotherExistingBook);

        $this->eventually(fn () => $this->assertSimilar($existingBooks, $this->elasticRepository()->searchAll()));
    }

    /** @test */
    public function it_should_search_all_existing_books_with_an_empty_criteria(): void
    {
        $existingBook        = BackofficeBookMother::create();
        $anotherExistingBook = BackofficeBookMother::create();
        $existingBooks       = [$existingBook, $anotherExistingBook];

        $this->elasticRepository()->save($existingBook);
        $this->elasticRepository()->save($anotherExistingBook);

        $this->eventually(
            fn () => $this->assertSimilar(
                $existingBooks,
                $this->elasticRepository()->matching(CriteriaMother::empty())
            )
        );
    }

    /** @test */
    public function it_should_filter_by_criteria(): void
    {
        $dddInPhpBook       = BackofficeBookMother::create(title: 'DDD en PHP');
        $dddInJavaBook      = BackofficeBookMother::create(title: 'DDD en Java');
        $phpMicroservices   = BackofficeBookMother::create(title: 'PHP Microservices');
        $dddBooks           = [$dddInPhpBook, $dddInJavaBook];

        $nameContainsDddCriteria = BackofficeBookCriteriaMother::titleContains('DDD');

        $this->elasticRepository()->save($dddInJavaBook);
        $this->elasticRepository()->save($dddInPhpBook);
        $this->elasticRepository()->save($phpMicroservices);

        $this->eventually(
            fn () => $this->assertSimilar($dddBooks, $this->elasticRepository()->matching($nameContainsDddCriteria))
        );
    }
}