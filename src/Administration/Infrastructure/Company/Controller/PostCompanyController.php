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

use Administration\Domain\Company\Command\CreateCompany;
use Domain\Common\Model\VO\EmailField;
use Domain\Common\Model\VO\NameField;
use Domain\Common\Model\VO\PhoneField;
use Administration\Infrastructure\Company\Form\CompanyType;
use Infrastructure\Common\MessengerCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostCompanyController extends AbstractController
{
    private MessengerCommandBus $commandBus;

    public function __construct(MessengerCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $company = $request->request->get('company');

        try {
            $command = new CreateCompany(
                NameField::fromString($company['name']),
                $company['address'],
                $company['zipCode'],
                $company['town'],
                $company['country'],
                PhoneField::fromString($company['phone']),
                PhoneField::fromString($company['facsimile']),
                EmailField::fromString($company['email']),
                $company['contact'],
                PhoneField::fromString($company['cellphone'])
            );
            $this->commandBus->dispatch($command);
        } catch (\DomainException $exception) {
            $form = $this->createForm(CompanyType::class, $company, [
                'action' => $this->generateUrl('admin_company_create'),
            ]);
            $this->addFlash('error', $exception->getMessage());

            return $this->render('Administration/Company/new.html.twig', [
                'form' => $form->createView(),
                'errors' => $exception,
            ]);
        }

        $this->addFlash('success', 'Company created started!');

        return new RedirectResponse($this->generateUrl('admin_company_index'));
    }
}
