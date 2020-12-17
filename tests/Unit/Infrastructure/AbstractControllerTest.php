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

namespace Unit\Tests\Infrastructure;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AbstractControllerTest extends WebTestCase
{
    protected KernelBrowser $client;
    protected EntityManagerInterface $manager;
    protected ORMExecutor $executor;
    private string $projectDir;

    final protected function setUp(): void
    {
        parent::setUp();

        static::ensureKernelShutdown();
        $this->client = static::createClient();

        // Configure variables
        $this->projectDir = self::$kernel->getProjectDir();
        $this->manager = self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
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

    /**
     * @param array|Fixture $fixture
     */
    final public function loadFixture($fixture): void
    {
        $loader = new Loader();
        $fixtures = \is_array($fixture) ? $fixture : [$fixture];
        foreach ($fixtures as $item) {
            $loader->addFixture($item);
        }
        $this->executor->execute($loader->getFixtures());
    }
}
