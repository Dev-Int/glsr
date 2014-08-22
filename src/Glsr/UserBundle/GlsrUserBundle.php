<?php

/**
 * GlsrUserBundle
 * 
 * PHP Version 5
 * 
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version    GIT: 2d028e49620749c91f41f3837f4255a2cf8c98bd
 * @link       https://github.com/GLSR/glsr
 */

namespace Glsr\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * GlsrUserBundle
 * 
 * @category   Bundle
 * @package    User
 */
class GlsrUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
