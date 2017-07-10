<?php
/**
 * Entité Group.
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
namespace AppBundle\Entity\Staff;

use FOS\UserBundle\Model\Group as BaseGroup;
use AppBundle\Entity\Staff\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité Group.
 *
 * @category Entity
 *
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Staff\GroupRepository")
 * @ORM\Table(name="fos_group")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $roles;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Staff\User", mappedBy="groups")
     *
     */
    protected $users;

    public function __toString()
    {
        return $this->getName();
    }


    /**
     * Get Users
     *
     * @return AppBundle\Entity\Staff\User
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add users
     *
     * @param \AppBundle\Entity\Staff\User $users
     * @return Group
     */
    public function addUser(User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \AppBundle\Entity\Staff\User $users
     */
    public function removeUser(User $users)
    {
        $this->users->removeElement($users);
    }
}
