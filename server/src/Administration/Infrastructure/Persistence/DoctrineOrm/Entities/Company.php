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

namespace Administration\Infrastructure\Persistence\DoctrineOrm\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="Administration\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineCompanyRepository")
 */
class Company extends Contact
{
}
