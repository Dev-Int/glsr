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

namespace Unit\Tests\Administration\Infrastructure\Settings\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\AbstractControllerTest;

class PostSettingsControllerTest extends AbstractControllerTest
{
    final public function testPostSettingsAction(): void
    {
        // Arrange
        $content = [
            'settings' => [
                'currency' => 'Euro',
                'locale' => 'Fr',
            ],
        ];
        $this->client->request(Request::METHOD_POST, '/administration/settings/configure', $content);

        // Act
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
    }
}
