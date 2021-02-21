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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class GetSettingsController extends AbstractController
{
    private MessengerQueryBus $queryBus;

    public function __construct(MessengerQueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(SerializerInterface $serializer): Response
    {
        $query = new GetSettings();
        $data = $this->queryBus->handle($query);

        if (false === empty($data)) {
            $settings = $serializer->serialize($data, 'json');
            $response = new Response($settings);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return new Response('No data found!', Response::HTTP_ACCEPTED);
    }
}
