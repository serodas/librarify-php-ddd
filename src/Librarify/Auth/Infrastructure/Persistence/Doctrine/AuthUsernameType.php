<?php
namespace MyLibrary\Librarify\Auth\Infrastructure\Persistence\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use MyLibrary\Librarify\Auth\Domain\AuthUsername;
use MyLibrary\Shared\Infrastructure\Doctrine\Dbal\DoctrineCustomType;

class AuthUsernameType extends StringType implements DoctrineCustomType
{
    public static function customTypeName(): string
    {
        return 'username';
    }

    public function getName(): string
    {
        return self::customTypeName();
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof AuthUsername ? $value->value() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new AuthUsername($value);
    }
}
?>