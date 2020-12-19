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

use Administration\Application\Settings\ReadModel\Settings;
use Administration\Domain\Settings\Command\ConfigureSettings;
use Administration\Domain\Settings\Model\VO\Currency;
use Administration\Domain\Settings\Model\VO\Locale;
use Administration\Infrastructure\Settings\Form\Type\SettingsType;
use Core\Infrastructure\Common\MessengerCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostSettingsController extends AbstractController
{
    private MessengerCommandBus $commandBus;

    public function __construct(MessengerCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $settings = $request->request->get('settings');
        $command = new ConfigureSettings(
            Locale::fromString($settings['locale']),
            Currency::fromString($settings['currency'])
        );

        try {
            $this->commandBus->dispatch($command);
        } catch (\RuntimeException $exception) {
            $newSettings = new Settings(
                $command->currency()->getValue(),
                $command->locale()->getValue()
            );
            $form = $this->createForm(SettingsType::class, $newSettings, [
                'action' => $this->generateUrl('admin_settings_configure'),
            ]);
            $this->addFlash('errors', $exception->getMessage());

            return $this->render('Administration/Settings/new.html.twig', [
                'form' => $form->createView(),
                'errors' => $exception,
            ]);
        }

        $this->addFlash('success', 'Settings created started!');

        return new RedirectResponse($this->generateUrl('admin_index'));
    }
}
