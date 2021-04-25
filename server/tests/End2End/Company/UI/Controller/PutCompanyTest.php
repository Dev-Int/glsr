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

class PutCompanyTest extends AbstractControllerTest
{
    /**
     * @throws \JsonException
     */
    final public function testPutCompanyFailWithBadUuid(): void
    {
        // Arrange
        $content = [
            'companyName' => 'Dev-Int Création',
            'address' => '2 rue des ERP',
            'zipCode' => '56000',
            'town' => 'VANNES',
            'country' => 'France',
            'phone' => '+33100000001',
            'facsimile' => '+33100000002',
            'email' => 'contact@developpement-interessant.com',
            'contactName' => 'Laurent Quétier',
            'cellphone' => '+33100000002',
        ];
        DatabaseHelper::loadFixtures([['group' => 'user'], ['group' => 'company']]);
        $adminClient = $this->createAdminClient();

        // Act
        $adminClient->request(
            Request::METHOD_PUT,
            '/api/companies/626adfca-fc5d-415c-9b7a-7541030bd147',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );
        $response = $adminClient->getResponse();
        $responseDecoded = \json_decode($response->getContent());

        // Assert
        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertSame(Request::METHOD_PUT, $responseDecoded->method);
        self::assertSame('Company already exist', $responseDecoded->details);
    }

    /**
     * @throws \JsonException
     */
    final public function testPutCompanySuccess(): void
    {
        // Arrange
        $content = [
            'companyName' => 'Dev-Int Création',
            'address' => '2 rue des ERP',
            'zipCode' => '56000',
            'town' => 'VANNES',
            'country' => 'France',
            'phone' => '+33100000001',
            'facsimile' => '+33100000002',
            'email' => 'contact@developpement-interessant.com',
            'contactName' => 'Laurent Quétier',
            'cellphone' => '+33100000002',
        ];
        DatabaseHelper::loadFixtures([['group' => 'user'], ['group' => 'company']]);
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_PUT,
            '/api/companies/a136c6fe-8f6e-45ed-91bc-586374791033',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );

        // Act
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertSame('Company update started!', $response->getContent());
    }
}
