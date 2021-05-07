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

namespace Company\Infrastructure\Storage\Company;

use Company\Domain\Exception\CompanyNotFoundException;
use Company\Domain\Model\Company as CompanyModel;
use Company\Domain\Storage\Company\ReadCompany as ReadCompanyDomain;
use Company\Infrastructure\Doctrine\Entity\Company;
use Company\Infrastructure\Doctrine\Repository\CompanyRepository;
use Core\Domain\Common\Model\VO\ResourceUuid;

class ReadCompany implements ReadCompanyDomain
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function findOneByUuid(string $uuid): CompanyModel
    {
        $company = $this->companyRepository->findOneByUuid(ResourceUuid::fromString($uuid));

        if (!$company instanceof Company) {
            throw new CompanyNotFoundException();
        }

        return $company->toModel();
    }

    public function companyExist(): bool
    {
        return $this->companyRepository->companyExist();
    }

    public function findAll(): array
    {
        return $this->companyRepository->findAll();
    }
}
