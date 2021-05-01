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

use Administration\Domain\Settings\Model\Settings as SettingsModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="settings")
 * @ORM\Entity(repositoryClass="Administration\Infrastructure\Persistence\DoctrineOrm\Repositories\DoctrineSettingsRepository")
 */
class Settings
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid", name="uuid")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private string $uuid;

    /**
     * @ORM\Column(type="string", name="locale", nullable=false)
     */
    private string $locale;

    /**
     * @ORM\Column(type="string", name="currency", nullable=false)
     */
    private string $currency;

    public function __construct(string $uuid, string $locale, string $currency)
    {
        $this->uuid = $uuid;
        $this->locale = $locale;
        $this->currency = $currency;
    }

    public static function fromModel(SettingsModel $settingsModel): self
    {
        return new self(
            $settingsModel->uuid(),
            $settingsModel->locale(),
            $settingsModel->currency()
        );
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}
