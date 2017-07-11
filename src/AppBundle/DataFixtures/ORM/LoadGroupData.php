<?php
/**
 * LoadGroupData Données Group de l'application GLSR.
 *
 * PHP Version 5
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @link      https://github.com/Dev-Int/glsr
 */
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Staff\Group;

/**
 * LoadGroup Data.
 *
 * @category DataFixtures
 */
class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $groupAdmin = new Group();
        $groupAdmin->setName('admin');
        $groupAdmin->setRoles(['ROLE_SUPER_ADMIN']);

        $manager->persist($groupAdmin);
        $manager->flush();

        $this->addReference('admin-group', $groupAdmin);
    }

    public function getOrder()
    {
        return 1;
    }
}
