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

namespace End2End\Tests;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AbstractControllerTest extends WebTestCase
{
    protected KernelBrowser $client;
    protected UserPasswordEncoderInterface $passwordEncoder;
    private Connection $connection;

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

        // Configure variables
        $doctrine = self::$container->get('doctrine');
        $this->connection = $doctrine->getConnection();
    }

    final protected function tearDown(): void
    {
        $this->connection->close();
        unset($this->connection);
    }

    protected function getUrl(
        string $route,
        array $params = [],
        int $absolute = UrlGeneratorInterface::ABSOLUTE_PATH
    ): string {
        return self::$container->get('router')->generate($route, $params, $absolute);
    }

    /**
     * @throws \JsonException
     */
    protected function createAdminClient(): KernelBrowser
    {
        return $this->createAuthenticatedClient('Laurent', 'Password-1');
    }

    /**
     * @throws \JsonException
     */
    private function createAuthenticatedClient(string $username, string $password): KernelBrowser
    {
        $this->client->request(
            'POST',
            $this->getUrl('api_login_check'),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(['username' => $username, 'password' => $password], \JSON_THROW_ON_ERROR)
        );
        self::assertJsonResponse($this->client->getResponse());

        $data = \json_decode(
            $this->client->getResponse()->getContent(),
            true,
            512,
            \JSON_THROW_ON_ERROR
        );

        $this->client->setServerParameter('HTTP_Authorization', \sprintf('Bearer %s', $data['token']));

        return $this->client;
    }

    /**
     * @throws \JsonException
     */
    private static function assertJsonResponse(
        Response $response,
        int $statusCode = Response::HTTP_OK,
        bool $checkValidJson = true,
        string $contentType = 'application/json'
    ): void {
        self::assertEquals($statusCode, $response->getStatusCode(), $response->getContent());
        if ($checkValidJson && Response::HTTP_NO_CONTENT !== $statusCode) {
            self::assertTrue($response->headers->contains('Content-Type', $contentType));
            $decode = \json_decode($response->getContent(), true, 512, \JSON_THROW_ON_ERROR);
            self::assertTrue(
                null !== $decode && false !== $decode,
                'is response valid json: [' . $response->getContent() . ']'
            );
        }
    }
}
