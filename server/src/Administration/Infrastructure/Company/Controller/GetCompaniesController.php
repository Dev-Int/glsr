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

namespace Administration\Infrastructure\Company\Controller;

use Administration\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineCompanyRepository;
use Doctrine\Persistence\ManagerRegistry;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetCompaniesController extends AbstractController
{
    public function __invoke(ManagerRegistry $registry, SerializerInterface $serializer): Response
    {
        $data = (new DoctrineCompanyRepository($registry))->findAll();

        if ([] !== $data) {
            $companies = $serializer->serialize($data, 'json');

            $response = new Response($companies);
            $response->setStatusCode(Response::HTTP_OK);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return new Response('No data found', Response::HTTP_ACCEPTED);
    }
}
