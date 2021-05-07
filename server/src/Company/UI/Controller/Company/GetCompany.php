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

use Company\Application\Company\DTO\OutputCompany;
use Company\Application\Company\Query\GetCompany as GetCompanyQuery;
use Core\Controller\AbstractController;
use Core\Domain\Common\Model\VO\ResourceUuid;
use Core\Domain\Common\Query\QueryInterface;
use Symfony\Component\HttpFoundation\Response;

class GetCompany extends AbstractController
{
    public function __invoke(string $uuid): Response
    {
        /** @var QueryInterface $query */
        $query = new GetCompanyQuery(ResourceUuid::fromString($uuid));
        /** @var OutputCompany $company */
        $company = $this->handle($query);

        return $this->response($this->serialize($company));
    }
}
