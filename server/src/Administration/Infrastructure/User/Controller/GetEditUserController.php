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
use Administration\Infrastructure\User\Form\UserType;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetEditUserController extends AbstractController
{
    private DoctrineUserFinder $finder;

    public function __construct(DoctrineUserFinder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function __invoke(string $uuid): Response
    {
        $user = $this->finder->findOneByUuid($uuid);
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('admin_user_update', ['uuid' => $uuid]),
            'method' => 'PUT',
        ]);

        return $this->render('Administration/User/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
