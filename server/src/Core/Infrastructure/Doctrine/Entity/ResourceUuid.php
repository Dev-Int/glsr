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

namespace Core\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ResourceUuid
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid", name="uuid")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected string $uuid;

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
