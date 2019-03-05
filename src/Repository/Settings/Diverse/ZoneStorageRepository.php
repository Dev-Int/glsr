<?php

/**
 * Entity ZoneStorage.
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
namespace App\Repository\Settings\Diverse;

use Doctrine\ORM\EntityRepository;

/**
 * ZoneStorageRepository Entity.
 *
 * @category Entity
 */
class ZoneStorageRepository extends EntityRepository
{
    /**
     * Displays all zones.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getAllItems()
    {
        $query = $this->createQueryBuilder('z')
            ->orderBy('z.name', 'ASC')
            ->getQuery()->getResult();
        
        return $query;
    }

    /**
     * Displays all active zones.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems();

        return $query;
    }
}
