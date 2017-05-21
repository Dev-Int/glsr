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
 * @version GIT: <git_id>
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller\Install;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\Install\AbstractInstallController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use AppBundle\Entity\Staff\User;
use AppBundle\Form\Type\Staff\UserType;
use AppBundle\Form\Type\Settings\CompanyType;
use AppBundle\Form\Type\Settings\SettingsType;
use AppBundle\Form\Type\Settings\SupplierType;
use AppBundle\Form\Type\Settings\ArticleType;

/**
 * class InstallController
 *
 * @category Controller
 *
 * @Route("/install")
 */
class InstallController extends AbstractInstallController
{
    /**
     * Page d'accueil de l'installation.
     *
     * @Route("/", name="gs_install")
     * @Method({"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response Rendue de la page
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Install:index.html.twig');
    }
    
    /**
     * Etape 1 de l'installation.
     * Création des utilisateurs.
     *
     * @Route("/step1", name="gs_install_st1")
     * @Method({"POST","GET"})
     * @Template("AppBundle:Install:step1.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return array|\Symfony\Component\HttpFoundation\Response Rendue de la page
     */
    public function step1Action(Request $request)
    {
        $etm = $this->getDoctrine()->getManager();
        $ctUser = count($etm->getRepository('AppBundle:Staff\User')->findAll());
        $user = new User();
        $message = null;
        
        if ($ctUser > 0 && $request->getMethod() == 'GET') {
            $message = 'gestock.install.st1.yet_exist';
        }
        $form = $this->createForm(UserType::class, $user, array(
            'action' => $this->generateUrl('gs_install_st1'),
        ));
    
        if ($form->handleRequest($request)->isValid()) {
            $user->setEnabled(true);
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);
            $this->addFlash('info', 'gestock.install.st1.flash');
        }
        
        return array(
            'message' => $message,
            'form'    => $form->createView()
        );
    }
    
    /**
     * Etape 2 de l'installation.
     * Création de l'entreprise.
     *
     * @Route("/step2", name="gs_install_st2")
     * @Method({"POST","GET"})
     * @Template("AppBundle:Install:step2.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array Rendue de la page
     */
    public function step2Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Company',
            '\AppBundle\Entity\Settings\Company',
            CompanyType::class,
            2
        );
        
        return $return;
    }

    /**
     * Etape 3 de l'installation.
     * Création de la configuration.
     *
     * @Route("/step3", name="gs_install_st3")
     * @Method({"POST","GET"})
     * @Template("AppBundle:Install:step3.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|
     *     array<string,string|null|Settings|\Symfony\Component\Form\FormView> Rendue de la page
     */
    public function step3Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Settings',
            '\AppBundle\Entity\Settings\Settings',
            SettingsType::class,
            3
        );
        
        return $return;
    }

    /**
     * Etape 4 de l'installation.
     * Cronfiguration de l'application.
     *
     * @Route("/step4", name="gs_install_st4")
     * @Method({"GET"})
     * @Template("AppBundle:Install:step4.html.twig")
     *
     * @return \Symfony\Component\HttpFoundation\Response Rendue de la page
     */
    public function step4Action()
    {
        return $this->render('AppBundle:Install:step4.html.twig');
    }

    /**
     * Etape 5 de l'installation.
     * Création des fournisseurs.
     *
     * @Route("/step5", name="gs_install_st5")
     * @Method({"POST","GET"})
     * @Template("AppBundle:Install:step5.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|
     *     array<string,string|null|Supplier|\Symfony\Component\Form\FormView> Rendue de la page
     */
    public function step5Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Supplier',
            '\AppBundle\Entity\Settings\Supplier',
            SupplierType::class,
            5
        );
        
        return $return;
    }

    /**
     * Etape 6 de l'installation.
     * Création des articles.
     *
     * @Route("/step6", name="gs_install_st6")
     * @Method({"POST","GET"})
     * @Template("AppBundle:Install:step6.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Requète du formulaire
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|
     *     array<string,string|null|Article|\Symfony\Component\Form\FormView> Rendue de la page
     */
    public function step6Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Article',
            '\AppBundle\Entity\Settings\Article',
            ArticleType::class,
            6
        );
        
        return $return;
    }
    
    /**
     * Etape 7 de l'installation.
     * Inventaire d'installation.
     *
     * @Route("/step7", name="gs_install_st7")
     * @Method({"GET"})
     * @Template("AppBundle:Install:step7.html.twig")
     *
     * @return array Rendue de la page
     */
    public function step7Action()
    {
        $etm = $this->getDoctrine()->getManager();
        $settings = $etm->getRepository('AppBundle:Settings\Settings')->find(1);
        $message = null;

        if ($settings->getFirstInventory() !== null) {
            $message = 'gestock.install.st7.yet_exist';
        }

        return array('message' => $message);
    }
}
