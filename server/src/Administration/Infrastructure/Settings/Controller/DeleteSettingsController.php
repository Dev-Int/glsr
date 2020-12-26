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

namespace Administration\Infrastructure\Settings\Controller;

use Administration\Domain\Settings\Command\DeleteSettings;
use Core\Infrastructure\Common\MessengerCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteSettingsController extends AbstractController
{
    private MessengerCommandBus $commandBus;

    public function __construct(MessengerCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request, string $uuid): Response
    {
        try {
            $command = new DeleteSettings($uuid);
            $this->commandBus->dispatch($command);
        } catch (\RuntimeException $exception) {
            $this->addFlash('errors', $exception->getMessage());

            return $this->render('Administration/Settings/index.html.twig', [
                'errors' => $exception,
            ]);
        }
        $this->addFlash('success', 'Settings deleted started!');

        return new RedirectResponse($this->generateUrl('admin_settings_index'));
    }
}
