<?php

/**
 * Entité Company.
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
namespace AppBundle\Entity\Settings;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Contact;

/**
 * Company Entité Company.
 *
 * @category Entity
 *
 * @ORM\Table(name="gs_company")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Settings\CompanyRepository")
 */
class Company extends Contact
{
    /**
     * @var int id de l'entreprise
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string Statut de l'entreprise
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

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
     * Set status.
     *
     * @param string $status Statut juridique
     *
     * @return Company
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
