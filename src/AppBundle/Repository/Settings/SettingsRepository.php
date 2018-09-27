<?php

/**
 * Entité Settings.
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
namespace AppBundle\Repository\Settings;

use Doctrine\ORM\EntityRepository;

/**
 * SettingsRepository Entité Settings.
 *
 * @category Entity
 */
class SettingsRepository extends EntityRepository
{
    /**
     * Affiche toutes les configurations.
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
     * Affiche les configurations actives.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems();

        return $query;
    }

    /**
     * Affiche le premier enregistrement.
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
