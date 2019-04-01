<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User Entity.
 *
 * @category Entity
 *
 * @ORM\Table(name="app_user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *  fields={"username"},
 *  message="L'utilisateur que vous avez indiqué existe déjà !!"
 * )
 */
class User implements UserInterface
{
    const ROLE_DEFAULT = 'ROLE_USER';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;
    // private $usrId;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=40)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas typé le même mot de passe !!")
     */
    public $confirmPassword;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    public $salt;

    /**
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = [];

    /**
     * @ORM\Column(name="is_admin", type="boolean")
     */
    private $isAdmin;

    /**
     * @ORM\Column(name="is_assistant", type="boolean")
     */
    private $isAssistant;

    public function __construct()
    {
        // $this->salt = md5(uniqid(rand(), true));
        $this->isAdmin = false;
        $this->isAssistant = false;
        $this->enabled = true;
    }

    public function getId(): ?int
    {
        // return $this->usrId;
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        if (empty($this->roles)) {
            // guarantee every user at least has ROLE_USER
            $roles[] = 'ROLE_USER';
        }
        if ($this->isAdmin) {
            $roles = ['ROLE_SUPER_ADMIN'];
        }
        if ($this->isAssistant) {
            $roles = ['ROLE_ADMIN'];
        }

        return array_unique($roles);
    }

    /**
     * Adds a role to the user.
     *
     * @param string $role
     *
     * @return static
     */
    public function addRoles($role)
    {
        $role = strtoupper($role);
        if ($role === static::ROLE_DEFAULT) {
            return $this;
        }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * Sets the roles of the user.
     *
     * This overwrites any previous roles.
     *
     * @param array $roles
     */
    public function setRoles(array $roles = array()): self
    {
        $this->roles = array();

        if (empty($roles)) {
            // guarantee every user at least has ROLE_USER
            $roles[] = 'ROLE_USER';
            if ($this->isAdmin) {
                $roles = ['ROLE_ADMIN', 'ROLE_ASSISTANT', 'ROLE_USER'];
            }
            if ($this->isAssistant) {
                $roles = ['ROLE_ASSISTANT', 'ROLE_USER'];
            }
        }

        foreach ($roles as $role) {
            $this->addRoles($role);
        }

        return $this;
    }

    /**
     * Get the value of isAdmin.
     */
    public function isAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Get the value of isAssistant.
     */
    public function isAssistant()
    {
        return $this->isAssistant;
    }

    /**
     * Get the value of enabled.
     */
    public function enabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Set the value of isAdmin.
     */
    public function setIsAdmin($isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Set the value of isAssistant.
     */
    public function setIsAssistant($isAssistant): self
    {
        $this->isAssistant = $isAssistant;

        return $this;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * Set the value of salt.
     */
    // public function setSalt($salt): self
    // {
    //     $this->salt = $salt;

    //     return $this;
    // }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
