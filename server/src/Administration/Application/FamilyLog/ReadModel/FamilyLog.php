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

namespace Administration\Application\FamilyLog\ReadModel;

final class FamilyLog
{
    public string $name;
    public ?string $parent = null;
    public ?array $children = null;
    public string $path;
    public string $slug;

    public function __construct(string $name, ?string $parent, ?array $children, string $path, string $slug)
    {
        $this->name = $name;
        $this->parent = $parent;
        $this->children = $children;
        $this->path = $path;
        $this->slug = $slug;
    }
}
