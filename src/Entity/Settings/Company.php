<?php

namespace App\Entity\Settings;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Contact;

/**
 * @ORM\Table(name="app_company")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\CompanyRepository")
 */
class Company extends Contact
{
    /**
     * @var int Id of company
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string Status of company
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    public function getId(): int
    {
        return $this->id;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
