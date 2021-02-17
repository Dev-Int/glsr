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

namespace Unit\Tests;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Unit\Tests\Fixtures\FixturesProtocol;
use Unit\Tests\Fixtures\UserFixtures;

class AbstractControllerTest extends WebTestCase
{
    protected KernelBrowser $client;
    protected Connection $connection;
    protected UserPasswordEncoderInterface $passwordEncoder;
    private string $projectDir;

    final protected function setUp(): void
    {
        parent::setUp();

        static::ensureKernelShutdown();
        $this->client = static::createClient();

        // Configure variables
        $this->projectDir = self::$kernel->getProjectDir();
        $this->connection = self::$container->get('doctrine.dbal.default_connection');
        $this->passwordEncoder = self::$container->get('security.password_encoder');

        // Run the schema update tool
        $this->deleteDatabase();
        $this->createDatabase();
        $this->updateSchema();
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    final public function loadFixtures(array $fixtures): void
    {
        (new UserFixtures($this->passwordEncoder))->load($this->connection);
        foreach ($fixtures as $fixture) {
            if ($fixture instanceof FixturesProtocol) {
                $fixture->load($this->connection);
            }
        }
    }

    /**
     * @throws \JsonException
     */
    public function createAdminClient(): KernelBrowser
    {
        return $this->createAuthenticatedClient('Laurent', 'password');
    }

    /**
     * @throws \JsonException
     */
    private function createAuthenticatedClient(string $username, string $password): KernelBrowser
    {
        $this->client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            \json_encode(
                [
                    'username' => $username,
                    'password' => $password,
                ],
                \JSON_THROW_ON_ERROR
            )
        );
        self::assertJsonResponse($this->client->getResponse());
        $data = \json_decode($this->client->getResponse()->getContent(), true, 512, \JSON_THROW_ON_ERROR);

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

    private function createDatabase(): void
    {
        $process = new Process(
            [
                'php',
                'bin/console',
                'doctrine:database:create',
                '--env=test',
            ],
            \dirname(__DIR__, 2)
        );

        $process->run();

        if (!$process->isSuccessful()) {
            \var_dump($process->getErrorOutput());

            exit(\var_dump($process));
        }
    }

    private function updateSchema(): void
    {
        $process = new Process(
            [
                'php',
                'bin/console',
                'dbal:schema:update',
                '--force',
                '--env=test',
            ],
            \dirname(__DIR__, 2)
        );

        $process->run();
        if (!$process->isSuccessful()) {
            \var_dump($process->getErrorOutput());

            exit(\var_dump($process));
        }
    }

    private function deleteDatabase(): void
    {
        $process = new Process(
            [
                'php',
                'bin/console',
                'doctrine:database:drop',
                '--force',
                '--env=test',
            ],
            \dirname(__DIR__, 2)
        );

        $process->run();

        if (!$process->isSuccessful()) {
            \var_dump($process->getErrorOutput());

            exit(\var_dump($process));
        }
    }
}
