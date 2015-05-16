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

/**
 * class GestockController.
 *
 * @category Controller
 */
class GestockController extends Controller
{
    /**
     * Affiche la page d'accueil du Bundle.
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('GlsrGestockBundle:Gestock:index.html.twig');
    }

    /**
     * Récupère les subFamilyLog de la FamilyLog sélectionnée.
     *
     * @return Response
     */
    public function fillSubFamilyLogAction()
    {
        $request = $this->getRequest();
        $etm = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $famLogId = $request->get('id');
            $subFamId = $request->get('id2');
            if ($famLogId != '') {
                $subFamilyLogs = $etm
                    ->getRepository('GlsrGestockBundle:subFamilyLog')
                    ->getFromFamilyLog($famLogId);
                $familyLog     = $etm
                    ->getRepository('GlsrGestockBundle:familyLog')
                    ->find($famLogId);
                $tabSubFamilyLog  = array();
                $tabSubFamilyLog[0]['idOption'] = '';
                $tabSubFamilyLog[0]['nameOption']
                    = 'Choice the Sub Family: '.$familyLog->getName();
                $iterator = 1;
                foreach ($subFamilyLogs as $subFamilyLog) {
                    $tabSubFamilyLog[$iterator]['idOption'] =
                        $subFamilyLog->getId();
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
     * @return Response
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

                return $response;
            }
        }

        return new Response('Error');
    }

    /**
     * Récupère les Alertes.
     *
     * @param int $nombre nombres d'alertes à afficher
     *
     * @return Response
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
            array(
                'titre' => 'Cmde',
                'num'   => '002',
            ),
            array(
                'titre' => 'Cmde',
                'num'   => '0003',
            ),
            array(
                'titre' => 'Liv',
                'num'   => '0001',
            ),
        );

        return $this->render(
            'GlsrGestockBundle:Gestock:alerts.html.twig',
            array(
                // C'est ici tout l'intérêt :
                // le contrôleur passe les variables nécessaires au template !
                'list_alerts' => $alerts,
                'nb' => $nombre,
            )
        );
    }
}
