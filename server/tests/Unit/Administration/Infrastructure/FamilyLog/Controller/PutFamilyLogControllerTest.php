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

namespace Unit\Tests\Administration\Infrastructure\FamilyLog\Controller;

use Doctrine\DBAL\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\AbstractControllerTest;
use Unit\Tests\Fixtures\FamilyLogFixtures;

class PutFamilyLogControllerTest extends AbstractControllerTest
{
    /**
     * @throws \JsonException
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    final public function testPutFamilyLogControllerSuccess(): void
    {
        // Arrange
        $this->loadFixtures([new FamilyLogFixtures()]);
        $content = [
            'label' => 'Viandes',
            'parent' => '8413b485-e1c9-4e79-94e3-ce280986a952',
        ];
        $adminClient = $this->createAdminClient();

        // Act
        $adminClient->request(
            Request::METHOD_PUT,
            '/api/administration/family-logs/ec9689bb-99d3-4493-b39d-a5b623bba5a0',
            [],
            [],
            ['CONTENT_TYPE', 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );
        $response = $adminClient->getResponse();

        // Assert
        self::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertSame('FamilyLog update started!', $response->getContent());
    }
}
