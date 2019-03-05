<?php
/**
 * Entity Group.
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
namespace  App\Entity\Staff;

use FOS\UserBundle\Model\Group as BaseGroup;
use App\Entity\Staff\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Group Entity.
 *
 * @category Entity
 *
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\Staff\GroupRepository")
 * @ORM\Table(name="fos_group")
 */
class Group extends BaseGroup
{
    /**
     * @var int $grpId Group id
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $grpId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $roles;

    /**
     * @var array $users Array of users
     * @ORM\ManyToMany(targetEntity="App\Entity\Staff\User", mappedBy="groups")
     */
    protected $users;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->grpId;
    }

    /**
     * Get Users
     *
     * @return  App\Entity\Staff\User
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add users
     *
     * @param \App\Entity\Staff\User $users
     * @return Group
     */
    public function addUser(User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    public function hasRole($role)
    {
        if (is_array($this->roles)) {
            $return = in_array(strtoupper($role), $this->roles, true);
        } else {
            $return = false;
        }

        return $return;
    }

    /**
     * Remove users
     *
     * @param \App\Entity\Staff\User $users
     */
    public function removeUser(User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * This method allows to do "echo $group".
     * <p> So, to "show" $group,
     * PHP will actually show the return of this method. <br />
     * Here, the name, so "echo $group"
     * is equivalent to "echo $unit->getName()" </ p>.
     * @return string name
     */
    public function __toString()
    {
        return $this->getName();
    }
}
