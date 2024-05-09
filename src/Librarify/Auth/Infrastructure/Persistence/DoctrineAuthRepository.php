<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Auth\Infrastructure\Persistence;

use MyLibrary\Librarify\Auth\Domain\AuthRepository;
use MyLibrary\Librarify\Auth\Domain\AuthUser;
use MyLibrary\Librarify\Auth\Domain\AuthUsername;
use MyLibrary\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class DoctrineAuthRepository extends DoctrineRepository implements AuthRepository
{
    public function search(AuthUsername $username): ?AuthUser
    {
        return $this->repository(AuthUser::class)->findOneBy(['username' => $username->value() ]);
    }
}
