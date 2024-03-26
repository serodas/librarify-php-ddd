<?php

declare(strict_types=1);

namespace MyLibrary\Apps\Librarify\Backend\Controller\Books;

use MyLibrary\Librarify\Books\Application\Create\CreateBookCommand;
use MyLibrary\Shared\Infrastructure\Symfony\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class BooksPutController extends ApiController
{
    public function __invoke(string $id, Request $request): Response
    {
        $params = (array) $request->request->all();
        $this->dispatch(
            new CreateBookCommand(
                $id,
                (string) $request->request->get('title'),
                (string) $request->request->get('description'),
                (int) $request->request->get('score'),
                $params['authors'],
                $params['categories'],
            )
        );

        return new Response('', Response::HTTP_CREATED);
    }

    protected function exceptions(): array
    {
        return [];
    }
}
