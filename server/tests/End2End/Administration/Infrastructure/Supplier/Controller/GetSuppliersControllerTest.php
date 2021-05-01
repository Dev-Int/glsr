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

class GetSuppliersControllerTest extends AbstractControllerTest
{
    /**
     * @throws \JsonException
     */
    final public function testGetSupplierNoData(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user']]);
        $adminClient = $this->createAdminClient();
        $adminClient->request(Request::METHOD_GET, '/api/administration/suppliers/');

        // Act
        $response = $adminClient->getResponse();

        // Assert
        self::assertSame(Response::HTTP_ACCEPTED, $response->getStatusCode());
        self::assertSame('No data found', $response->getContent());
    }

    /**
     * @throws \JsonException
     */
    final public function testGetSuppliersSuccess(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user'], ['group' => 'supplier']]);
        $adminClient = $this->createAdminClient();
        $adminClient->request(Request::METHOD_GET, '/api/administration/suppliers/');

        // Act
        $response = $adminClient->getResponse();

        // Assert
        self::assertSame(Response::HTTP_OK, $response->getStatusCode());
        $content = \json_decode($response->getContent(), true, 512, \JSON_THROW_ON_ERROR);
        self::assertIsArray($content);
        self::assertEquals('a136c6fe-8f6e-45ed-91bc-586374791033', $content[0]['uuid']);
    }
}
