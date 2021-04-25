<?php

declare(strict_types=1);

/*
 * This file is part of the G.L.S.R. Apps package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Infrastructure\Response;

use Symfony\Component\HttpFoundation\Response;

class JsonResponse implements ResponseInterface
{
    public function response(string $responseBody, int $statusCode = 200): Response
    {
        $response = new Response($responseBody, $statusCode);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
