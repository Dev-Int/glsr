<?php

/**
 * Entité Supplier.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    since 1.0.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SupplierRepository Entité Supplier.
 *
 * @category   Entity
 */
class SupplierRepository extends EntityRepository
{
    /**
     * Renvoie les fournisseurs correspondant à la famille logistique
     * et sous-famille logistique de l'article en paramètre.
     *
     * @param AppBundle\Entity\Article $article Article sélectionné
     *
     * @return QueryBuilder Requête DQL
     */
    public function getSupplierForReassign($article)
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.name != :idname')
            ->andWhere('s.family_log = :flname')
            ->andWhere('s.sub_family_log = :sflname')
            ->andWhere('s.active = 1')
            ->setParameters(
                array(
                    'idname' => $article->getSupplier()->getName(),
                    'flname' => $article->getFamilyLog(),
                    'sflname' => $article->getSubFamilyLog(),
                )
            )
            ->orderBy('s.name', 'ASC');

        return $query;
    }
}
