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

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Unit\Tests\Infrastructure\DatabaseHelper;

class PostCompanyControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        DatabaseHelper::dropAndCreateDatabaseAndRunMigrations();
    }

    final protected function setUp(): void
    {
        parent::setUp();

        static::ensureKernelShutdown();
        $this->client = static::createClient();
    }

    final public function testPostCompanyAction(): void
    {
        // Arrange
        $content = [
            'create_company' => [
                'name' => 'Dev-Int Création',
                'address' => '1, rue des ERP',
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
        $this->client->request('POST', '/administration/company/create', $content);

        // Act
        $response = $this->client->getResponse();

        // Assert
        static::assertSame(JsonResponse::HTTP_ACCEPTED, $response->getStatusCode());
        static::assertSame('{"status":"Company created started!"}', $response->getContent());
    }
}
