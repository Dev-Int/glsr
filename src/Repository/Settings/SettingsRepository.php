<?php

/**
 * Entity Settings.
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
namespace App\Repository\Settings;

use Doctrine\ORM\EntityRepository;

/**
 * SettingsRepository Entity.
 *
 * @category Entity
 */
class SettingsRepository extends EntityRepository
{
    /**
     * Displays all configurations.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getAllItems()
    {
        $query = $this->createQueryBuilder('s')
            ->getQuery()->getResult();

        return $query;
    }

    /**
     * Displays active configurations.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems();

        return $query;
    }

    /**
     * Displays the first record.
     *
     * @return QueryBuilder Requête DQL
     */
    public function findFirst()
    {
        $query = $this->createQueryBuilder('s')
            ->setMaxResults(1)
            ->orderBy('s.id', 'ASC')
            ->getQuery()->getSingleResult();

            return $query;
    }
}
