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

use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\AbstractControllerTest;
use Unit\Tests\Fixtures\FamilyLogFixtures;

class PostSupplierControllerTest extends AbstractControllerTest
{
    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     * @throws \JsonException
     */
    final public function testPostSupplierSuccess(): void
    {
        // Arrange
        $this->loadFixtures([new FamilyLogFixtures()]);
        $content = [
            'name' => 'Davigel',
            'address' => '1, rue des freeze',
            'zipCode' => '75000',
            'town' => 'PARIS',
            'country' => 'France',
            'phone' => '0100000001',
            'facsimile' => '0100000002',
            'email' => 'contact@davigel.fr',
            'contact_name' => 'David',
            'cellphone' => '0600000002',
            'familyLogId' => '626adfca-fc5d-415c-9b7a-7541030bd147',
            'delayDelivery' => 3,
            'orderDays' => [2, 4],
        ];
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_POST,
            '/api/administration/suppliers/',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );

        // Act
        $response = $adminClient->getResponse();

        // Assert
        self::assertSame(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertSame('Supplier create started!', $response->getContent());
    }
}
