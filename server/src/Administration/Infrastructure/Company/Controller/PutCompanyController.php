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

use Administration\Domain\Company\Command\EditCompany;
use Administration\Infrastructure\Company\Form\CompanyType;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;
use Core\Infrastructure\Common\MessengerCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PutCompanyController extends AbstractController
{
    private MessengerCommandBus $commandBus;

    public function __construct(MessengerCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request, string $uuid): Response
    {
        $company = $request->request->get('company');

        try {
            $command = new EditCompany(
                ContactUuid::fromString($uuid),
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
                'action' => $this->generateUrl('admin_company_edit'),
            ]);
            $this->addFlash('error', $exception->getMessage());

            return $this->render('Administration/Company/edit.html.twig', [
                'form' => $form->createView(),
                'errors' => $exception,
            ]);
        }

        $this->addFlash('success', 'Company updated started!');

        return new RedirectResponse($this->generateUrl('admin_company_index'));
    }
}
