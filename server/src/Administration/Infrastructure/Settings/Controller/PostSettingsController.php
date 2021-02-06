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

use Administration\Domain\Settings\Command\ConfigureSettings;
use Administration\Domain\Settings\Model\VO\Currency;
use Administration\Domain\Settings\Model\VO\Locale;
use Core\Infrastructure\Common\MessengerCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostSettingsController extends AbstractController
{
    private MessengerCommandBus $commandBus;

    public function __construct(MessengerCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @throws \JsonException
     */
    public function __invoke(Request $request): Response
    {
        $settings = \json_decode($request->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        try {
            $command = new ConfigureSettings(
                Locale::fromString($settings['locale']),
                Currency::fromString($settings['currency'])
            );
            $this->commandBus->dispatch($command);
        } catch (\RuntimeException $exception) {
            throw new \DomainException($exception->getMessage());
        }

        return new Response('Settings created started!', Response::HTTP_CREATED);
    }
}
