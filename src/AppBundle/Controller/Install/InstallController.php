<?php
/**
 * InstallController controller d'installation de l'application GLSR.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version   since 1.0.0
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller\Install;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use AppBundle\Entity\Company;
use AppBundle\Form\Type\CompanyType;
use AppBundle\Entity\Settings;
use AppBundle\Form\Type\SettingsType;
use AppBundle\Entity\Supplier;
use AppBundle\Form\Type\SupplierType;
use AppBundle\Entity\Article;
use AppBundle\Form\Type\ArticleType;

/**
 * class InstallController
 *
 * @category Controller
 *
 * @Route("/install")
 */
class InstallController extends Controller
{
    /**
     * Page d'accueil de l'installation.
     *
     * @Route("/", name="gs_install")
     *
     * @return Symfony\Component\HttpFoundation\Response Rendue de la page
     */
    public function indexAction()
    {
        return $this->render('AppBundle:install:index.html.twig');
    }
    
    /**
     * Etape 1 de l'installation.
     * Création des utilisateurs.
     *
     * @Route("/step1", name="gs_install_st1")
     * @Method({"POST","GET"})
     * @Template("AppBundle:install:step1.html.twig")
     *
     * @param Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return array|null|User|\Symfony\Component\Form\FormView Rendue de la page
     */
    public function step1Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ctUser = count($em->getRepository('AppBundle:User')->findAll());
        $user = new User();
        $message = null;
        
        if ($ctUser > 0 && $request->getMethod() == 'GET') {
            $message = 'gestock.install.st1.yet_exist';
        }
        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('gs_install_st1'),
        ));

        if ($form->handleRequest($request)->isValid()) {
            $user->setEnabled(true);
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);
        }
        
        return array(
            'message' => $message,
            'user'    => $user,
            'form'    => $form->createView()
        );
    }
    
    /**
     * Etape 2 de l'installation.
     * Création de l'entreprise.
     *
     * @Route("/step2", name="gs_install_st2")
     * @Method({"POST","GET"})
     * @Template("AppBundle:install:step2.html.twig")
     *
     * @param Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array|null|Company|\Symfony\Component\Form\FormView Rendue de la page
     */
    public function step2Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ctCompany = count($em->getRepository('AppBundle:Company')->findAll());
        $company = new Company();
        $message = null;
        
        if ($ctCompany > 0 && $request->getMethod() == 'GET') {
            $message = 'gestock.install.st2.yet_exist';
        }
        $form = $this->createForm(new CompanyType(), $company, array(
            'action' => $this->generateUrl('gs_install_st2')
        ));
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            return $this->redirect($this->generateUrl('gs_install_st2'));
        }

        return array('message' => $message, 'company' => $company, 'form'    => $form->createView());
    }

    /**
     * Etape 3 de l'installation.
     * Création de la configuration.
     *
     * @Route("/step3", name="gs_install_st3")
     * @Method({"POST","GET"})
     * @Template("AppBundle:install:step3.html.twig")
     *
     * @param Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array|null|Settings|\Symfony\Component\Form\FormView Rendue de la page
     */
    public function step3Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ctSettings = count($em->getRepository('AppBundle:Settings')->findAll());
        $settings = new Settings();
        $message = null;
        
        if ($ctSettings > 0 && $request->getMethod() == 'GET') {
            $message = 'gestock.install.st3.yet_exist';
        }
        $form = $this->createForm(new SettingsType(), $settings, array(
            'action' => $this->generateUrl('gs_install_st3')
        ));
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($settings);
            $em->flush();

            return $this->redirect($this->generateUrl('gs_install_st3'));
        }

        return array('message' => $message, 'settings' => $settings, 'form' => $form->createView());
    }

    /**
     * Etape 4 de l'installation.
     * Cronfiguration de l'application.
     *
     * @Route("/step4", name="gs_install_st4")
     * @Method({"GET"})
     * @Template("AppBundle:install:step4.html.twig")
     *
     * @return Symfony\Component\HttpFoundation\Response Rendue de la page
     */
    public function step4Action()
    {
        return $this->render('AppBundle:install:step4.html.twig');
    }

    /**
     * Etape 5 de l'installation.
     * Création des fournisseurs.
     *
     * @Route("/step5", name="gs_install_st5")
     * @Method({"POST","GET"})
     * @Template("AppBundle:install:step5.html.twig")
     *
     * @param Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array|null|Supplier|\Symfony\Component\Form\FormView Rendue de la page
     */
    public function step5Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ctSupplier = count($em->getRepository('AppBundle:Supplier')->findAll());
        $suppliers = new Supplier();
        $message = null;
        
        if ($ctSupplier > 0 && $request->getMethod() == 'GET') {
            $message = 'gestock.install.st5.yet_exist';
        }
        $form = $this->createForm(new SupplierType(), $suppliers, array(
            'action' => $this->generateUrl('gs_install_st5')
        ));
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($suppliers);
            $em->flush();

            return $this->redirect($this->generateUrl('gs_install_st5'));
        }

        return array('message' => $message, 'suppliers' => $suppliers, 'form' => $form->createView());
    }

    /**
     * Etape 6 de l'installation.
     * Création des articles.
     *
     * @Route("/step6", name="gs_install_st6")
     * @Method({"POST","GET"})
     * @Template("AppBundle:install:step6.html.twig")
     *
     * @param Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array|null|Article|\Symfony\Component\Form\FormView Rendue de la page
     */
    public function step6Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ctArticles = count($em->getRepository('AppBundle:Article')->findAll());
        $articles = new Article();
        $message = null;
        
        if ($ctArticles > 0 && $request->getMethod() == 'GET') {
            $message = 'gestock.install.st6.yet_exist';
        }
        $form = $this->createForm(new ArticleType(), $articles, array(
            'action' => $this->generateUrl('gs_install_st6')
        ));
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($articles);
            $em->flush();

            return $this->redirect($this->generateUrl('gs_install_st6'));
        }

        return array('message' => $message, 'articles' => $articles, 'form' => $form->createView());
    }
    
    /**
     * Etape 7 de l'installation.
     * Inventaire d'installation.
     *
     * @Route("/step7", name="gs_install_st7")
     * @Method({"GET"})
     * @Template("AppBundle:install:step7.html.twig")
     *
     * @return array|null Rendue de la page
     */
    public function step7Action()
    {
        $em = $this->getDoctrine()->getManager();
        $settings = $em->getRepository('AppBundle:Settings')->find(1);
        $message = null;

        if ($settings->getFirstInventory() === null) {
            $message = 'gestock.install.st7.yet_exist';
        }

        return array('message' => $message);
    }
}
