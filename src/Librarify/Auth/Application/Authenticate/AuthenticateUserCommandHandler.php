<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Auth\Application\Authenticate;

use MyLibrary\Librarify\Auth\Domain\AuthPassword;
use MyLibrary\Librarify\Auth\Domain\AuthUsername;
use MyLibrary\Shared\Domain\Bus\Command\CommandHandler;

final class AuthenticateUserCommandHandler implements CommandHandler
{
    public function __construct(private readonly UserAuthenticator $authenticator)
    {
    }

    public function __invoke(AuthenticateUserCommand $command): void
    {
        $username = new AuthUsername($command->username());
        $password = new AuthPassword($command->password());

        $this->authenticator->authenticate($username, $password);
    }
}
