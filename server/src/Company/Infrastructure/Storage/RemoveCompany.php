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

namespace Company\Infrastructure\Storage;

use Company\Domain\Exception\CompanyNotFoundException;
use Company\Domain\Storage\RemoveCompany as RemoveCompanyDomain;
use Company\Infrastructure\Doctrine\Entity\Company;
use Company\Infrastructure\Doctrine\Repository\CompanyRepository;
use Core\Domain\Common\Model\VO\ResourceUuid;

class RemoveCompany implements RemoveCompanyDomain
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function remove(string $uuid): void
    {
        $company = $this->companyRepository->findOneByUuid(ResourceUuid::fromString($uuid));

        if (!$company instanceof Company) {
            throw new CompanyNotFoundException();
        }

        $this->companyRepository->remove($company);
    }
}
