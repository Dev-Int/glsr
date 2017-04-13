<?php

/**
 * Entité User.
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
namespace AppBundle\Repository\Staff;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository Entité User.
 *
 * PHP Version 5
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
     * Affiche toutes les configurations.
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
     * Affiche les configurations actives.
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
