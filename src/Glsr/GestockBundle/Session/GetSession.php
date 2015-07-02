<?php

namespace Glsr\GestockBundle\Session;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Factorisation des messages FlashBag.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2015 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    GIT: a4408b1f9fc87a1f93911d80e8421fef1bd96cab
 *
 * @link       https://github.com/GLSR/glsr
 */
class GetSession
{
    /**
     * @var \ContainerInterface Container of Request
     */
    private $_container;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->_container = $container;
    }
    
    /**
     * Renvoi de messages FlashBag.
     *
     * @param string $flag Type de message
     * @param string $message Message à afficher
     */
    static public function getFlashBag($flag, $message)
    {
        // On définit un message flash
        $this->_container
            ->get('session')
            ->getFlashBag()
            ->add(
                $flag,
                $message
            );
    }

}
