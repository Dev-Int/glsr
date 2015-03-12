<?php

/**
 * SecurityController
 * 
 * PHP Version 5
 * 
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version   GIT: c2884c506d2a8a3a2f8905b6aebd161be961048e
 * @link      https://github.com/GLSR/glsr
 */

namespace Glsr\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;

/**
 * SecurityController
 * 
 * @category Controller
 * @package  User
 */
class SecurityController extends BaseController
{
    /**
     * Renders the login template with the given parameters. 
     * Overwrite this function in an extended controller to provide 
     * additional data for the login template.
     *
     * @param array $data Data's connexion
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderLogin(array $data)
    {
        // Sur la page du formulaire de connexion,
        // on utilise la vue classique "login"
        // Cette vue hérite du layout et ne peut donc être
        // utilisée qu'individuellement
        $route = $this->container->get('request')->attributes->get('_route');
        if ($route =='fos_user_security_login') {
            $view = 'login';
        } else {
            // Mais sinon, il s'agit du formulaire de connexion intégré au menu,
            // on utilise la vue "login_content" car il ne faut pas
            // hériter du layout !
            $view = 'login_content';
        }

        $template = sprintf(
            'FOSUserBundle:Security:%s.html.twig',
            $view
        );

        return $this->container
            ->get('templating')
            ->renderResponse($template, $data);
    }
}
