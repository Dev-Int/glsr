<?php

/**
 * Entité Supplier.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    0.1.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Glsr\GestockBundle\Entity\Contact;
use Glsr\GestockBundle\Entity\FamilyLog;
use Glsr\GestockBundle\Entity\SubFamilyLog;

/**
 * Supplier Entité Supplier.
 *
 * @category   Entity
 *
 * @ORM\Table(name="gs_supplier")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\SupplierRepository")
 * @UniqueEntity(
 *     fields="name",
 *     message="Ce nom de fournisseur est déjà utilisé dans le système."
 * )
 */
class Supplier extends Contact
{
    /**
     * @var string Famille logistique
     * @ORM\ManyToOne(targetEntity="Glsr\GestockBundle\Entity\FamilyLog")
     * @Assert\NotBlank()
     */
    private $family_log;

    /**
     * @var string Sous-famille logistique
     *
     * @ORM\ManyToOne(targetEntity="Glsr\GestockBundle\Entity\SubFamilyLog")
     */
    private $sub_family_log;

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
     * Set family_log.
     *
     * @param FamilyLog $familyLog Famille logistique
     *
     * @return Supplier
     */
    public function setFamilyLog(FamilyLog $familyLog = null)
    {
        $this->family_log = $familyLog;
        return $this;
    }

    /**
     * Get family_log.
     *
     * @return FamilyLog
     */
    public function getFamilyLog()
    {
        return $this->family_log;
    }

    /**
     * Set sub_family_log.
     *
     * @param SubFamilyLog $subFamilyLog Sous-famille logistique
     *
     * @return Supplier
     */
    public function setSubFamilyLog(SubFamilyLog $subFamilyLog = null)
    {
        $this->sub_family_log = $subFamilyLog;
        return $this;
    }

    /**
     * Get sub_family_log.
     *
     * @return SubFamilyLog
     */
    public function getSubFamilyLog()
    {
        return $this->sub_family_log;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Supplier
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
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
