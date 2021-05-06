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

namespace User\UI\Controller;

use Core\Controller\AbstractController;
use Core\Infrastructure\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use User\Infrastructure\Storage\ReadUser;

class GetUsers extends AbstractController
{
    private JsonResponse $jsonResponse;
    private ReadUser $readUser;

    public function __construct(
        ReadUser $readUser,
        SerializerInterface $serializer,
        JsonResponse $jsonResponse
    ) {
        parent::__construct($serializer);

        $this->jsonResponse = $jsonResponse;
        $this->readUser = $readUser;
    }

    public function __invoke(): Response
    {
        $users = $this->readUser->findAll();

        if (empty($users)) {
            return $this->jsonResponse->response('No data found', Response::HTTP_ACCEPTED);
        }

        return $this->jsonResponse->response($this->serialize($users));
    }
}
