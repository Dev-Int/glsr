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

use Domain\Administration\Company\Command\CreateCompany;
use Domain\Common\Model\VO\EmailField;
use Domain\Common\Model\VO\NameField;
use Domain\Common\Model\VO\PhoneField;
use Infrastructure\Common\MessengerCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostCompanyController extends AbstractController
{
    private MessengerCommandBus $commandBus;

    public function __construct(MessengerCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/administration/company/create", methods={"POST"})
     */
    public function __invoke(Request $request): JsonResponse
    {
        $company = $request->request->all();

        if (empty($company['name'])) {
            return new JsonResponse([
                'error' => 'Company \'name\' cannot be empty.',
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

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
            PhoneField::fromString($company['gsm'])
        );
        $this->commandBus->dispatch($command);

        return new JsonResponse([
            'status' => 'Company created started!',
        ], JsonResponse::HTTP_ACCEPTED);
    }
}
