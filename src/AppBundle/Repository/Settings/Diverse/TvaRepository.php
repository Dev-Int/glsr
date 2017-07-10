<?php

/**
 * Entité Tva.
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
 * TvaRepository.
 *
 * @category Entity
 */
class TvaRepository extends EntityRepository
{
    /**
     * Affiche tous les taux.
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
     * Affiche les taux actifs.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems();

        return $query;
    }
}
