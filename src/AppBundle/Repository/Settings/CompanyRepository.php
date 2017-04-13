<?php

/**
 * Entité Company.
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
 * CompanyRepository Entité Company.
 *
 * @category Entity
 */
class CompanyRepository extends EntityRepository
{
    /**
     * Affiche toutes les entreprises.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getAllItems()
    {
        $query = $this->createQueryBuilder('t')
            ->getQuery()->getResult();
        
        return $query;
    }

    /**
     * Affiche les entreprises actives.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems();

        return $query;
    }
}
