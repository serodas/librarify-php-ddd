<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Auth\Domain;

use MyLibrary\Shared\Domain\ValueObject\StringValueObject;

final class AuthPassword extends StringValueObject
{
    public function isEquals(AuthPassword $other): bool
    {
        return $this->value() === $other->value();
    }
}
