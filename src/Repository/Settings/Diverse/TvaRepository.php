<?php

/**
 * Entity Tva.
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
 * TvaRepository.
 *
 * @category Entity
 */
class TvaRepository extends EntityRepository
{
    /**
     * Show all rates.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getAllItems()
    {
        $query = $this->createQueryBuilder('t')
            ->orderBy('t.rate', 'ASC')
            ->getQuery()->getResult();
        
        return $query;
    }

    /**
     * Displays the active rates.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems();

        return $query;
    }
}
