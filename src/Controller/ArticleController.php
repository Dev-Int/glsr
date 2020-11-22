<?php

namespace App\Controller;

use Doctrine\ORM\ORMException;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;
use App\Entity\Settings\Article;

final class ArticleController extends BaseAdminController
{
    /**
     * Allows applications to modify the entity associated with the item being
     * edited before updating it.
     */
    public function updateArticleEntity(Article $article): void
    {
        $article->setUpdateAt(new \DateTimeImmutable());
        $this->updateEntity($article);
    }

    /**
     * Allows applications to modify the entity associated with the item being
     * deleted before removing it.
     *
     * @throws ORMException
     */
    protected function removeArticleEntity(Article $article): void
    {
        $article->setUpdateAt(new \DateTimeImmutable());
        $article->setDeleteAt(new \DateTimeImmutable());
        $article->setActive(false);
        $this->em->persist($article);
        $this->em->flush();
    }
}
