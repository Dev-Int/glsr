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
namespace App\Repository\Staff;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository Entity.
 *
 * PHP Version 7
 *
 * @category Entity
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
        $query = $this->getItems();
        
        return $query;
    }

    /**
     * Display all users with their group.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getAllItems()
    {
        $query = $this->createQueryBuilder('u')
            ->join('u.groups', 'g')
            ->addSelect('g')
        ;
        
        return $query;
    }

    /**
     * Display all active users.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems()
            ->where('u.enabled = 1')
        ;

        return $query;
    }
}
