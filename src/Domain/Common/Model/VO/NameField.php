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

namespace Domain\Common\Model\VO;

use Cocur\Slugify\Slugify;
use Domain\Common\Model\Exception\StringExceeds255Characters;

final class NameField
{
    private string $name;

    public function __construct(string $name)
    {
        if (\strlen($name) > 255) {
            throw new StringExceeds255Characters();
        }

        $this->name = $name;
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function getValue(): string
    {
        return $this->name;
    }

    public function slugify(): string
    {
        $slugify = new Slugify();

        return $slugify->slugify($this->name);
    }
}
