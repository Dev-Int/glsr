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

namespace Company\Application\Company\Factory;

use Company\Application\Company\DTO\OutputCompany;
use Company\Domain\Model\Company;

class CreateOutputCompany
{
    public function create(Company $company): OutputCompany
    {
        return new OutputCompany($company);
    }
}
