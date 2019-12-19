<?php

declare(strict_types=1);

namespace Domain\Model\Article\Entities;

use Domain\Model\Common\VO\NameField;

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
     * @param NameField $name
     */
    public function __construct(NameField $name)
    {
        $this->name = $name->getValue();
        $this->slug = $name->slugify();
    }
}
