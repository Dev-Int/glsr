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

use Company\Application\Company\Command\EditCompany as EditCompanyCommand;
use Company\Application\Company\Factory\CreateCompany as CreateCompanyFactory;
use Company\Domain\Storage\Company\SaveCompany;
use Core\Domain\Common\Command\CommandHandlerInterface;

final class EditCompany implements CommandHandlerInterface
{
    private SaveCompany $saveCompany;
    private CreateCompanyFactory $createCompany;

    public function __construct(SaveCompany $saveCompany, CreateCompanyFactory $createCompany)
    {
        $this->saveCompany = $saveCompany;
        $this->createCompany = $createCompany;
    }

    public function __invoke(EditCompanyCommand $command): void
    {
        $this->saveCompany->save(
            $this->createCompany->createCompany($command)
        );
    }
}
