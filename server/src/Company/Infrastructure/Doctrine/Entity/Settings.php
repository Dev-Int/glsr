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

namespace Company\Infrastructure\Doctrine\Entity;

use Company\Domain\Model\Settings as SettingsModel;
use Company\Domain\Model\VO\Currency;
use Company\Domain\Model\VO\Locale;
use Company\Domain\Storage\Settings\SettingsEntity;
use Core\Domain\Common\Model\VO\ResourceUuid;
use Core\Infrastructure\Doctrine\Entity\ResourceUuid as ResourceUuidTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="settings")
 * @ORM\Entity(repositoryClass="Company\Infrastructure\Doctrine\Repository\SettingsRepository")
 */
class Settings implements SettingsEntity
{
    use ResourceUuidTrait;

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
            ResourceUuid::fromUuid($settingsModel->uuid()),
            Locale::fromLocale($settingsModel->locale()),
            Currency::fromCurrency($settingsModel->currency())
        );
    }

    public function toModel(): SettingsModel
    {
        return SettingsModel::create(
            ResourceUuid::fromString($this->uuid),
            Locale::fromString($this->getLocale()),
            Currency::fromString($this->getCurrency())
        );
    }

    public function update(SettingsEntity $settingsEntity): self
    {
        $this->setCurrency($settingsEntity->getCurrency());
        $this->setLocale($settingsEntity->getLocale());

        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    private function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    private function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}
