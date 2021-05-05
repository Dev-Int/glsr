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

namespace Company\Application\Settings\Handler;

use Company\Application\Settings\DTO\OutputSettings;
use Company\Application\Settings\Factory\CreateOutputSettings;
use Company\Application\Settings\Query\GetSettings;
use Company\Domain\Model\VO\Currency;
use Company\Domain\Model\VO\Locale;
use Company\Domain\Storage\Settings\ReadSettings;
use Core\Domain\Common\Query\QueryHandlerInterface;

class GetSettingsHandler implements QueryHandlerInterface
{
    private ReadSettings $readSettings;
    private CreateOutputSettings $createOutputSettings;

    public function __construct(ReadSettings $readSettings, CreateOutputSettings $createOutputSettings)
    {
        $this->readSettings = $readSettings;
        $this->createOutputSettings = $createOutputSettings;
    }

    public function __invoke(GetSettings $query): ?OutputSettings
    {
        if (null === $query->currency() && null === $query->locale()) {
            $settingsModel = $this->readSettings->findDefaultSettings();

            return $this->createOutputSettings->create($settingsModel);
        }
        if (null !== $query->locale()) {
            $settingsModel = $this->readSettings->findByLocale(Locale::fromString($query->locale()));

            return $this->createOutputSettings->create($settingsModel);
        }
        if (null !== $query->currency()) {
            $settingsModel = $this->readSettings->findByCurrency(Currency::fromString($query->currency()));

            return $this->createOutputSettings->create($settingsModel);
        }

        return null;
    }
}
