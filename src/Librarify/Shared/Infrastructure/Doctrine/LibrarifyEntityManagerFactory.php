<?php

declare(strict_types=1);

namespace Mylibrary\Librarify\Shared\Infrastructure\Doctrine;

use MyLibrary\Shared\Infrastructure\Doctrine\DoctrineEntityManagerFactory;
use Doctrine\ORM\EntityManagerInterface;

final class LibrarifyEntityManagerFactory
{
    private const SCHEMA_PATH = __DIR__ . '/../../../../../etc/databases/librarify.sql';

    public static function create(array $parameters, string $environment): EntityManagerInterface
    {
        $isDevMode = 'prod' !== $environment;

        $prefixes = array_merge(
            DoctrinePrefixesSearcher::inPath(__DIR__ . '/../../../../Librarify', 'MyLibrary\Librarify'),
        );

        $dbalCustomTypesClasses = DbalTypesSearcher::inPath(__DIR__ . '/../../../../Librarify', 'Librarify');

        return DoctrineEntityManagerFactory::create(
            $parameters,
            $prefixes,
            $isDevMode,
            self::SCHEMA_PATH,
            $dbalCustomTypesClasses
        );
    }
}
