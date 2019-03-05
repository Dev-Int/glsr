<?php

/**
 * Entity Company.
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
 * CompanyRepository Entity.
 *
 * @category Entity
 */
class CompanyRepository extends EntityRepository
{
    /**
     * Displays all companies.
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
     * Displays active companies.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems();

        return $query;
    }
}
