<?php

/**
 * GlsrUserBundle.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    0.1.0
 *
 * @link       https://github.com/Dev-Int/glsr
 */
namespace Glsr\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * GlsrUserBundle.
 *
 * @category   Bundle
 */
class GlsrUserBundle extends Bundle
{
    /**
     * Renvoie le bundle dont dépend GlsrUserBundle.
     *
     * @return string Parent bundle
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
