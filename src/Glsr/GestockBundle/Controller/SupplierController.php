<?php

/**
 * SupplierController controller de l'entité supplier.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    GIT: a4408b1f9fc87a1f93911d80e8421fef1bd96cab
 *
 * @link       https://github.com/GLSR/glsr
 */
namespace Glsr\GestockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Glsr\GestockBundle\Entity\Supplier;
use Glsr\GestockBundle\Form\Type\SupplierType;
use Glsr\GestockBundle\Form\Type\SupplierDeleteType;

/**
 * class SupplierController.
 *
 * @category   Controller
 */
class SupplierController extends Controller
{
    /**
     * affiche la liste des fournisseurs (pagination).
     *
     * @param type $page numéro de page
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($page)
    {
        // On récupère le nombre d'article par page
        // depuis un paramètre du conteneur
        // cf app/config/parameters.yml
        $nbPerPage = $this->container->getParameter('glsr.nb_per_page');

        $etm = $this->getDoctrine()->getManager();
        $suppliers = $etm
            ->getRepository('GlsrGestockBundle:Supplier')
            ->getSuppliers($nbPerPage, $page);

        return $this->render(
            'GlsrGestockBundle:Gestock/Supplier:index.html.twig',
            array(
                'suppliers' => $suppliers,
                'page' => $page,
                'nb_page' => ceil(count($suppliers) / $nbPerPage) ?: 1,
            )
        );
    }
    /**
     * Ajoute un fournisseur.
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws AccessDeniedException
     */
    public function addShowAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $article = new Supplier();

        // On crée le formulaire grâce à l'ArticleType
        $form = $this->createForm(new SupplierType(), $article);

        return $this->render(
            'GlsrGestockBundle:Gestock/Supplier:add.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Ajoute un fournisseur.
     *
     * @param Request $request objet requète.
     *
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     * @throws AccessDeniedException
     */
    public function addProcessAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $supplier = new Supplier();
        $form = $this->createForm(new SupplierType(), $supplier);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($supplier);
            $etm->flush();

            if ($form->get('save')->isClicked()) {
                $url = $this->generateUrl('glstock_home');
            } elseif ($form->get('addmore')->isClicked()) {
                $url = $this->generateUrl('glstock_suppli_add');
            }
            $message = "glsr.gestock.supplier.create.ok";
        } else {
            $url = $this->generateUrl('glstock_suppli_add');
            $message = "glsr.gestock.supplier.create.no";
        }
        $this->get('session')->getFlashBag()->add('info', $message);
        return $this->redirect($url);
    }

    /**
     * Modifier un fournisseur.
     *
     * @param Supplier $supplier Objet fournisseur à modifier
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws AccessDeniedException
     */
    public function editShowAction(Supplier $supplier)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(new SupplierType(), $supplier);

        return $this->render(
            'GlsrGestockBundle:Gestock/Supplier:edit.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Modifier un fournisseur.
     *
     * @param Supplier $supplier Objet fournisseur à modifier
     * @param Request $request objet requète
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws AccessDeniedException
     */
    public function editProcessAction(Supplier $supplier, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $form = $this->createForm(new SupplierType(), $supplier);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($supplier);
            $etm->flush();
            $url = $this->generateUrl(
                'glstock_suppli_show',
                array('slug' => $supplier->getSlug())
            );
            $message = "glsr.gestock.supplier.edit.ok";
        } else {
            $url = $this->generateUrl('glstock_suppli_edit');
            $message = "glsr.gestock.supplier.edit.no";
        }
        $request->getSession()->getFlashBag()->add('info', $message);
        return $this->redirect($url);
    }

    /**
     * Supprimer un fournisseur.
     *
     * @param Supplier $supplier Objet fournisseur à supprimer
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws AccessDeniedException
     */
    public function deleteShowAction(Supplier $supplier)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        // Avant de supprimer quoi que ce soit,
        // il faut vérifier qu'aucun article
        // ne soit rattaché à ce fournisseur
        $etm = $this->getDoctrine()->getManager();
        $articles = $etm
            ->getRepository('GlsrGestockBundle:Article')
            ->getArticleFromSupplier($supplier->getId());

        if (count($articles) >= 1) {
            $message = 'glsr.gestock.supplier.delete.reassign';
            $this->get('session')->getFlashBag()->add('danger', $message);

            // Puis on redirige vers la page de réaffectation
            $url = $this->redirect(
                $this->generateUrl(
                    'glstock_reassign_article',
                    array('id' => $supplier->getId())
                )
            );
        } else {
            $form = $this->createForm(new SupplierDeleteType(), $supplier);

            // Si la requête est en GET,
            // on affiche une page de confirmation avant de supprimer
            $url = $this->render(
                'GlsrGestockBundle:Gestock/Supplier:delete.html.twig',
                array(
                    'supplier' => $supplier,
                    'form' => $form->createView(),
                    )
            );
        }
        return $url;
    }

    /**
     * Supprimer un fournisseur.
     *
     * @param Supplier $supplier Objet fournisseur à supprimer
     * @param Request $request objet requète
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws AccessDeniedException
     */
    public function deleteProcessAction(Supplier $supplier, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $form = $this->createForm(new SupplierDeleteType(), $supplier);

        $form->handleRequest($request);

        //On modifie l'état actif du fournisseur
        $supplier->setActive(0);

        if ($form->isValid()) {
            // On supprime le fournisseur
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($supplier);
            $etm->flush();
            // Puis on redirige vers l'accueil
            $url = $this->generateUrl('glstock_home');
            $message = 'glsr.gestock.supplier.delete.ok';
        } else {
            $message = 'glsr.gestock.supplier.delete.no';
            $url = $this->generateUrl(
                'glstock_suppli_del',
                array(
                    'id' => $supplier->getId(),
                )
            );
        }
        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', $message);
        // On redirige vers la page de visualisation
        //  de l'article nouvellement créé
        return $this->redirect($url);
    }

    /**
     * Afficher le fournisseur.
     *
     * @param Supplier $supplier Objet fournisseur à afficher
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Supplier $supplier)
    {
        $etm = $this->getDoctrine()->getManager();
        $articles = $etm
            ->getRepository('GlsrGestockBundle:Article')
            ->getArticleFromSupplier($supplier->getId());

        return $this->render(
            'GlsrGestockBundle:Gestock/Supplier:supplier.html.twig',
            array(
                'articles' => $articles,
                'supplier' => $supplier,
            )
        );
    }
}
