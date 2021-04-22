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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\AbstractControllerTest;
use Unit\Tests\DatabaseHelper;

class PostCompanyControllerTest extends AbstractControllerTest
{
    /**
     * @throws \JsonException
     */
    final public function testPostCompanySuccess(): void
    {
        // Arrange
        $content = [
            'name' => 'Dev-Int Création',
            'address' => '1, rue des ERP',
            'zipCode' => '75000',
            'town' => 'PARIS',
            'country' => 'France',
            'phone' => '+33100000001',
            'facsimile' => '+33100000002',
            'email' => 'contact@developpement-interessant.com',
            'contact' => 'Laurent',
            'cellphone' => '+33600000002',
        ];
        DatabaseHelper::loadFixtures([['group' => 'user']]);
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_POST,
            '/api/administration/companies/',
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
            'name' => 'Dev-Int Création',
            'address' => '1, rue des ERP',
            'zipCode' => '75000',
            'town' => 'PARIS',
            'country' => 'France',
            'phone' => '+33100000001',
            'facsimile' => '+33100000002',
            'email' => 'contact@developpement-interessant.com',
            'contact' => 'Laurent',
            'cellphone' => '+33600000002',
        ];

        // Act
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_POST,
            '/api/administration/companies/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }
}
