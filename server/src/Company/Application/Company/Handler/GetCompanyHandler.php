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

namespace Company\Application\Company\Handler;

use Company\Application\Company\DTO\OutputCompany;
use Company\Application\Company\Factory\CreateOutputCompany;
use Company\Application\Company\Query\GetCompany;
use Company\Domain\Model\Company;
use Company\Domain\Storage\Company\ReadCompany;
use Core\Domain\Common\Query\QueryHandlerInterface;

class GetCompanyHandler implements QueryHandlerInterface
{
    private ReadCompany $readCompany;
    private CreateOutputCompany $createOutputSettings;

    public function __construct(ReadCompany $readCompany, CreateOutputCompany $createOutputSettings)
    {
        $this->readCompany = $readCompany;
        $this->createOutputSettings = $createOutputSettings;
    }

    public function __invoke(GetCompany $query): ?OutputCompany
    {
        $company = $this->readCompany->findOneByUuid($query->uuid());

        if (!$company instanceof Company) {
            return null;
        }

        return $this->createOutputSettings->create($company);
    }
}
