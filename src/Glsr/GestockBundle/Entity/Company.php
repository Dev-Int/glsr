<?php

/**
 * Entité Company.
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

/**
 * Company Entité Company.
 *
 * @category   Entity
 *
 * @ORM\Table(name="gs_company")
 * @ORM\Entity(repositoryClass="Glsr\GestockBundle\Entity\CompanyRepository")
 */
class Company extends Contact
{
    /**
     * @var string Statut de l'entreprise
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;


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
