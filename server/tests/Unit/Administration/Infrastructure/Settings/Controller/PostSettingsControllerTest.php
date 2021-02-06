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

use Administration\Infrastructure\DataFixtures\SettingsFixtures;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\AbstractControllerTest;

class PostSettingsControllerTest extends AbstractControllerTest
{
    /**
     * @throws \JsonException
     */
    final public function testPostSettingsSuccess(): void
    {
        // Arrange
        $this->loadFixture([]);
        $content = [
            'currency' => 'Euro',
            'locale' => 'Fr',
        ];
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_POST,
            '/api/administration/settings/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );

        // Act
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertSame('Settings created started!', $response->getContent());
    }

    /**
     * @throws \JsonException
     */
    final public function testPostSettingsAlreadyExist(): void
    {
        // Arrange
        $this->loadFixture([new SettingsFixtures()]);
        $content = [
            'currency' => 'Euro',
            'locale' => 'Fr',
        ];

        // Act
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_POST,
            '/api/administration/settings/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }
}
