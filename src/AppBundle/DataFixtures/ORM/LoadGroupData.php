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
    private $datas = [
        ['admin', 'ROLE_SUPER_ADMIN'],
        ['assistant','ROLE_ADMIN'],
        ['user', 'ROLE_USER']
    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->datas as $key => $data) {
            $groupAdmin = new Group($data[0], [$data[1]]);
            $groupAdmin->setName($data[0]);
            $groupAdmin->setRoles([$data[1]]);

            $manager->persist($groupAdmin);
            $order = $key + 1;
            $this->addReference('admin-group'.$order, $groupAdmin);
        }
        $manager->flush();

    }

    public function getOrder()
    {
        return 1;
    }
}
