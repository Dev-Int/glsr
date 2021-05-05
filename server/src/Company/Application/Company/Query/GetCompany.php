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

namespace Company\Application\Company\Query;

use Core\Domain\Common\Model\VO\ResourceUuid;
use Core\Domain\Common\Query\QueryInterface;

final class GetCompany implements QueryInterface
{
    private string $uuid;

    public function __construct(ResourceUuid $resourceUuid)
    {
        $this->uuid = $resourceUuid->toString();
    }

    public function uuid(): string
    {
        return $this->uuid;
    }
}
