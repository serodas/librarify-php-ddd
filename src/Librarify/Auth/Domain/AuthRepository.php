<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Auth\Domain;

interface AuthRepository
{
    public function search(AuthUsername $username): ?AuthUser;
}
