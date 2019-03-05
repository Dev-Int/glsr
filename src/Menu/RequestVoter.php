<?php
/**
 * RequestVoter KnpMenu.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link https://github.com/Dev-Int/glsr
 */
namespace App\Menu;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * class RequestVoter.
 *
 * @category Menu
 */
class RequestVoter implements VoterInterface
{
    private $requestStack;
    
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
 
    public function matchItem(ItemInterface $item)
    {
        $request = $this->requestStack->getCurrentRequest();
 
        if ($item->getUri() === $request->getRequestUri()) {
            // URL's completely match
            return true;
        } elseif ($item->getUri() !== $request->getBaseUrl() . '/' &&
            substr($request->getRequestUri(), 0, strlen($item->getUri()))
            === $item->getUri()) {
            // URL isn't just "/" and the first part of the URL match
            return true;
        }
 
        return null;
    }
}
