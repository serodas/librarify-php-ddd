<?php

declare(strict_types=1);

namespace MyLibrary\Apps\Librarify\Backend\Controller\HealthCheck;

use MyLibrary\Shared\Domain\RandomNumberGenerator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class HealthCheckGetController
{
    public function __construct(private RandomNumberGenerator $generator)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(
            [
                'librarify-backend' => 'ok',
                'rand'         => $this->generator->generate(),
            ]
        );
    }
}
