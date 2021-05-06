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

use Company\Domain\Model\Company as CompanyModel;
use Company\Infrastructure\Doctrine\Repository\CompanyRepository;

class UpdateCompany
{
    private CompanyRepository $companyRepository;
    private ReadCompany $readCompany;

    public function __construct(CompanyRepository $companyRepository, ReadCompany $readCompany)
    {
        $this->companyRepository = $companyRepository;
        $this->readCompany = $readCompany;
    }

    public function update(CompanyModel $companyModel): void
    {
        $companyEntity = $this->readCompany->findOneByUuid($companyModel->uuid());

        $companyEntity->update($companyModel);

        $this->companyRepository->flush();
    }
}
