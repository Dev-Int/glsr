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
namespace App\Repository\Staff;

use Doctrine\ORM\EntityRepository;

/**
 * GroupRepository Entity.
 *
 * PHP Version 7
 *
 * @category Entity
 */
class GroupRepository extends EntityRepository
{
    /**
     * Display all groups.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getAllItems()
    {
        $query = $this->createQueryBuilder('g')
            ->getQuery()->getResult();
        
        return $query;
    }

    /**
     * Display all active groups.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems();

        return $query;
    }
}
