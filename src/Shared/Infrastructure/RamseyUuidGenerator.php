<?php

declare(strict_types=1);

namespace MyLibrary\Shared\Infrastructure;

use MyLibrary\Shared\Domain\UuidGenerator;
use Ramsey\Uuid\Uuid;

final class RamseyUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
