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

use Administration\Domain\Company\Model\Company;
use Administration\Infrastructure\Company\Form\CompanyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetEditCompanyController extends AbstractController
{
    public function __invoke(Company $company): Response
    {
        $form = $this->createForm(CompanyType::class, $company, [
            'action' => $this->generateUrl('admin_company_update', ['uuid' => $company->uuid()]),
        ]);

        return $this->render('Administration/Company/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
