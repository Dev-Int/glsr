<?php

/**
 * Entité Material.
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
 * MaterialRepository
 *
 * @category Entity
 */
class MaterialRepository extends EntityRepository
{
    /**
     * Affiche les matières.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getAllItems()
    {
        $query = $this->createQueryBuilder('m')
            ->join('m.articles', 'a')
            ->addSelect('a')
            ->join('m.unitWorking', 'u')
            ->addSelect('u')
        ;
        
        return $query;
    }

    /**
     * Affiche les matières actives.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems();
        
        return $query;
    }
}
