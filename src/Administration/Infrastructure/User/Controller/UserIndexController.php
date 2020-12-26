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

use Administration\Infrastructure\Finders\DoctrineOrm\DoctrineUserFinder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UserIndexController extends AbstractController
{
    public function __invoke(ManagerRegistry $registry): Response
    {
        $users = (new DoctrineUserFinder($registry))->findAllUsers();

        return $this->render('Administration/User/index.html.twig', [
            'users' => $users->toArray(),
        ]);
    }
}
