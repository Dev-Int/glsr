<?php

/**
 * Entité Inventory.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    GIT: 66c30ad5658ae2ccc5f74e6258fa4716d852caf9
 *
 * @link       https://github.com/GLSR/glsr
 */
namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * InventoryRepository.
 *
 * @category   Entity
 */
class InventoryRepository extends EntityRepository
{
    /**
     * getActive Renvoie les inventaires actifs.
     *
     * @return array Query result
     */
    public function getActive()
    {
        $query = $this->createQueryBuilder('i')
            ->addSelect('i')
            ->where('i.active > 0')
            ->orderBy('i.date', 'DESC')
            ->getQuery();

        return $query->getResult();
    }
}
