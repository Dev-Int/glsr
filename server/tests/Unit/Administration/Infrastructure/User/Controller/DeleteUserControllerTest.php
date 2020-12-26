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

namespace Unit\Tests\Administration\Infrastructure\User\Controller;

use Administration\Infrastructure\DataFixtures\UserFixtures;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Unit\Tests\AbstractControllerTest;

class DeleteUserControllerTest extends AbstractControllerTest
{
    final public function testDeleteUserSuccess(): void
    {
        // Arrange
        // @TODO Fix EncoderPassword dependency
        $userPasswordEncoder = $this->getMockBuilder(
            UserPasswordEncoderInterface::class
        )->getMock();
        $userPasswordEncoder->expects(self::any())
            ->method('encodePassword')
            ->willReturn('encodedPassword')
        ;
        $this->loadFixture([new UserFixtures($userPasswordEncoder)]);
        $this->client->request(
            'DELETE',
            '/administration/user/delete/a136c6fe-8f6e-45ed-91bc-586374791033'
        );

        // Act
        $response = $this->client->getResponse();

        // Assert
        self::assertSame(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertTrue($response->isRedirect('/administration/user/'));
    }
}
