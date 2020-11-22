<?php

namespace App\Entity\Settings;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\Contact;
use App\Entity\Settings\Diverse\FamilyLog;

/**
 * @ORM\Table(name="app_supplier")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\SupplierRepository")
 * @UniqueEntity(
 *     fields="name",
 *     message="This supplier name is already used in the system."
 * )
 */
class Supplier extends Contact
{
    /**
     * @var int id supplier
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var FamilyLog Famille logistique
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\FamilyLog")
     * @ORM\OrderBy({"path" = "asc"})
     * @Assert\NotBlank()
     */
    private $familyLog;

    /**
     * @var int Delivery time
     *
     * @ORM\Column(name="delaydeliv", type="smallint")
     * @Assert\Length(
     *     max="1",
     *     maxMessage = "Votre choix ne peut pas être que {{ limit }} caractère"
     * )
     * @Assert\NotBlank()
     */
    private $delayDelivery;

    /**
     * @var array Table of order days
     *
     * @ORM\Column(name="orderdate", type="simple_array")
     * @Assert\NotBlank(message="Il vous faut choisir au moins 1 date de commande.")
     */
    private $orderDate;

    /**
     * @var bool On/Off
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    public function __construct()
    {
        $this->active = true;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setDelayDelivery(int $delayDelivery): self
    {
        $this->delayDelivery = $delayDelivery;

        return $this;
    }

    public function getDelayDelivery(): int
    {
        return $this->delayDelivery;
    }

    public function setOrderDate(array $orderDate): self
    {
        $this->orderDate = $orderDate;
        return $this;
    }

    public function getOrderDate(): array
    {
        return $this->orderDate;
    }

    public function setFamilyLog(FamilyLog $familyLog): self
    {
        $this->familyLog = $familyLog;

        return $this;
    }

    public function getFamilyLog(): FamilyLog
    {
        return $this->familyLog;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
