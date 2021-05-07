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

namespace End2End\Tests\Company\UI\Controller\Settings;

use End2End\Tests\AbstractControllerTest;
use End2End\Tests\DatabaseHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetSettingsTest extends AbstractControllerTest
{
    /**
     * @throws \JsonException
     */
    final public function testGetSettingsNoData(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user']]);
        $adminClient = $this->createAdminClient();
        $adminClient->request(Request::METHOD_GET, '/api/settings/');

        // Act
        $response = $adminClient->getResponse();
        $responseDecoded = \json_decode($response->getContent());

        // Assert
        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertEquals('Settings not found', $responseDecoded->details);
        self::assertEquals(Request::METHOD_GET, $responseDecoded->method);
    }

    final public function testGetSettingsSuccess(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user'], ['group' => 'settings']]);
        $adminClient = $this->createAdminClient();
        $adminClient->request(Request::METHOD_GET, '/api/settings/');

        // Act
        $response = $adminClient->getResponse();
        $responseDecoded = \json_decode($response->getContent(), true, 512, \JSON_THROW_ON_ERROR);

        // Assert
        self::assertSame(Response::HTTP_OK, $response->getStatusCode());
        self::assertIsArray($responseDecoded);
        self::assertEquals('a136c6fe-8f6e-45ed-91bc-586374791033', $responseDecoded['uuid']);
    }
}
