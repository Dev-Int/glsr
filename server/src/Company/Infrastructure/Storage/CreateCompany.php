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

use Company\Domain\Exception\CompanyAlreadyExistException;
use Company\Domain\Model\Company as CompanyModel;
use Company\Infrastructure\Doctrine\Entity\Company;
use Company\Infrastructure\Doctrine\Repository\CompanyRepository;

class CreateCompany
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function create(CompanyModel $company): void
    {
        if ($this->companyRepository->companyExist()) {
            throw new CompanyAlreadyExistException();
        }

        $companyEntity = Company::fromModel($company);
        $this->companyRepository->save($companyEntity);
    }
}
