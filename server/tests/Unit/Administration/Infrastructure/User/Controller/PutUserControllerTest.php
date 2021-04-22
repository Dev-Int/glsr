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

class PutUserControllerTest extends AbstractControllerTest
{
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
            'password' => 'passwords',
            'roles' => ['ROLE_ADMIN', 'ROLE_ASSISTANT'],
        ];
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_PUT,
            '/api/administration/users/a136c6fe-8f6e-45ed-91bc-586374791033',
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
