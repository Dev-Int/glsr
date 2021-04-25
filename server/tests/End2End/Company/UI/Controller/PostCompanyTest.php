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

class PostCompanyTest extends AbstractControllerTest
{
    /**
     * @throws \JsonException
     */
    final public function testPostCompanySuccess(): void
    {
        // Arrange
        $content = [
            'companyName' => 'Dev-Int Création',
            'address' => '1, rue des ERP',
            'zipCode' => '75000',
            'town' => 'PARIS',
            'country' => 'France',
            'phone' => '+33100000001',
            'facsimile' => '+33100000002',
            'email' => 'contact@developpement-interessant.com',
            'contactName' => 'Laurent',
            'cellphone' => '+33600000002',
        ];
        DatabaseHelper::loadFixtures([['group' => 'user']]);
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_POST,
            '/api/companies/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );

        // Act
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertSame('Company create started!', $response->getContent());
    }

    /**
     * @throws \JsonException
     */
    final public function testPostCompanyAlreadyExist(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user'], ['group' => 'company']]);
        $content = [
            'companyName' => 'Dev-Int Création',
            'address' => '1, rue des ERP',
            'zipCode' => '75000',
            'town' => 'PARIS',
            'country' => 'France',
            'phone' => '+33100000001',
            'facsimile' => '+33100000002',
            'email' => 'contact@developpement-interessant.com',
            'contactName' => 'Laurent',
            'cellphone' => '+33600000002',
        ];

        // Act
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_POST,
            '/api/companies/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );
        $response = $adminClient->getResponse();
        $responseDecoded = \json_decode($response->getContent());

        // Assert
        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertSame(Request::METHOD_POST, $responseDecoded->method);
        self::assertSame('Company already exist', $responseDecoded->details);
    }
}
