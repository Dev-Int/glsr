<?php

namespace Glsr\GestockBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GlsrRequestListener
{
    private $etm;
    private $container;
    protected $router;
    protected $redirect = null;
    private $routes = array();


    public function __construct(EntityManager $etm, ContainerInterface $container, Router $router, $routes = array())
    {
        $this->etm       = $etm;
        $this->container = $container;
        $this->router    = $router;
        $routes = array(
            'glstock_company_add',
            'glstock_settings_add',
            'glstock_setdiv_famlog_add',
            'glstock_setdiv_subfamlog_add',
            'glstock_setdiv_zonestorage_add',
            'glstock_setdiv_unitstorage_add',
            'glstock_setdiv_tva_add',
            'glstock_suppli_add',
            'glstock_art_add'
        );
        $this->routes = $routes;
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        // Si la route en cours est celle que l'on veut attribuer, 
        // on sort de la fonction
        if (in_array($event->getRequest()->attributes->get('_route'), $this->routes)) {
            return;
        }
        
        // Tableau des entitées
        $entities = array(
            array('repository' => 'GlsrGestockBundle:Company',      'route' => $this->routes[0]),
            array('repository' => 'GlsrGestockBundle:Settings',     'route' => $this->routes[1]),
            array('repository' => 'GlsrGestockBundle:FamilyLog',    'route' => $this->routes[2]),
            array('repository' => 'GlsrGestockBundle:SubFamilyLog', 'route' => $this->routes[3]),
            array('repository' => 'GlsrGestockBundle:ZoneStorage',  'route' => $this->routes[4]),
            array('repository' => 'GlsrGestockBundle:UnitStorage',  'route' => $this->routes[5]),
            array('repository' => 'GlsrGestockBundle:Tva',          'route' => $this->routes[6]),
            array('repository' => 'GlsrGestockBundle:Supplier',     'route' => $this->routes[7]),
            array('repository' => 'GlsrGestockBundle:Article',      'route' => $this->routes[8])
        );
        // vérifie que les Entitées ne sont pas vides
        $message = "Il faut renseigner les informations manquantes";
        
        for ($index = 0; $index < count($entities); $index++) {
            $entity = $this->etm->getRepository($entities[$index]['repository']);
            $entityData = $entity->findAll();
            
            if(empty($entityData)) {
                $this->container->get('session')->getFlashBag()->add('info', $message);
                $this->redirect = $entities[$index]['route'];
                $index += count($entities);
            }
        }
    }
    
    public function onKernelResponse(FilterResponseEvent $event)
    {
        // On redirige vers la page d'ajout d'information de la société
        if (NULL !== $this->redirect) {
            $url = $this->router->generate($this->redirect);
            $event->setResponse(new RedirectResponse($url));
        }        
    }
}
