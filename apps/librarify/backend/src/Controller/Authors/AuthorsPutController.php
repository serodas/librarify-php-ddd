<?php

declare(strict_types=1);

namespace MyLibrary\Apps\Librarify\Backend\Controller\Authors;

use MyLibrary\Librarify\Authors\Application\Create\CreateAuthorCommand;
use MyLibrary\Shared\Infrastructure\Symfony\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AuthorsPutController extends ApiController
{
    public function __invoke(string $id, Request $request): Response
    {
        $this->dispatch(
            new CreateAuthorCommand(
                $id,
                (string) $request->request->get('name'),
            )
        );

        return new Response('', Response::HTTP_CREATED);
    }

    protected function exceptions(): array
    {
        return [];
    }
}
