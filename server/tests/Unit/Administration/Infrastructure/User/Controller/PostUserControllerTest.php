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

use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\AbstractControllerTest;

class PostUserControllerTest extends AbstractControllerTest
{
    final public function testPostUserAction(): void
    {
        // Arrange
        $content = [
            'user' => [
                'username' => 'Laurent',
                'email' => 'laurent@example.com',
                'password' => [
                    'first' => 'password',
                    'second' => 'password',
                ],
                'roles' => ['ROLE_ADMIN', 'ROLE_ASSISTANT'],
            ],
        ];
        $this->client->request('POST', '/administration/user/create', $content);

        // Act
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertTrue($response->isRedirect('/administration/user/'));
    }
}
