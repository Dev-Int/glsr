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

namespace End2End\Tests\User\UI\Controller;

use End2End\Tests\AbstractControllerTest;
use End2End\Tests\DatabaseHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditUserTest extends AbstractControllerTest
{
    /**
     * @throws \JsonException
     */
    final public function testPutUserFailWithBadUuid(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user']]);
        $content = [
            'username' => 'Laurent',
            'email' => 'laurent@example.com',
            'password' => 'Password-1',
            'roles' => ['ROLE_ADMIN', 'ROLE_ASSISTANT'],
        ];
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_PUT,
            '/api/users/626adfca-fc5d-415c-9b7a-7541030bd147',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );

        // Act
        $response = $this->client->getResponse();
        $responseDecoded = \json_decode($response->getContent());

        // Assert
        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertSame(Request::METHOD_PUT, $responseDecoded->method);
        self::assertSame('User already exist', $responseDecoded->details);
    }

    /**
     * @throws \JsonException
     */
    final public function testPutUserSuccess(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user']]);
        $content = [
            'username' => 'Laurent',
            'email' => 'laurent@example.com',
            'password' => 'Password-1',
            'roles' => ['ROLE_ADMIN', 'ROLE_ASSISTANT'],
        ];
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_PUT,
            '/api/users/a136c6fe-8f6e-45ed-91bc-586374791033',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );

        // Act
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertSame('User update started!', $response->getContent());
    }
}
