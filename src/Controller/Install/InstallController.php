<?php
/**
 * InstallController Installation controller of the GLSR application.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace App\Controller\Install;

use Symfony\Component\HttpFoundation\Request;
use App\Controller\Install\AbstractInstallController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use App\Entity\Staff\User;
use App\Form\Type\Staff\GroupType;
use App\Form\Type\Staff\UserType;
use App\Form\Type\Settings\CompanyType;
use App\Form\Type\Settings\SettingsType;
use App\Form\Type\Settings\SupplierType;
use App\Form\Type\Settings\ArticleType;
use App\Form\Type\Settings\Diverse\MaterialType;

/**
 * Class InstallController
 *
 * @category Controller
 *
 * @Route("/install")
 */
class InstallController extends AbstractInstallController
{
    /**
     * Home page of the installation.
     *
     * @Route("/", name="gs_install")
     * @Method({"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response Return of the page
     */
    public function indexAction()
    {
        $step = filter_input(INPUT_GET, 'step');
        return $this->render('Install/index.html.twig', ['step' => $step]);
    }
    
    /**
     * Step 1 of the installation.
     * Creating groups.
     *
     * @Route("/step1", name="gs_install_st1")
     * @Method({"POST","GET"})
     * @Template("install/step1.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Request form
     *
     * @return array|\Symfony\Component\HttpFoundation\Response Return of the page
     */
    public function step1Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Staff\Group',
            '\App\Entity\Staff\Group',
            GroupType::class,
            1
        );
        
        return $return;
    }
    
    /**
     * Step 2 of the installation.
     * Creation of users.
     *
     * @Route("/step2", name="gs_install_st2")
     * @Method({"POST","GET"})
     * @Template("install/step2.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Request form
     *
     * @return array|\Symfony\Component\HttpFoundation\Response Return of the page
     */
    public function step2Action(Request $request)
    {
        $etm = $this->getDoctrine()->getManager();
        $ctUser = count($etm->getRepository('App:Staff\User')->findAll());
        $user = new User();
        $message = null;
        
        if ($ctUser > 0 && $request->getMethod() == 'GET') {
            $message = 'gestock.install.st2.yet_exist';
        }
        $form = $this->createForm(UserType::class, $user, array(
            'action' => $this->generateUrl('gs_install_st2'),
        ));
    
        if ($form->handleRequest($request)->isValid()) {
            $user->setEnabled(true);
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);
            $this->addFlash('info', 'gestock.install.st2.flash');
        }
        
        return array(
            'message' => $message,
            'form'    => $form->createView()
        );
    }
    
    /**
     * Step 3 of the installation.
     * Company creation.
     *
     * @Route("/step3", name="gs_install_st3")
     * @Method({"POST","GET"})
     * @Template("install/step3.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Request form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array Return of the page
     */
    public function step3Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Company',
            '\App\Entity\Settings\Company',
            CompanyType::class,
            3
        );
        
        return $return;
    }

    /**
     * Step 4 of the installation.
     * Creation of the configuration.
     *
     * @Route("/step4", name="gs_install_st4")
     * @Method({"POST","GET"})
     * @Template("install/step4.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Request form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|
     *     array<string,string|null|Settings|\Symfony\Component\Form\FormView> Return of the page
     */
    public function step4Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Settings',
            '\App\Entity\Settings\Settings',
            SettingsType::class,
            4
        );
        
        return $return;
    }

    /**
     * Step 5 of the installation.
     * Configuration of the application.
     *
     * @Route("/step5", name="gs_install_st5")
     * @Method({"GET"})
     * @Template("install/step5.html.twig")
     *
     * @return \Symfony\Component\HttpFoundation\Response Return of the page
     */
    public function step5Action()
    {
        return $this->render('Install/step5.html.twig');
    }

    /**
     * Step 6 of the installation.
     * Creation of suppliers.
     *
     * @Route("/step6", name="gs_install_st6")
     * @Method({"POST","GET"})
     * @Template("install/step6.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Request form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|
     *     array<string,string|null|Supplier|\Symfony\Component\Form\FormView> Return of the page
     */
    public function step6Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Supplier',
            '\App\Entity\Settings\Supplier',
            SupplierType::class,
            6
        );
        
        return $return;
    }

    /**
     * Step 7 of the installation.
     * Creation of articles.
     *
     * @Route("/step7", name="gs_install_st7")
     * @Method({"POST","GET"})
     * @Template("install/step7.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Request form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|
     *     array<string,string|null|Article|\Symfony\Component\Form\FormView> Return of the page
     */
    public function step7Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Article',
            '\App\Entity\Settings\Article',
            ArticleType::class,
            7
        );
        
        return $return;
    }

    /**
     * Step 8 of the installation.
     * Creation of materials.
     *
     * @Route("/step8", name="gs_install_st8")
     * @Method({"POST","GET"})
     * @Template("install/step8.html.twig")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Request form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|
     *     array<string,string|null|Article|\Symfony\Component\Form\FormView> Return of the page
     */
    public function step8Action(Request $request)
    {
        $return = $this->stepAction(
            $request,
            'Settings\Diverse\Material',
            '\App\Entity\Settings\Diverse\Material',
            MaterialType::class,
            8
        );
        
        return $return;
    }
    
    /**
     * Step 9 of the installation.
     * Installation inventory.
     *
     * @Route("/step9", name="gs_install_st9")
     * @Method({"GET"})
     * @Template("install/step9.html.twig")
     *
     * @return array Return of the page
     */
    public function step9Action()
    {
        $etm = $this->getDoctrine()->getManager();
        $inventory = $etm->getRepository('App:Stocks\Inventory')->findAll();
        $message = null;

        if (!empty($inventory)) {
            $message = 'gestock.install.st9.yet_exist';
        }

        return array('message' => $message);
    }
}
