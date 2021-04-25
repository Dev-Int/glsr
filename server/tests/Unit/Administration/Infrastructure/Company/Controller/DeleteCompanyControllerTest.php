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

namespace Unit\Tests\Administration\Infrastructure\Company\Controller;

use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\AbstractControllerTest;
use Unit\Tests\DatabaseHelper;

class DeleteCompanyControllerTest extends AbstractControllerTest
{
    /**
     * @throws \JsonException
     */
    final public function testDeleteCompanyFailWithBadUuid(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user'], ['group' => 'company']]);
        $adminClient = $this->createAdminClient();

        // Act
        $adminClient->request('DELETE', '/api/administration/companies/626adfca-fc5d-415c-9b7a-7541030bd147');
        $response = $adminClient->getResponse();

        // Assert
        self::assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }

    /**
     * @throws \JsonException
     */
    final public function testDeleteCompanySuccess(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user'], ['group' => 'company']]);
        $adminClient = $this->createAdminClient();
        $adminClient->request('DELETE', '/api/administration/companies/a136c6fe-8f6e-45ed-91bc-586374791033');

        // Act
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }
}
