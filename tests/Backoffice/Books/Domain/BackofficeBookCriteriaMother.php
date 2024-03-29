<?php

declare(strict_types=1);

namespace MyLibrary\Tests\Backoffice\Books\Domain;

use MyLibrary\Shared\Domain\Criteria\Criteria;
use MyLibrary\Tests\Shared\Domain\Criteria\CriteriaMother;
use MyLibrary\Tests\Shared\Domain\Criteria\FilterMother;
use MyLibrary\Tests\Shared\Domain\Criteria\FiltersMother;

final class BackofficeBookCriteriaMother
{
    public static function titleContains(string $text): Criteria
    {
        return CriteriaMother::create(
            FiltersMother::createOne(
                FilterMother::fromValues(
                    [
                        'field'    => 'title',
                        'operator' => 'CONTAINS',
                        'value'    => $text,
                    ]
                )
            )
        );
    }
}