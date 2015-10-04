<?php

/**
 * GestockController controller du Bundle Gestock.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version   GIT: a4408b1f9fc87a1f93911d80e8421fef1bd96cab
 *
 * @link      https://github.com/GLSR/glsr
 */
namespace Glsr\GestockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * class GestockController.
 *
 * @category Controller
 */
class GestockController extends Controller
{
    /**
     * indexAction affiche la page d'accueil du Bundle.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        /**
         * Test d'installation
         */
        $url = $this->testEntities();

        if (empty($url)) {
            $url = $this->render('GlsrGestockBundle:Gestock:index.html.twig');
        } else {
            $url = $this->redirect($this->generateUrl($url));
        }
        return $url;
    }

    /**
     * Récupère les subFamilyLog de la FamilyLog sélectionnée.
     *
     * @param Request $request objet requète
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function fillSubFamilyLogAction(Request $request)
    {
        $etm = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $famLogId = $request->get('id');
            $subFamId = $request->get('id2');
            if ($famLogId  != '') {
                $subFamilyLogs = $etm
                    ->getRepository('GlsrGestockBundle:subFamilyLog')
                    ->getFromFamilyLog($famLogId);
                $familyLog = $etm
                    ->getRepository('GlsrGestockBundle:familyLog')
                    ->find($famLogId);
                $tabSubFamilyLog = array();
                $tabSubFamilyLog[0]['idOption'] = '';
                $tabSubFamilyLog[0]['nameOption']
                    = 'glsr.gestock.settings.diverse.choice_subfam'.$familyLog->getName();
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
            }
        }
        if (!$response) {
            $response = new Response('Error');
        }

        return $response;
    }

    /**
     * Récupère les FamilyLog de la requête post.
     *
     * @param Request $request objet requète
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function getFamilyLogAction(Request $request)
    {
        $etm = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $id = $request->get('id');
            if ($id != '') {
                $supplier = $etm
                    ->getRepository('GlsrGestockBundle:Supplier')
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
            }
        }
        if (!$response) {
            $response = new Response('Error');
        }

        return $response;
    }

    /**
     * alertsAction Récupère les Alertes.
     *
     * @param int $nombre nombres d'alertes à afficher
     *
     * @return type
     */
    public function alertsAction($nombre)
    {
        /*$liste = $this->getDoctrine()
            ->getManager()
            ->getRepository('GlsrGestockBundle:Article')
            ->findBy(
              array(),          // Pas de critère
              array('date' => 'desc'), // On trie par date décroissante
              $nombre,         // On sélectionne $nombre articles
              0                // À partir du premier
        );
        */
        $alerts = array(
            array('titre' => 'Cmde', 'num' => '002'),
            array('titre' => 'Cmde', 'num' => '0003'),
            array('titre' => 'Liv', 'num' => '0001'));

        return $this->render(
            'GlsrGestockBundle:Gestock:alerts.html.twig',
            array('list_alerts' => $alerts, 'nb' => $nombre)
        );
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
        // Tableau des entitées, routes
        $entities = array(
            array(
                'repository' => 'GlsrGestockBundle:Company',
                'route' => 'glstock_company_add',
                'message' => 'glsr.gestock.settings.company.add'
            ),
            array(
                'repository' => 'GlsrGestockBundle:Settings',
                'route' => 'glstock_application_add',
                'message' => 'glsr.gestock.settings.application.add'
            ),
            array(
                'repository' => 'GlsrGestockBundle:FamilyLog',
                'route' => 'glstock_setdiv_famlog_add',
                'message' => 'glsr.gestock.settings.diverse.add_family'
            ),
            array(
                'repository' => 'GlsrGestockBundle:SubFamilyLog',
                'route' => 'glstock_setdiv_subfamlog_add',
                'message' => 'glsr.gestock.settings.diverse.add_subfam'
            ),
            array(
                'repository' => 'GlsrGestockBundle:ZoneStorage',
                'route' => 'glstock_setdiv_zonestorage_add',
                'message' => 'glsr.gestock.settings.diverse.add_zonestorage'
            ),
            array(
                'repository' => 'GlsrGestockBundle:UnitStorage',
                'route' => 'glstock_setdiv_unitstorage_add',
                'message' => 'glsr.gestock.settings.diverse.add_unitstorage'
            ),
            array('repository' => 'GlsrGestockBundle:Tva',
                'route' => 'glstock_setdiv_tva_add',
                'message' => 'glsr.gestock.settings.diverse.add_tva'
            ),
            array(
                'repository' => 'GlsrGestockBundle:Supplier',
                'route' => 'glstock_suppli_add',
                'message' => 'glsr.gestock.supplier.none'
            ),
            array(
                'repository' => 'GlsrGestockBundle:Article',
                'route' => 'glstock_art_add',
                'message' => 'glsr.gestock.article.none'
            ),
            array(
                'repository' => 'GlsrGestockBundle:Settings',
                'route' => 'glstock_inventory_prepare',
                'message' => 'glsr.gestock.settings.application.first_inventory.none'
            ),
        );
        // vérifie que les Entitées ne sont pas vides
        $nbEntities = count($entities);

        for ($index = 0; $index < $nbEntities; $index++) {
            $entity = $etm->getRepository(
                $entities[$index]['repository']
            );
            $entityData = $entity->find(1);

            if (empty($entityData)) {
                $message = $entities[$index]['message'];
                $url = $entities[$index]['route'];
                break;
            } elseif ($index === 9 && $entityData->getFirstInventory() === null) {
                    $message = $entities[$index]['message'];
                    $url = $entities[$index]['route'];
            }
        }
        $this->container->get('session')->getFlashBag()->add('warning', $message);
        return $url;
    }
}
