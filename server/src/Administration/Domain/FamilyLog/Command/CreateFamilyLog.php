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

namespace Administration\Domain\FamilyLog\Command;

use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Protocol\Common\Command\CommandProtocol;

class CreateFamilyLog implements CommandProtocol
{
    private NameField $label;
    private ?string $parentUuid;

    public function __construct(NameField $label, ?string $parentUuid = null)
    {
        $this->label = $label;
        $this->parentUuid = $parentUuid;
    }

    public function label(): NameField
    {
        return $this->label;
    }

    public function parent(): ?string
    {
        return $this->parentUuid;
    }
}
