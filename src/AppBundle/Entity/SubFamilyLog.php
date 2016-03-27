<?php

/**
 * Entité SubFamilyLog.
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
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\FamilyLog;

/**
 * SubFamilyLog Entité SubFamilyLog.
 *
 * PHP Version 5
 *
 * @category   Entity
 *
 * @ORM\Table(name="gs_subfamilylog")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SubFamilyLogRepository")
 */
class SubFamilyLog implements \JsonSerializable
{
    /**
     * @var int Id de la sous-famille logistique
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string Nom de la sous-famille logistique
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string Famille logistique dont dépend la sous-famille
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FamilyLog")
     * @ORM\JoinColumn(nullable=false)
     */
    private $familylogs;
    
    /**
     * @var string Slug name
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->familylogs = new ArrayCollection();
    }

    public function jsonSerialize()
    {
        array(
            'id'        => $this->id,
            'name'      => $this->name,
            'devices'   => $this->familylogs->toArray(),
        );
    }
    /**
     * Cette méthode permet de faire "echo $subFamilyLog".
     * <p>Ainsi, pour "afficher" $subFamilyLog,
     * PHP affichera en réalité le retour de cette méthode.<br />
     * Ici, le nom, donc "echo $subFamilyLog"
     * est équivalent à "echo $subFamilyLog->getName()"</p>.
     *
     * @return string name
     */
    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return SubFamilyLog
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return SubFamilyLog
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
     * Set familylogs
     *
     * @param \AppBundle\Entity\FamilyLog $familylogs
     * @return SubFamilyLog
     */
    public function setFamilylogs(FamilyLog $familylogs)
    {
        $this->familylogs = $familylogs;

        return $this;
    }

    /**
     * Get familylogs
     *
     * @return \AppBundle\Entity\FamilyLog 
     */
    public function getFamilylogs()
    {
        return $this->familylogs;
    }
}
