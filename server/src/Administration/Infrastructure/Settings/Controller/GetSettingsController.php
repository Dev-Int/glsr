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

use Administration\Infrastructure\Settings\Query\GetSettings;
use Core\Infrastructure\Common\MessengerQueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class GetSettingsController extends AbstractController
{
    private MessengerQueryBus $queryBus;

    public function __construct(MessengerQueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(): Response
    {
        $query = new GetSettings();
        $settings = $this->queryBus->handle($query);

        if (null === $settings) {
            return new RedirectResponse($this->generateUrl('admin_settings_new'));
        }

        return $this->render('Administration/Settings/index.html.twig', [
            'settings' => $settings,
        ]);
    }
}
