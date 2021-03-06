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

namespace End2End\Tests\Administration\Infrastructure\Supplier\Controller;

use End2End\Tests\AbstractControllerTest;
use End2End\Tests\DatabaseHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteSupplierControllerTest extends AbstractControllerTest
{
    /**
     * @throws \JsonException
     */
    final public function testDeleteSupplierFailWithBadUuid(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user'], ['group' => 'supplier']]);
        $adminClient = $this->createAdminClient();

        // Act
        $adminClient->request('DELETE', '/api/administration/suppliers/626adfca-fc5d-415c-9b7a-7541030bd147');
        $response = $adminClient->getResponse();

        // Assert
        self::assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }

    /**
     * @throws \JsonException
     */
    final public function testDeleteSupplierSuccess(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user'], ['group' => 'supplier']]);
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_DELETE,
            '/api/administration/suppliers/a136c6fe-8f6e-45ed-91bc-586374791033'
        );

        // Act
        $response = $adminClient->getResponse();

        // Assert
        self::assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}
