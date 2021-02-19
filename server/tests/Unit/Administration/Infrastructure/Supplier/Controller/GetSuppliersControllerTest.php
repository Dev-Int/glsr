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

namespace Unit\Tests\Administration\Infrastructure\Supplier\Controller;

use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\AbstractControllerTest;

class GetSuppliersControllerTest extends AbstractControllerTest
{
    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     * @throws \JsonException
     */
    final public function testGetSupplierNoData(): void
    {
        // Arrange
        $this->loadFixtures([]);
        $adminClient = $this->createAdminClient();
        $adminClient->request(Request::METHOD_GET, '/api/administration/suppliers/');

        // Act
        $response = $adminClient->getResponse();

        // Assert
        self::assertSame(Response::HTTP_ACCEPTED, $response->getStatusCode());
        self::assertSame('No data found', $response->getContent());
    }
}
