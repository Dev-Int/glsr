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

use Administration\Infrastructure\DataFixtures\CompanyFixtures;
use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\AbstractControllerTest;

class PutCompanyControllerTest extends AbstractControllerTest
{
    final public function testPutCompanySuccess(): void
    {
        // Arrange
        $this->loadFixture(new CompanyFixtures());
        $content = [
            'company' => [
                'name' => 'Dev-Int Création',
                'address' => '2 rue des ERP',
                'zipCode' => '56000',
                'town' => 'VANNES',
                'country' => 'France',
                'phone' => '+33100000001',
                'facsimile' => '+33100000002',
                'email' => 'contact@developpement-interessant.com',
                'contact' => 'Laurent Quétier',
                'cellphone' => '+33100000002',
            ],
        ];
        $this->client->request('POST', '/administration/company/update/a136c6fe-8f6e-45ed-91bc-586374791033', $content);

        // Act
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertTrue($response->isRedirect('/administration/company/'));
    }
}
