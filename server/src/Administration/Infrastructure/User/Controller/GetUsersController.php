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

namespace Administration\Infrastructure\User\Controller;

use Administration\Infrastructure\Finders\Doctrine\DoctrineUserFinder;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class GetUsersController extends AbstractController
{
    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    public function __invoke(Connection $connection, SerializerInterface $serializer): Response
    {
        $data = (new DoctrineUserFinder($connection))->findAllUsers()->toArray();

        if ([] !== $data) {
            $users = $serializer->serialize($data, 'json');

            $response = new Response($users);
            $response->setStatusCode(Response::HTTP_OK);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return new Response('No data found', Response::HTTP_ACCEPTED);
    }
}