<?php

/**
 * Entité Supplier.
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
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\Contact;
use AppBundle\Entity\FamilyLog;

/**
 * Supplier Entité Supplier.
 *
 * @category Entity
 *
 * @ORM\Table(name="gs_supplier")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SupplierRepository")
 * @UniqueEntity(
 *     fields="name",
 *     message="Ce nom de fournisseur est déjà utilisé dans le système."
 * )
 */
class Supplier extends Contact
{
    /**
     * @var int id du fournisseur
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string|\AppBundle\Entity\FamilyLog Famille logistique
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FamilyLog")
     * @Assert\NotBlank()
     */
    private $familyLog;

    /**
     * @var int Délai de livraison
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
     * @var array Tableau des jours de commande
     *
     * @ORM\Column(name="orderdate", type="simple_array")
     * @Assert\NotBlank(message="Il vous faut choisir au moins 1 date de commande.")
     */
    private $orderdate;

    /**
     * @var bool Activé/Désactivé
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
     * @param int $delaydeliv Délai de livraison
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
     * @param array $orderdate Jour(s) de commande
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
     * @param null|FamilyLog $familyLog Famille logistique
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
     * @return FamilyLog
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
     * Cette méthode permet de faire "echo $supplier".
     * <p>Ainsi, pour "afficher" $supplier,
     * PHP affichera en réalité le retour de cette méthode.<br />
     * Ici, le nom, donc "echo $supplier"
     * est équivalent à "echo $supplier->getName()"</p>.
     *
     * @return string name
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set active.
     *
     * @param bool $active Activé/Désactivé
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
}
