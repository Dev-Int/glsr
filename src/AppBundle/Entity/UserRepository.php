<?php

/**
 * Entité User.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    since 1.0.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository Entité User.
 *
 * PHP Version 5
 *
 * @category   Entity
 */
class UserRepository extends EntityRepository
{
    /**
     * Display enabled users.
     *
     * @return QueryBuilder DQL Request
     */
    public function getUsers()
    {
        $query = $this->createQueryBuilder('u')
            ->join('u.groups', 'g')
            ->addSelect('g')
            ->where('u.enabled = 1')
        ;
        
        return $query;
    }
}
