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
use Unit\Tests\Fixtures\SupplierFixtures;

class DeleteSupplierControllerTest extends AbstractControllerTest
{
    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     * @throws \JsonException
     */
    final public function testDeleteSupplierSuccess(): void
    {
        // Arrange
        $this->loadFixtures([new SupplierFixtures()]);
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
