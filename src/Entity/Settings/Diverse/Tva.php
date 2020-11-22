<?php

namespace App\Entity\Settings\Diverse;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="app_tva")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\Diverse\TvaRepository")
 */
class Tva
{
    /**
     * @var int Id of the VAT rate
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float VAT rate
     *
     * @ORM\Column(name="rate", type="decimal", precision=4, scale=3)
     */
    private $rate;

    public function getId(): int
    {
        return $this->id;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function getName(): string
    {
        return (number_format($this->getRate() * 100, 1)) . ' %';
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
