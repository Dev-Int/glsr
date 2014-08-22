<?php

/**
 * SupplierRepository Entité Supplier
 * 
 * PHP Version 5
 * 
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    GIT: f912c90cc23014686059cf730526a2874e826553
 * @link       https://github.com/GLSR/glsr
 */

namespace Glsr\GestockBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * SupplierRepository Entité Supplier
 * 
 * @category   Entity
 * @package    Gestock
 * @subpackage Supplier
 */
class SupplierRepository extends EntityRepository
{
    /**
     * getSuppliers Affiche les fournisseurs actifs, avec une pagination
     * 
     * @param integer $nbPerPage Nombre de fournisseurs par page
     * @param integer $page      Numéro de la page en cours
     * 
     * @return \Doctrine\ORM\Tools\Pagination\Paginator Objet Paginator
     * @throws \InvalidArgumentException
     */
    public function getSuppliers($nbPerPage, $page)
    {
        // On ne sait pas combien de pages il y a
        // Mais on sait qu'une page doit être supérieure ou égale à 1
        // Bien sûr pour le moment on ne se sert pas (encore !) de cette variable
        if ($page < 1) {
            // On déclenche une exception InvalidArgumentException
            // Cela va afficher la page d'erreur 404
            // On pourra la personnaliser plus tard
            throw new \InvalidArgumentException(
                'l\'argument $page ne peut être inférieur à 1 (valeur : "'
                . $page . '").'
            );
        }
        
        $query = $this->createQueryBuilder('s')
            ->where('s.active = 1')
            ->orderBy('s.name', 'ASC')
            ->getQuery();
        
        // On définit l'article à partir duquel commencer la liste
        $query->setFirstResult(($page - 1) * $nbPerPage)
            ->setMaxResults($nbPerPage); // Ainsi que le nombre d'article à afficher
        
        // Et enfin, on retourne l'objet Paginator
        // correspondant à la requête construite
        return new Paginator($query);
    }
    
    /**
     * getSupplierForReassign
     * Renvoie les fournisseurs correspondant à la famille logistique
     * et sous-famille logistique de l'article en paramètre
     * 
     * @param Glsr\GestockBundle\Entity\Article $article Article sélectionné
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
                    'idname'  => $article->getSupplier()->getName(),
                    'flname'  => $article->getFamilyLog(),
                    'sflname' => $article->getSubFamilyLog()
                )
            )
            ->orderBy('s.name', 'ASC');
        
        return $query;
    }
}
