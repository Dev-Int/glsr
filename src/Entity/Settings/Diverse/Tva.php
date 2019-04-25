<?php

/**
 * Entity Tva.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @see https://github.com/Dev-Int/glsr
 */

namespace App\Entity\Settings\Diverse;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tva Entity.
 *
 * @category Entity
 *
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

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rate.
     *
     * @param float $rate VAT rate
     *
     * @return Tva
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate.
     *
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return (\number_format($this->getRate() * 100, 1)).' %';
    }

    /**
     * This method allows to make "echo $tva".
     * <p> So, to "show" $tva,
     * PHP will actually show the return of this method. <br />
     * Here, the name, so "echo $tva"
     * is equivalent to "echo $tva->getName()". </p>.
     *
     * @return string name
     */
    public function __toString()
    {
        return (string) $this->getName();
    }
}
