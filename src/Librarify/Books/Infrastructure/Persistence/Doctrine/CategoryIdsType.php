<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Books\Infrastructure\Persistence\Doctrine;

use MyLibrary\Librarify\Shared\Domain\Categories\CategoryId;
use MyLibrary\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use function Lambdish\Phunctional\map;

final class CategoryIdsType extends JsonType implements DoctrineCustomType
{
    public static function customTypeName(): string
    {
        return 'category_ids';
    }

    public function getName(): string
    {
        return self::customTypeName();
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return parent::convertToDatabaseValue(map(fn (CategoryId $id) => $id->value(), $value), $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        $scalars = parent::convertToPHPValue($value, $platform);

        return map(fn (string $value) => new CategoryId($value), $scalars);
    }
}
