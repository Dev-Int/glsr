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

use Company\Application\Company\Command\DeleteCompany as DeleteCompanyCommand;
use Company\Domain\Storage\Company\RemoveCompany;
use Core\Domain\Common\Command\CommandHandlerInterface;

final class DeleteCompany implements CommandHandlerInterface
{
    private RemoveCompany $removeCompany;

    public function __construct(RemoveCompany $removeCompany)
    {
        $this->removeCompany = $removeCompany;
    }

    public function __invoke(DeleteCompanyCommand $command): void
    {
        $this->removeCompany->remove($command->uuid());
    }
}
