<?php

/**
 * Entité Tva.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Entity\Settings\Diverse;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tva Entité Tva.
 *
 * @category Entity
 *
 * @ORM\Table(name="gs_tva")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Settings\Diverse\TvaRepository")
 */
class Tva
{
    /**
     * @var int Id du taux de TVA
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var decimal Taux de TVA
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
