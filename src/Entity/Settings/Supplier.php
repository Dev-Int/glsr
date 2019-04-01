<?php

/**
 * Entity Supplier.
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

namespace App\Entity\Settings;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\Contact;
use App\Entity\Settings\Diverse\FamilyLog;
use App\Entity\Settings\Article;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
     * @Assert\NotBlank(message="Il vous faut choisir au moins UNE date de commande.")
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
     * @var \Doctrine\Common\Collections\ArrayCollection Articles
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Settings\Article", mappedBy="supplier")
     */
    private $articles;

    /**
     * __construct.
     */
    public function __construct()
    {
        $this->active = true;
        $this->articles = new ArrayCollection();
    }

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
     * @param \App\Entity\Settings\Diverse\FamilyLog|null $familyLog Logistic family
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
     * Get slug.
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
     * @param Article $articles
     * @return Supplier
     */
    public function addArticles(Article $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * @param \App\Entity\Settings\Article $articles Articles to delete
     *
     * @return \Doctrine\Common\Collections\ArrayCollection|null
     */
    public function removeZoneStorage(Article $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * @return Doctrine\Common\Collections\Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
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
