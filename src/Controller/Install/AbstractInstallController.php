<?php
/**
 * AbstractInstallController Installation controller of the GLSR application.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @see      https://github.com/Dev-Int/glsr
 */

namespace App\Controller\Install;

use App\Controller\AbstractAppController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * AbstractInstall controller.
 *
 * @category Controller
 */
abstract class AbstractInstallController extends AbstractAppController
{
    /**
     * Step X of the installation.
     * Function adaptable to the different stages of the installation.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    Form request
     * @param string                                    $entityName Entity name
     * @param string                                    $entityPath Entity Namespace
     * @param string                                    $typePath   Type of Namespace
     * @param int|string                                $number     Step number
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|
     *     array<string,string|null|Settings|\Symfony\Component\Form\FormView> Rendered view
     */
    public function stepAction(Request $request, $entityName, $entityPath, $typePath, $number)
    {
        $etm = $this->getDoctrine()->getManager();
        $ctEntity = count($etm->getRepository('App:'.$entityName)->findAll());
        $entityNew = $etm->getClassMetadata($entityPath)->newInstance();
        $message = null;

        if ($ctEntity > 0 && 'GET' == $request->getMethod() && is_numeric($number) && 5 != $number) {
            $message = 'gestock.install.st'.$number.'.yet_exist';
        }
        $form = $this->createForm($typePath, $entityNew, ['action' => $this->generateUrl('gs_install_st'.$number)]);
        if ('Staff\Group' === $entityName) {
            $this->addRolesAction($form, $entityNew);
        }
        if (is_int($number)) {
            $return = ['message' => $message, 'form' => $form->createView()];
        } else {
            $return = ['message' => $message,
                $this->nameToVariable($entityName) => $entityNew,
                'form' => $form->createView(), ];
        }
        if ('Settings\Diverse\Material' === $entityName) {
            $articles = $etm->getRepository('App:Settings\Article')->findAll();
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
     * @param int|string                                 $number     Number of step install
     * @param string                                     $entityName Entity name
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse Route after valid or not
     */
    private function validInstall($entityNew, $form, ObjectManager $etm, $number, $entityName)
    {
        $options = [];
        $return = '';
        if ('Settings\Diverse\Material' === $entityName) {
            $articles = $etm->getRepository('App:Settings\Article')->findAll();
            $options = ['articles' => $articles];
        }
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

    /**
     * Transform a Namespace to string of class.
     *
     * @param string $name Namespace to transform
     *
     * @return string
     */
    private function nameToVariable($name)
    {
        $array = explode('\\', $name);
        $return = strtolower(end($array));

        return $return;
    }
}
