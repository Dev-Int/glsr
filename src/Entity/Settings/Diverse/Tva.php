<?php

/**
 * Entity Tva.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace  App\Entity\Settings\Diverse;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tva Entity.
 *
 * @category Entity
 *
 * @ORM\Table(name="gs_tva")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\Diverse\TvaRepository")
 */
class Tva
{
    /**
     * @var int $tvaId Id of the VAT rate
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $tvaId;

    /**
     * @var decimal $rate VAT rate
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
        return $this->tvaId;
    }

    /**
     * Set rate.
     *
     * @param decimal $rate Taux de TVA
     *
     * @return Settings\Diverse\Tva
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate.
     *
     * @return decimal
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getRate() * 100;
    }
}
