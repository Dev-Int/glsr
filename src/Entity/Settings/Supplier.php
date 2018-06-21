<?php

/**
 * Entity Supplier.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace App\Entity\Settings;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\Contact;
use App\Entity\Settings\Diverse\FamilyLog;

/**
 * Supplier Entity.
 *
 * @category Entity
 *
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
     * @var string|\App\Entity\Settings\Diverse\FamilyLog Famille logistique
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
    private $delaydeliv;

    /**
     * @var array Table of order days
     *
     * @ORM\Column(name="orderdate", type="simple_array")
     * @Assert\NotBlank(message="Il vous faut choisir au moins 1 date de commande.")
     */
    private $orderdate;

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

    /**
     * __construct.
     */
    public function __construct()
    {
        $this->active = true;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set delaydeliv.
     *
     * @param int $delaydeliv Delivery time
     *
     * @return Supplier
     */
    public function setDelaydeliv($delaydeliv)
    {
        $this->delaydeliv = $delaydeliv;
        return $this;
    }

    /**
     * Get delaydeliv.
     *
     * @return int
     */
    public function getDelaydeliv()
    {
        return $this->delaydeliv;
    }

    /**
     * Set orderdate.
     *
     * @param array $orderdate Order day(s)
     *
     * @return Supplier
     */
    public function setOrderdate($orderdate)
    {
        $this->orderdate = $orderdate;
        return $this;
    }
    /**
     * Get orderdate.
     *
     * @return array
     */
    public function getOrderdate()
    {
        return $this->orderdate;
    }

    /**
     * Set familyLog.
     *
     * @param null|\App\Entity\Settings\Diverse\FamilyLog $familyLog Logistic family
     *
     * @return Supplier
     */
    public function setFamilyLog(FamilyLog $familyLog = null)
    {
        $this->familyLog = $familyLog;
        return $this;
    }

    /**
     * Get familyLog.
     *
     * @return \App\Entity\Settings\Diverse\FamilyLog
     */
    public function getFamilyLog()
    {
        return $this->familyLog;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set active.
     *
     * @param bool $active On/off
     *
     * @return Supplier
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * Is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * This method lets you do "echo $supplier".
     * <p> So, to "show" $supplier,
     * PHP will actually show the return of this method. <br />
     * Here, the name, so "echo $supplier"
     * is equivalent to "echo $supplier->getName()" </p>.
     *
     * @return string name
     */
    public function __toString()
    {
        return $this->getName();
    }
}
