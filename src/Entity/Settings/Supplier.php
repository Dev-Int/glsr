<?php

/**
 * Entity Supplier.
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
namespace  App\Entity\Settings;

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
 * @ORM\Table(name="gs_supplier")
 * @ORM\Entity(repositoryClass="App\Repository\Settings\SupplierRepository")
 * @UniqueEntity(
 *     fields="name",
 *     message="Ce nom de fournisseur est déjà utilisé dans le système."
 * )
 */
class Supplier extends Contact
{
    /**
     * @var int $supId Supplier id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $supId;

    /**
     * @var string|\App\Entity\Settings\Diverse\FamilyLog Logistic family
     * @ORM\ManyToOne(targetEntity="App\Entity\Settings\Diverse\FamilyLog")
     * @Assert\NotBlank()
     */
    private $familyLog;

    /**
     * @var int $delaydeliv Delivery time
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
     * @var array $orderdate Table of days of order
     *
     * @ORM\Column(name="orderdate", type="simple_array")
     * @Assert\NotBlank(message="Il vous faut choisir au moins 1 date de commande.")
     */
    private $orderdate;

    /**
     * @var bool $active On/Off
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var string $slug
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
        return $this->supId;
    }

    /**
     * Set delaydeliv.
     *
     * @param int $delaydeliv
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
     * @param array $orderdate
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
     * @param null|\App\Entity\Settings\Diverse\FamilyLog $familyLog
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
     * @param bool $active
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
     * This method allows to do "echo $supplier".
     * <p> So, to "show" $unisuppliert,
     * PHP will actually show the return of this method. <br />
     * Here, the abbreviation, so "echo $supplier"
     * is equivalent to "echo $supplier->getName()" </ p>.
     *
     * @return string name
     */
    public function __toString()
    {
        return $this->getName();
    }
}
