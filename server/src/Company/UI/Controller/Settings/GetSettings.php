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

namespace Company\UI\Controller\Settings;

use Company\Application\Settings\DTO\OutputSettings;
use Company\Application\Settings\Query\GetSettings as GetSettingsQuery;
use Company\Domain\Exception\SettingsNotFoundException;
use Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetSettings extends AbstractController
{
    public function __invoke(): Response
    {
        $query = new GetSettingsQuery();
        /** @var OutputSettings $settings */
        $settings = $this->handle($query);

        if (!$settings instanceof OutputSettings) {
            throw new SettingsNotFoundException();
        }

        $settingsSerialized = $this->serialize($settings, ['groups' => 'read']);

        return $this->response($settingsSerialized, Response::HTTP_OK);
    }
}
