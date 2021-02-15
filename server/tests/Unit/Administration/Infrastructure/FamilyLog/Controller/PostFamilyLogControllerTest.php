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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unit\Tests\AbstractControllerTest;

class PostFamilyLogControllerTest extends AbstractControllerTest
{
    /**
     * @throws \JsonException
     */
    final public function testPostFamilyLogControllerSuccess(): void
    {
        // Arrange
        $this->loadFixture([]);
        $content = [
            'label' => 'Surgelé',
            'parent' => null,
        ];
        $adminClient = $this->createAdminClient();
        $adminClient->request(
            Request::METHOD_POST,
            '/api/administration/familylogs/',
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
