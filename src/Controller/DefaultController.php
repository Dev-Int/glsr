<?php

/**
 * DefaultController controller de l'application.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @link      https://github.com/Dev-Int/glsr
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of DefaultController
 *
 * @category Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * Get FamilyLog.
     *
     * @Route("/getfamilylog", name="getfamilylog", methods="POST")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Post request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFamilyLogAction(Request $request)
    {
        $return = new Response('Error');

        if ($request->isXmlHttpRequest()) {
            $familyLog = array();
            $id = $request->get('id');
            if ($id != '') {
                // Add directs childrens of $familyLog
                $familyLog = $this->testLevel($familyLog, $id);

                $response = new Response();
                $data = json_encode($familyLog);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($data);
                $return = $response;
            }
        }
        return $return;
    }

    /**
     * Get the SubFamily of Supplier.
     *
     * @param array $familyLog
     * @param int   $id
     */
    protected function getSubFamily(array $familyLog, $id)
    {
        // Get all datas
        $etm = $this->getDoctrine()->getManager();
        $supplier = $etm->getRepository('App:Settings\Supplier')->find($id);
        $familyLogs = $etm->getRepository('App:Settings\Diverse\FamilyLog')->findAll();

        // First return data needed
        $familyLog['id'] = $supplier->getFamilyLog()->getId();
        $testFamily = '';
        foreach ($familyLogs as $family) {
            if ($family->getId() === $familyLog['id']) {
                $testFamily = $family;
            }
        }
        if ($testFamily->getLevel() === 2) {
            $familyLog['family']['id'] = $testFamily->getId();
            $familyLog['family']['name'] = $testFamily->getIndentedName();
            $key = 0;
            foreach ($familyLogs as $family) {
                if ($family->getParent() !== null && $family->getParent()->getId() === $familyLog['id']) {
                    $familyLog['family'][$key]['id'] = $family->getId();
                    $familyLog['family'][$key]['name'] = $family->getIndentedName();
                    $key++;
                }
            }
        }
        return $familyLog;
    }
}
