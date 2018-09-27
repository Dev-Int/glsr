<?php

/**
 * Entité ZoneStorage.
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
namespace AppBundle\Repository\Settings\Diverse;

use Doctrine\ORM\EntityRepository;

/**
 * ZoneStorageRepository Entité ZoneStorage.
 *
 * @category Entity
 */
class ZoneStorageRepository extends EntityRepository
{
    /**
     * Affiche toutes les zones.
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
     * Affiche les zones actives.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems();

        return $query;
    }
}