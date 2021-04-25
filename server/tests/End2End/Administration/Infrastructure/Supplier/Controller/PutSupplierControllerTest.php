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

class PutSupplierControllerTest extends AbstractControllerTest
{
    /**
     * @throws \JsonException
     */
    final public function testPutSupplierFailWithBadUuid(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user'], ['group' => 'supplier']]);
        $content = [
            'companyName' => 'Davigel',
            'address' => '1, rue des freezes',
            'zipCode' => '75008',
            'town' => 'PARIS',
            'country' => 'France',
            'phone' => '0100000001',
            'facsimile' => '0100000002',
            'email' => 'contact@davigel.fr',
            'contact' => 'David',
            'cellphone' => '0600000002',
            'familyLog' => 'Surgelé',
            'delayDelivery' => 3,
            'orderDays' => [2, 4],
        ];
        $adminClient = $this->createAdminClient();

        // Act
        $adminClient->request(
            Request::METHOD_PUT,
            '/api/administration/suppliers/626adfca-fc5d-415c-9b7a-7541030bd147',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );
        $response = $adminClient->getResponse();

        // Assert
        self::assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }

    /**
     * @throws \JsonException
     */
    final public function testPutSupplierSuccess(): void
    {
        // Arrange
        DatabaseHelper::loadFixtures([['group' => 'user'], ['group' => 'supplier']]);
        $content = [
            'companyName' => 'Davigel',
            'address' => '1, rue des freezes',
            'zipCode' => '75008',
            'town' => 'PARIS',
            'country' => 'France',
            'phone' => '0100000001',
            'facsimile' => '0100000002',
            'email' => 'contact@davigel.fr',
            'contactName' => 'David',
            'cellphone' => '0600000002',
            'familyLog' => 'Surgelé',
            'delayDelivery' => 3,
            'orderDays' => [2, 4],
        ];
        $adminClient = $this->createAdminClient();

        // Act
        $adminClient->request(
            Request::METHOD_PUT,
            '/api/administration/suppliers/a136c6fe-8f6e-45ed-91bc-586374791033',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );
        $response = $adminClient->getResponse();

        // Assert
        self::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertSame('Supplier update started!', $response->getContent());
    }
}
