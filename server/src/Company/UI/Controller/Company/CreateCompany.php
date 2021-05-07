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

namespace Company\UI\Controller\Company;

use Company\Application\Command\CreateCompany as CreateCompanyCommand;
use Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateCompany extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        /** @var CreateCompanyCommand $companyCommand */
        $companyCommand = $this->deserialize($request->getContent(), CreateCompanyCommand::class);

        $this->dispatch($companyCommand);

        return $this->response('Company create started!');
    }
}
