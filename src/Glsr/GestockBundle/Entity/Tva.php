<?php

/**
 * Tva Entité Tva
 * 
 * PHP Version 5
 * 
 * @category   Entity
 * @package    Gestock
 * @subpackage Settings
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    GIT: e6aa22c616ccc10884c67779f7d35806ca4a8be8
 * @link       https://github.com/GLSR/glsr
 */

namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tva Entité Tva
 * 
 * @category   Entity
 * @package    Gestock
 * @subpackage Settings
 * @author     Quétier Laurent <lq@dev-int.net>
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link       https://github.com/GLSR/glsr
 *
 * @ORM\Table(name="gs_tva")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\TvaRepository")
 */
class Tva
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idTva;

    /**
     * @var decimal,
     *
     * @ORM\Column(name="name", type="decimal", precision=5, scale=3)
     */
    private $name;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->idTva;
    }

    /**
     * Set name
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
     * Get name
     *
     * @return decimal, 
     */
    public function getName()
    {
        return $this->name;
    }

}
