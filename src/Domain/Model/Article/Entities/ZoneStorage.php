<?php

declare(strict_types=1);

namespace Domain\Model\Article\Entities;

use Domain\Model\Common\Name;

class ZoneStorage
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $slug;

    /**
     * ZoneStorage constructor.
     * @param Name $name
     */
    public function __construct(Name $name)
    {
        $this->name = $name->getValue();
        $this->slug = $name->slugify($this->name);
    }
}
