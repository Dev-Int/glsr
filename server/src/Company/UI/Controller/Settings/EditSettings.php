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

use Company\Application\Settings\Command\EditSettings as EditSettingsCommand;
use Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditSettings extends AbstractController
{
    public function __invoke(Request $request, string $uuid): Response
    {
        /** @var EditSettingsCommand $settingsCommand */
        $settingsCommand = $this->deserialize($request->getContent(), EditSettingsCommand::class);
        $settingsCommand->uuid = $uuid;

        $this->dispatch($settingsCommand);

        return $this->response('Settings updated started!', Response::HTTP_ACCEPTED);
    }
}
