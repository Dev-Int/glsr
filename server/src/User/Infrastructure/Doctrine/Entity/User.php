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

namespace User\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use User\Domain\Model\User as UserModel;

/**
 * @ORM\Entity(repositoryClass="User\Infrastructure\Doctrine\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private string $uuid;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=120, nullable=false)
     */
    private string $password;

    /**
     * @ORM\Column(type="array", nullable=false)
     */
    private array $roles;

    public function __construct(string $uuid, string $username, string $email, string $password, array $roles)
    {
        $this->uuid = $uuid;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }

    public static function fromModel(UserModel $user): self
    {
        return new self(
            $user->uuid()->toString(),
            $user->username()->getValue(),
            $user->email()->getValue(),
            $user->password()->value(),
            $user->roles()
        );
    }

    public function update(UserModel $userModel): self
    {
        $this->username = $userModel->username()->getValue();
        $this->email = $userModel->email()->getValue();
        $this->password = $userModel->password()->value();
        $this->roles = $userModel->roles();

        return $this;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        if ([] === $this->roles) {
            $this->roles = ['ROLE_USER'];
        }

        return \array_unique($this->roles);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @see AuthenticationSuccessResponseListener::onAuthenticationSuccessResponse
     */
    public function getProfileInfos(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
        ];
    }
}
