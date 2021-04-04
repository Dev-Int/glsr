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

use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\AbstractControllerTest;
use Unit\Tests\Fixtures\FamilyLogFixtures;

class PostFamilyLogControllerTest extends AbstractControllerTest
{
    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     * @throws \JsonException
     */
    final public function testPostFamilyLogWithNameAlreadyExists(): void
    {
        // Arrange
        $this->loadFixtures([new FamilyLogFixtures()]);
        $content = [
            'label' => 'Surgelé',
            'parent' => null,
        ];
        $adminClient = $this->createAdminClient();

        // Act
        $adminClient->request(
            Request::METHOD_POST,
            '/api/administration/family-logs/',
            [],
            [],
            ['CONTENT_TYPE', 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );
        $response = $adminClient->getResponse();

        // Assert
        self::assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        self::assertTrue($response->isServerError());
    }

    /**
     * @throws \JsonException
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    final public function testPostFamilyLogControllerSuccess(): void
    {
        // Arrange
        $this->loadFixtures([]);
        $content = [
            'label' => 'Surgelé',
            'parent' => null,
        ];
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_POST,
            '/api/administration/family-logs/',
            [],
            [],
            ['CONTENT_TYPE', 'application/json'],
            \json_encode($content, \JSON_THROW_ON_ERROR)
        );

        // Act
        $response = $adminClient->getResponse();

        // Assert
        self::assertSame(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertSame('FamilyLog create started!', $response->getContent());
    }
}
