<?php
/**
 * AbstractInstallController controller d'installation de l'application GLSR.
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

use AppBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * AbstractInstall controller
 *
 * @category Controller
 */
abstract class AbstractInstallController extends AbstractController
{
    /**
     * Etape X de l'installation.
     * Fonction adaptable aux différentes étapes de l'installation.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    Form request
     * @param string                                    $entityName Entity name
     * @param string                                    $entityPath Entity Namespace
     * @param string                                    $typePath   Type of Namespace
     * @param integer|string                            $number     Step number
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|
     *     array<string,string|null|Settings|\Symfony\Component\Form\FormView> Rendered view
     */
    public function stepAction(Request $request, $entityName, $entityPath, $typePath, $number)
    {
        $etm = $this->getDoctrine()->getManager();
        $ctEntity = count($etm->getRepository('AppBundle:'.$entityName)->findAll());
        $entityNew = $etm->getClassMetadata($entityPath)->newInstance();
        $message = null;

        if ($ctEntity > 0 && $request->getMethod() == 'GET' && is_numeric($number) && $number < 5) {
            $message = 'gestock.install.st'.$number.'.yet_exist';
        }
        $form = $this->createForm($typePath, $entityNew, ['action' => $this->generateUrl('gs_install_st'.$number),]);
        if ($entityName === 'Staff\Group') {
            $this->addRolesAction($form, $entityNew);
        }
        if (is_int($number)) {
            $return = ['message' => $message, 'form' => $form->createView(),];
        } else {
            $return = ['message' => $message,
                $this->nameToVariable($entityName) => $entityNew,
                'form' => $form->createView(),];
        }
        if ($entityName === 'Settings\Diverse\Material') {
            $articles = $etm->getRepository('AppBundle:Settings\Article')->findAll();
            $return['articles'] = $articles;
        }

        if ($form->handleRequest($request)->isValid()) {
            $return = $this->validInstall($entityNew, $form, $etm, $number, $entityName);
        }

        return $return;
    }

    /**
     * Valid install step.
     *
     * @param object                                     $entityNew  Entity
     * @param \Symfony\Component\Form\Form               $form       Form of Entity
     * @param \Doctrine\Common\Persistence\ObjectManager $etm        Entity Manager
     * @param integer|string                             $number     Number of step install
     * @param string                                     $entityName Entity name
     *
     * @return array Route after valid or not
     */
    private function validInstall($entityNew, $form, ObjectManager $etm, $number, $entityName)
    {
        $options = [];
        if ($entityName === 'Settings\Diverse\Material') {
            $articles = $etm->getRepository('AppBundle:Settings\Article')->findAll();
            $options = ['articles' => $articles];
        }
        $return = '';
        $etm->persist($entityNew);
        $etm->flush();
        if (is_numeric($number)) {
            $this->addFlash('info', 'gestock.install.st'.$number.'.flash');
        } else {
            $this->addFlash('info', 'gestock.install.st5.flash');
        }

        if (null !== $form->get('save') || null !== $form->get('addmore')) {
            if ($form->get('save')->isClicked() && is_numeric($number)) {
                $numberNext = $number++;
                $return = $this->redirect($this->generateUrl('gs_install_st'.$numberNext, $options));
            } elseif ($form->get('save')->isClicked() && !is_numeric($number)) {
                $return = $this->redirect($this->generateUrl('gs_install_st5'));
            } elseif ($form->get('addmore')->isClicked()) {
                $return = $this->redirect($this->generateUrl('gs_install_st'.$number, $options));
            }
        } else {
            $return = $this->redirect($this->generateUrl('gs_install_st'.$number, $options));
        }

        return $return;
    }

    private function nameToVariable($name)
    {

        $array = explode('\\', $name);
        $return = strtolower(end($array));

        return $return;
    }
}
