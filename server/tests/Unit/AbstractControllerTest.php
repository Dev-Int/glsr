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

use Administration\Infrastructure\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AbstractControllerTest extends WebTestCase
{
    protected KernelBrowser $client;
    protected EntityManagerInterface $manager;
    protected ORMExecutor $executor;
    protected UserPasswordEncoderInterface $passwordEncoder;
    private string $projectDir;

    final protected function setUp(): void
    {
        parent::setUp();

        static::ensureKernelShutdown();
        $this->client = static::createClient();

        // Configure variables
        $this->projectDir = self::$kernel->getProjectDir();
        $this->manager = self::$container->get('doctrine.orm.entity_manager');
        $this->passwordEncoder = self::$container->get('security.password_encoder');
        $this->executor = new ORMExecutor($this->manager, new ORMPurger());

        // Run the schema update tool using entity metadata
        $schemaTool = new SchemaTool($this->manager);
        $schemaTool->updateSchema($this->manager->getMetadataFactory()->getAllMetadata());
    }

    final protected function tearDown(): void
    {
        (new SchemaTool($this->manager))->dropDatabase();
        \unlink($this->projectDir . '/var/cache/test/test.db');
    }

    final public function loadFixture(array $fixture): void
    {
        $loader = new Loader();
        $loader->addFixture(new UserFixtures($this->passwordEncoder));
        if ([] !== $fixture) {
            foreach ($fixture as $item) {
                $loader->addFixture($item);
            }
        }
        $this->executor->execute($loader->getFixtures());
    }

    /**
     * @throws \JsonException
     */
    protected function createAdminClient(): KernelBrowser
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
            self::assertTrue(null !== $decode && false !== $decode,
                'is response valid json: [' . $response->getContent() . ']'
            );
        }
    }
}
