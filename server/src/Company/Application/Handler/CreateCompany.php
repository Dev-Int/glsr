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

namespace Company\Application\Handler;

use Company\Application\Command\CreateCompany as CreateCompanyCommand;
use Company\Application\Factory\CreateCompany as CreateCompanyFactory;
use Company\Domain\Exception\CompanyAlreadyExistException;
use Company\Infrastructure\Storage\ReadCompany;
use Company\Infrastructure\Storage\SaveCompany;
use Core\Domain\Protocol\Common\Command\CommandHandlerInterface;

final class CreateCompany implements CommandHandlerInterface
{
    private ReadCompany $readCompany;
    private SaveCompany $saveCompany;
    private CreateCompanyFactory $createCompany;

    public function __construct(
        ReadCompany $readCompany,
        SaveCompany $saveCompany,
        CreateCompanyFactory $createCompany
    ) {
        $this->readCompany = $readCompany;
        $this->saveCompany = $saveCompany;
        $this->createCompany = $createCompany;
    }

    public function __invoke(CreateCompanyCommand $command): void
    {
        if ($this->readCompany->companyExist()) {
            throw new CompanyAlreadyExistException();
        }

        $company = $this->createCompany->createCompany($command);

        $this->saveCompany->save($company);
    }
}
