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

class GetUser extends AbstractController
{
    private JsonResponse $jsonResponse;
    private ReadUser $readUser;

    public function __construct(JsonResponse $jsonResponse, SerializerInterface $serializer, ReadUser $readUser)
    {
        parent::__construct($serializer);

        $this->jsonResponse = $jsonResponse;
        $this->readUser = $readUser;
    }

    public function __invoke(string $uuid): Response
    {
        $user = $this->readUser->findOneByUuid($uuid);

        return $this->jsonResponse->response($this->serialize($user));
    }
}
