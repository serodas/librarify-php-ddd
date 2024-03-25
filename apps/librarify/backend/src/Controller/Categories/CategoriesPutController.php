<?php

declare(strict_types=1);

namespace MyLibrary\Apps\Librarify\Backend\Controller\Categories;

use MyLibrary\Librarify\Categories\Application\Create\CreateCategoryCommand;
use MyLibrary\Shared\Infrastructure\Symfony\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CategoriesPutController extends ApiController
{
    public function __invoke(string $id, Request $request): Response
    {
        $this->dispatch(
            new CreateCategoryCommand(
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
