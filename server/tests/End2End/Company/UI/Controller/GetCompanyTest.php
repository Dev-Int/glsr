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

namespace End2End\Tests\Company\UI\Controller;

use End2End\Tests\AbstractControllerTest;
use End2End\Tests\DatabaseHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetCompanyTest extends AbstractControllerTest
{
    /**
     * @throws \JsonException
     */
    final public function testGetCompanyWithBadUuid(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user'], ['group' => 'company']]);
        $adminClient = $this->createAdminClient();
        $adminClient->request(Request::METHOD_GET, '/api/companies/626adfca-fc5d-415c-9b7a-7541030bd147');

        // Act
        $response = $adminClient->getResponse();
        $responseDecoded = \json_decode($response->getContent());

        // Assert
        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertSame(Request::METHOD_GET, $responseDecoded->method);
        self::assertSame('Company not found', $responseDecoded->details);
    }

    /**
     * @throws \JsonException
     */
    final public function testGetCompanySuccess(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user'], ['group' => 'company']]);
        $adminClient = $this->createAdminClient();
        $adminClient->request(Request::METHOD_GET, '/api/companies/a136c6fe-8f6e-45ed-91bc-586374791033');

        // Act
        $response = $adminClient->getResponse();
        $responseDecoded = \json_decode($response->getContent());

        // Assert
        self::assertSame(Response::HTTP_OK, $response->getStatusCode());
        self::assertSame('Dev-Int Création', $responseDecoded->companyName);
    }
}
