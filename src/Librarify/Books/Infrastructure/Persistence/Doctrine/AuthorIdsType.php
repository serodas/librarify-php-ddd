<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Books\Infrastructure\Persistence\Doctrine;

use MyLibrary\Librarify\Shared\Domain\Authors\AuthorId;
use MyLibrary\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use function Lambdish\Phunctional\map;

final class AuthorIdsType extends JsonType implements DoctrineCustomType
{
    public static function customTypeName(): string
    {
        return 'author_ids';
    }

    public function getName(): string
    {
        return self::customTypeName();
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return parent::convertToDatabaseValue(map(fn (AuthorId $id) => $id->value(), $value), $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $scalars = parent::convertToPHPValue($value, $platform);

        return map(fn (string $value) => new AuthorId($value), $scalars);
    }
}
