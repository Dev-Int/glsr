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
use Company\Domain\Model\Company as CompanyModel;
use Company\Domain\Storage\SaveCompany as SaveCompanyDomain;

class SaveCompany implements SaveCompanyDomain
{
    private UpdateCompany $updateCompany;
    private CreateCompany $createCompany;

    public function __construct(
        UpdateCompany $updateCompany,
        CreateCompany $createCompany
    ) {
        $this->updateCompany = $updateCompany;
        $this->createCompany = $createCompany;
    }

    public function save(CompanyModel $company): void
    {
        try {
            $this->updateCompany->update($company);
        } catch (CompanyNotFoundException $companyNotFoundException) {
            $this->createCompany->create($company);
        }
    }
}
