<?php

/**
 * Entity UnitStorage.
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
 * UnitRepository Entity.
 *
 * PHP Version 7
 *
 * @category Entity
 */
class UnitRepository extends EntityRepository
{
    /**
     * Displays all units.
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
     * Displays all active units.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems();

        return $query;
    }
}
