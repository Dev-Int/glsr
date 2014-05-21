<?php
// src/Glsr/GestockBundle/Controller/GestockController.php

namespace Glsr\GestockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class GestockController extends Controller
{
    public function indexAction()
    {
        return $this->render('GlsrGestockBundle:Gestock:index.html.twig');
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
