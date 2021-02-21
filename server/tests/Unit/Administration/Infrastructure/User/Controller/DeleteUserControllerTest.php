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

use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\AbstractControllerTest;

class DeleteUserControllerTest extends AbstractControllerTest
{
    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     * @throws \JsonException
     */
    final public function testDeleteUserSuccess(): void
    {
        // Arrange
        $this->loadFixtures([]);
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            'DELETE',
            '/api/administration/users/a136c6fe-8f6e-45ed-91bc-586374791033'
        );

        // Act
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}