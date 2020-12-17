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

namespace Infrastructure\Administration\Company\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineCompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetCompanyIndexController extends AbstractController
{
    public function __invoke(ManagerRegistry $registry): Response
    {
        $companies = (new DoctrineCompanyRepository($registry))->findAll();

        return $this->render('Administration/Company/index.html.twig', [
            'companies' => $companies,
        ]);
    }
}
