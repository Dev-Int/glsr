<?php

/**
 * Entité UnitStorage.
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
 * UnitRepository Entité Unit.
 *
 * PHP Version 5
 *
 * @category Entity
 */
class UnitRepository extends EntityRepository
{
    /**
     * Affiche toutes les unités.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getAllItems()
    {
        $query = $this->createQueryBuilder('u')
            ->orderBy('u.name', 'ASC');
        
        return $query;
    }

    /**
     * Affiche les unités actifs.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems();

        return $query;
    }
}
