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

namespace Administration\Application\Protocol\Finders;

use Administration\Application\User\ReadModel\Users;
use Administration\Domain\User\Model\User as UserCoreModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

interface UserFinderProtocol extends ServiceEntityRepositoryInterface
{
    public function findOneByUsername(string $username): UserCoreModel;

    public function findOneByUuid(string $uuid): UserCoreModel;

    public function findAllUsers(): Users;
}
