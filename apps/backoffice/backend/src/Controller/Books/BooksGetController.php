<?php

declare(strict_types=1);

namespace MyLibrary\Apps\Backoffice\Backend\Controller\Books;

use MyLibrary\Backoffice\Books\Application\BackofficeBookResponse;
use MyLibrary\Backoffice\Books\Application\BackofficeBooksResponse;
use MyLibrary\Backoffice\Books\Application\SearchByCriteria\SearchBackofficeBooksByCriteriaQuery;
use MyLibrary\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use function Lambdish\Phunctional\map;

final class BooksGetController
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $orderBy = $request->query->get('order_by');
        $order = $request->query->get('order');
        $limit  = $request->query->get('limit');
        $offset = $request->query->get('offset');

        /** @var BackofficeBooksResponse $response */
        $response = $this->queryBus->ask(
            new SearchBackofficeBooksByCriteriaQuery(
                (array) $request->query->get('filters'),
                null === $orderBy ? null : (string) $orderBy,
                null === $order ? null : (string) $order,
                null === $limit ? null : (int) $limit,
                null === $offset ? null : (int) $offset
            )
        );

        return new JsonResponse(
            map(
                fn (BackofficeBookResponse $book) => [
                    'id'            => $book->id(),
                    'title'         => $book->title(),
                    'description'   => $book->description(),
                    'score'         => $book->score(),
                ],
                $response->Books()
            ),
            200,
            ['Access-Control-Allow-Origin' => '*']
        );
    }
}