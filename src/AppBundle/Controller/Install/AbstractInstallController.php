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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * AbstractInstall controller
 *
 * @category Controller
 */
abstract class AbstractInstallController extends Controller
{
    /**
     * Etape X de l'installation.
     * Fonction adaptable aux différentes étapes de l'installation.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    Form request
     * @param string                                    $entity     Entity name
     * @param string                                    $entityPath Entity Namespace
     * @param string                                    $typePath   Type of Namespace
     * @param int|string                                $number     Step number
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|
     *     array<string,string|null|Settings|\Symfony\Component\Form\FormView> Rendered view
     */
    public function stepAction(Request $request, $entity, $entityPath, $typePath, $number)
    {
        $etm = $this->getDoctrine()->getManager();
        $ctEntity = count($etm->getRepository('AppBundle:'.$entity)->findAll());
        $entityNew = $etm->getClassMetadata($entityPath)->newInstance();
        $message = null;
        
        if ($ctEntity > 0 && $request->getMethod() == 'GET' && is_int($number)) {
            $message = 'gestock.install.st'.$number.'.yet_exist';
        }
        $form = $this->createForm($typePath, $entityNew, array(
            'action' => $this->generateUrl('gs_install_st'.$number)
        ));
        if (is_int($number)) {
            $return = array('message' => $message, 'form' => $form->createView(),);
        } else {
            $return = array(
                strtolower($entity) => $entityNew,
                'form' => $form->createView(),
            );
        }

        if ($form->handleRequest($request)->isValid()) {
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($entityNew);
            $etm->flush();

            if ($form->get('save')->isClicked()) {
                $return = $this->redirect($this->generateUrl('gs_install_st4'));
            } elseif ($form->get('addmore')->isClicked()) {
                $return = $this->redirect($this->generateUrl('gs_install_st'.$number));
            } else {
                $return = $this->redirect($this->generateUrl('gs_install_st'.$number));
            }
            $this->addFlash('info', 'gestock.install.st'.$number.'.flash');
        }
        
        return $return;
    }
}
