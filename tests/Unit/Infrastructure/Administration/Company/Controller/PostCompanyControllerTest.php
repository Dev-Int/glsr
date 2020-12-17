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

namespace Unit\Tests\Infrastructure\Administration\Company\Controller;

use Administration\Infrastructure\DataFixtures\CompanyFixtures;
use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\Infrastructure\AbstractControllerTest;

class PostCompanyControllerTest extends AbstractControllerTest
{
    final public function testPostCompanyAction(): void
    {
        // Arrange
        $content = [
            'company' => [
                'name' => 'Dev-Int Création',
                'address' => '1, rue des ERP',
                'zipCode' => '75000',
                'town' => 'PARIS',
                'country' => 'France',
                'phone' => '+33100000001',
                'facsimile' => '+33100000002',
                'email' => 'contact@developpement-interessant.com',
                'contact' => 'Laurent',
                'cellphone' => '+33100000002',
            ],
        ];
        $this->client->request('POST', '/administration/company/create', $content);

        // Act
        $response = $this->client->getResponse();

        // Assert
        static::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        static::assertTrue($response->isRedirect('/administration/company/'));
    }

    final public function testPostCompanyAlreadyExist(): void
    {
        // Arrange
        $this->loadFixture(new CompanyFixtures());
        $content = [
            'company' => [
                'name' => 'Dev-Int Création',
                'address' => '1 rue des ERP',
                'zipCode' => '75000',
                'town' => 'PARIS',
                'country' => 'France',
                'phone' => '+33100000001',
                'facsimile' => '+33100000002',
                'email' => 'contact@developpement-interessant.com',
                'contact' => 'Laurent',
                'gsm' => '+33100000002',
            ],
        ];

        // Act
        $this->client->request('POST', '/administration/company/create', $content);
        $response = $this->client->getResponse();

        // Assert
        static::assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }
}
