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

namespace Unit\Tests\Administration\Infrastructure\FamilyLog\Controller;

use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\AbstractControllerTest;
use Unit\Tests\Fixtures\FamilyLogFixtures;

class DeleteFamilyLogControllerTest extends AbstractControllerTest
{
    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     * @throws \JsonException
     */
    final public function testDeleteFamilyLogWithChildren(): void
    {
        // Arrange
        $this->loadFixtures([new FamilyLogFixtures()]);
        $adminClient = $this->createAdminClient();

        // Act
        $adminClient->request(
            Request::METHOD_DELETE,
            '/api/administration/family-logs/626adfca-fc5d-415c-9b7a-7541030bd147'
        );
        $response = $adminClient->getResponse();

        // Assert
        self::assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        self::assertTrue($response->isServerError());
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     * @throws \JsonException
     */
    final public function testDeleteFamilyLogSuccess(): void
    {
        // Arrange
        $this->loadFixtures([new FamilyLogFixtures()]);
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_DELETE,
            '/api/administration/family-logs/ec9689bb-99d3-4493-b39d-a5b623bba5a0'
        );

        // Act
        $response = $adminClient->getResponse();

        // Assert
        self::assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}
