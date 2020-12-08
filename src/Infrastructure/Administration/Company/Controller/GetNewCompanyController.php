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

use Infrastructure\Administration\Company\Form\CreateCompanyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetNewCompanyController extends AbstractController
{
    public function __invoke(): Response
    {
        $form = $this->createForm(CreateCompanyType::class, null, [
            'action' => $this->generateUrl('admin_company_create'),
        ]);

        return $this->render('Administration/Company/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
