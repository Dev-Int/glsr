<?php
/**
 * Entity User.
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

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
 
/**
 * User Entity.
 *
 * @category Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\Staff\UserRepository")
 * @ORM\Table(name="fos_user")
 * @UniqueEntity(fields="usernameCanonical", errorPath="username",
 *     message="fos_user.username.already_used", groups={"Default", "Registration", "Profile"})
 * @UniqueEntity(fields="emailCanonical", errorPath="email",
 *     message="fos_user.email.already_used", groups={"Default", "Registration", "Profile"})
 */
class User extends BaseUser
{
    /**
     * @var int $usrId User id
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $usrId;
 
    /**
     * @var Group $groups Objects App\Entity\Staff\Group
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Staff\Group", inversedBy="users")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
 
    /**
     * @ORM\Column(type="integer", length=6, options={"default":0})
     */
    protected $loginCount = 0;
 
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $firstLogin;
 
    public function __construct()
    {
        parent::__construct();
        $this->groups = new ArrayCollection();
    }

    public function getId()
    {
        return $this->usrId;
    }
    /**
     * Set loginCount
     *
     * @param integer $loginCount
     *
     * @return User
     */
    public function setLoginCount($loginCount)
    {
        $this->loginCount = $loginCount;
        return $this;
    }
 
    /**
     * Get loginCount
     *
     * @return integer
     */
    public function getLoginCount()
    {
        return $this->loginCount;
    }
 
    /**
     * Set firstLogin
     *
     * @param \DateTime $firstLogin
     *
     * @return User
     */
    public function setFirstLogin($firstLogin)
    {
        $this->firstLogin = $firstLogin;
        return $this;
    }
 
    /**
     * Get firstLogin
     *
     * @return \DateTime
     */
    public function getFirstLogin()
    {
        return $this->firstLogin;
    }
 
    public function isEnabled()
    {
        return $this->enabled;
    }
 
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }
 
    public function setPassword($password)
    {
        if ($password !== null) {
            $this->password = $password;
        }
        return $this;
    }
 
    public function setGroups(ArrayCollection $groups = null)
    {
        if ($groups !== null) {
            $this->groups = $groups;
        }
    }
 
    public function setRoles(array $roles = array())
    {
        $this->roles = array();
        foreach ($roles as $role) {
            $this->addRole($role);
        }
        return $this;
    }
 
    public function hasGroup($name = '')
    {
        return in_array($name, $this->getGroupNames());
    }
}
