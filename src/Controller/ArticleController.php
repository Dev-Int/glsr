<?php

/**
 * ArticleController Controller of Article entity.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @see https://github.com/Dev-Int/glsr
 */

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;
use App\Entity\Settings\Article;

/**
 * Article Controller override EasyAdminBundle::AdminController.
 *
 * @category Controller
 */
class ArticleController extends BaseAdminController
{
    /**
     * Allows applications to modify the entity associated with the item being
     * edited before updating it.
     *
     * @param Article $article
     */
    public function updateArticleEntity(Article $article)
    {
        $article->setUpdateAt(new \DateTime());
        parent::updateEntity($article);
    }

    /**
     * Allows applications to modify the entity associated with the item being
     * deleted before removing it.
     *
     * @param Article $article
     */
    protected function removeArticleEntity(Article $article)
    {
        $article->setUpdateAt(new \DateTime());
        $article->setDeleteAt(new \DateTime());
        $article->setActive(false);
        $this->em->persist($article);
        $this->em->flush();
    }
}
