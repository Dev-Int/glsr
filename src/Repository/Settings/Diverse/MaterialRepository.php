<?php

/**
 * Entity Material.
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
 * MaterialRepository
 *
 * @category Entity
 */
class MaterialRepository extends EntityRepository
{
    /**
     * Displays materials.
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
     * Displays active materials.
     *
     * @return QueryBuilder Requête DQL
     */
    public function getItems()
    {
        $query = $this->getAllItems()
            ->where('m.isActive = 1');
        
        return $query;
    }
}
