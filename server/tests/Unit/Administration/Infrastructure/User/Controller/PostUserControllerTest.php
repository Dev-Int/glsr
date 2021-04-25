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

namespace Unit\Tests\Administration\Infrastructure\User\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\AbstractControllerTest;
use Unit\Tests\DatabaseHelper;

class PostUserControllerTest extends AbstractControllerTest
{
    /**
     * @throws \JsonException
     */
    final public function testPostUserFailWithUsernameAlreadyExist(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user']]);
        $content = [
            'username' => 'Laurent',
            'email' => 'daniel@example.com',
            'password' => 'password',
            'roles' => ['ROLE_ASSISTANT'],
        ];
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_POST,
            '/api/administration/users/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );

        // Act
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }

    /**
     * @throws \JsonException
     */
    final public function testPostUserFailWithEmailAlreadyExist(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user']]);
        $content = [
            'username' => 'Daniel',
            'email' => 'laurent@example.com',
            'password' => 'password',
            'roles' => ['ROLE_ASSISTANT'],
        ];
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_POST,
            '/api/administration/users/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );

        // Act
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }

    /**
     * @throws \JsonException
     */
    final public function testPostUserSuccess(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user']]);
        $content = [
            'username' => 'Daniel',
            'email' => 'daniel@example.com',
            'password' => 'password',
            'roles' => ['ROLE_ASSISTANT'],
        ];
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_POST,
            '/api/administration/users/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );

        // Act
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertSame('User create started!', $response->getContent());
    }
}
