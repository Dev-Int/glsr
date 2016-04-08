<?php
/**
 * DefaultController controller de l'application GLSR.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version since 1.0.0
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\Type\SubFamilyLogType;

/**
 * Default controller.
 *
 * @category Controller
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
    private $entities;
    
    public function __construct()
    {
        // Tableau des entitées
        $this->entities = array(
            'AppBundle:User',
            'AppBundle:Company',
            'AppBundle:Settings',
            'AppBundle:FamilyLog',
            'AppBundle:SubFamilyLog',
            'AppBundle:ZoneStorage',
            'AppBundle:UnitStorage',
            'AppBundle:Tva',
            'AppBundle:Supplier',
            'AppBundle:Article',
            'AppBundle:Settings');

    }

    /**
     * @Route("/", name="_home")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $url = "";
        /**
         * Test d'installation
         */
//        $url = $this->testEntities();
        if (empty($url)) {
            $url = $this->render('default/index.html.twig');
        } else {
            $url = $this->redirectToRoute($url);
        }
        // replace this example code with whatever you need
        return $url;
    }

    /**
     * Test des entités
     *
     * @return array
     */
    private function testEntities()
    {
        $url = null;
        $etm = $this->getDoctrine()->getManager();
        // vérifie que les Entitées ne sont pas vides
        $nbEntities = count($this->entities);
        for ($index = 0; $index < $nbEntities; $index++) {
            $entity = $etm->getRepository(
                $this->entities[$index]
            );
            $entityData = $entity->find(1);

            if (empty($entityData)) {
                $message = 'gestock.install.none';
//                $url = 'gs_install'; break;
                $url = '_home';
                break;
            } elseif ($index === 10 && $entityData->getFirstInventory() === null) {
                $message = 'gestock.settings.application.first_inventory.none';
//                $url = 'gestock_inventory_prepare'; break;
                $url = '_home';
                break;
            }
        }
        if (isset($message)) {
            $this->addFlash('warning', $message);
        }
        return $url;
    }

    /**
     * Récupère les subFamilyLog de la FamilyLog sélectionnée.
     *
     * @Route("/fill_subfamilylog", name="fill_subfamilylog")
     * @Method("POST")
     * @return Response
     */
    public function fillSubFamilyLogAction()
    {
        $request = $this->getRequest();
        $etm = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $famLogId = '';
            $subFamId = '';
            $famLogId = $request->get('id');
            $subFamId = $request->get('id2');
            if ($famLogId  != '') {
                $subFamilyLogs = $etm
                    ->getRepository('AppBundle:subFamilyLog')
                    ->getFromFamilyLog($famLogId);
                $familyLog = $etm
                    ->getRepository('AppBundle:familyLog')
                    ->find($famLogId);
                $tabSubFamilyLog = array();
                $tabSubFamilyLog[0]['idOption'] = '';
                $tabSubFamilyLog[0]['nameOption']
                    = 'Choice the Sub Family: '.$familyLog->getName();
                $iterator = 1;
                foreach ($subFamilyLogs as $subFamilyLog) {
                    $tabSubFamilyLog[$iterator]['idOption']
                        = $subFamilyLog->getId();
                    $tabSubFamilyLog[$iterator]['nameOption']
                        = $subFamilyLog->getName();
                    if ($subFamId != '') {
                        $tabSubFamilyLog[$iterator]['optionOption']
                            = 'selected="selected"';
                    } else {
                        $tabSubFamilyLog[$iterator]['optionOption'] = null;
                    }
                    $iterator++;
                }
                $response = new Response();
                $data = json_encode($tabSubFamilyLog);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($data);
                return $response;
            }
        }
        return new Response('Error');
    }

    /**
     * Récupère les FamilyLog de la requête post.
     *
     * @Route("/getfamilylog", name="getfamilylog")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getFamilyLogAction()
    {
        $request = $this->getRequest();
        $etm = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $id = '';
            $id = $request->get('id');
            if ($id != '') {
                $supplier = $etm
                    ->getRepository('AppBundle:Supplier')
                    ->find($id);
                $familyLog['familylog'] = $supplier->getFamilyLog()->getId();
                if (null !== $supplier->getSubFamilyLog()) {
                    $familyLog['subfamilylog']
                        = $supplier->getSubFamilyLog()->getId();
                }
                $response = new Response();
                $data = json_encode($familyLog);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($data);
                return $response;
            }
        }
        return new Response('Error');
    }
    
    /**
     * @Route("/chose-device", name="choseDevice")
     * @Template()
     */
    public function choseTablet2Action()
    {
        $form = $this->createForm(new SubFamilyLogType());
        $familylog = $this->getDoctrine()->getRepository('AppBundle:FamilyLog')->findAll();

        return array(
            'form'      => $form->createView(),
            'devices'   => json_encode($familylog),
        );
    }
}
