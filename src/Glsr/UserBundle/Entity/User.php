<?php

/**
 * User Entité User.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    GIT: 2d028e49620749c91f41f3837f4255a2cf8c98bd
 *
 * @link       https://github.com/GLSR/glsr
 */
namespace Glsr\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User Entité User.
 *
 * @category   Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="gs_user")
 */
class User extends BaseUser
{
    /**
     * @var int Id de l'utilisateur
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}
