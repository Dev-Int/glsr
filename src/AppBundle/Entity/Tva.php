<?php

/**
 * Entité Tva.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    since 1.0.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tva Entité Tva.
 *
 * @category   Entity
 *
 * @ORM\Table(name="gs_tva")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TvaRepository")
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
     * @ORM\Column(name="name", type="decimal", precision=5, scale=3)
     */
    private $name;

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
     * Set name.
     *
     * @param decimal $name Taux de TVA
     *
     * @return tva
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
