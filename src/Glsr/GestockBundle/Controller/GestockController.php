<?php
// src/Glsr/GestockBundle/Controller/GestockController.php

namespace Glsr\GestockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class GestockController extends Controller
{
    public function indexAction()
    {
        return $this->render('GlsrGestockBundle:Gestock:index.html.twig');
    }

    /**
     * Récupère les subFamilyLog de la FamilyLog sélectionnée
     * 
     * @return \Glsr\GestockBundle\Controller\Response
     */
    public function fill_subFamilyLogAction()
    {
        $request = $this->getRequest();
        $etm = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $id = '';
            $id = $request->get('id');
            if ($id !='') {
                $subFamilyLogs = $etm->getRepository('GlsrGestockBundle:subFamilyLog')->getFromFamilyLog($id);
                $tabSubFamilyLog  = array();
                $tabSubFamilyLog[0]['idOption'] = '';
                $tabSubFamilyLog[0]['nameOption'] = 'Choice the Sub Family';
                $i = 1;
                foreach ($subFamilyLogs as $subFamilyLog) {
                    $tabSubFamilyLog[$i]['idOption'] = $subFamilyLog->getId();
                    $tabSubFamilyLog[$i]['nameOption'] = $subFamilyLog->getName();
                    $i++;
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
    
    public function getFamilyLogAction()
    {
        $request = $this->getRequest();
        $etm = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $id = '';
            $id = $request->get('id');
            if ($id !='') {
                $supplier = $etm->getRepository('GlsrGestockBundle:Supplier')->find($id);

                $familyLog['familylog'] = $supplier->getFamilyLog()->getId();
                if (NULL !== $supplier->getSubFamilyLog()) {
                    $familyLog['subfamilylog'] = $supplier->getSubFamilyLog()->getId();
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

    public function alertsAction($nombre)
    {
//        $liste = $this->getDoctrine()
//                      ->getManager()
//                      ->getRepository('SdzBlogBundle:Article')
//                      ->findBy(
//                        array(),          // Pas de critère
//                        array('date' => 'desc'), // On trie par date décroissante
//                        $nombre,         // On sélectionne $nombre articles
//                        0                // À partir du premier
//                      );
        $alerts = array(
            array(
                'titre' => 'Cmde',
                'num'   => '002'
            ),
            array(
                'titre' => 'Cmde',
                'num'   => '0003'
            ),
            array(
                'titre' => 'Liv',
                'num'   => '0001'
            )
        );
        return $this->render('GlsrGestockBundle:Gestock:alerts.html.twig', array(
          'list_alerts' => $alerts // C'est ici tout l'intérêt : le contrôleur passe les variables nécessaires au template !
        ));
    }
}
