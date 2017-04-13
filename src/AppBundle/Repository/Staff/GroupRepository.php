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
namespace AppBundle\Repository\Staff;

use Doctrine\ORM\EntityRepository;

/**
 * GroupRepository Entité Group.
 *
 * PHP Version 5
 *
 * @category Entity
 */
class GroupRepository extends EntityRepository
{
    /**
     * Affiche toutes les configurations.
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
     * Affiche les configurations actives.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems();

        return $query;
    }
}
