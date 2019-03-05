<?php
/**
 * LoadGroupData Datas of groups of GLSR application.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @see      https://github.com/Dev-Int/glsr
 */

namespace App\DataFixtures;

use App\Entity\Staff\Group;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

/**
 * LoadGroup Data.
 *
 * @category DataFixtures
 */
class LoadGroupData extends Fixture implements FixtureGroupInterface
{
    /**
     * Datas groups.
     *
     * @var array
     */
    private $datas = [
        ['admin', 'ROLE_SUPER_ADMIN'],
        ['assistant', 'ROLE_ADMIN'],
        ['user', 'ROLE_USER'],
    ];

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->datas as $data) {
            $groupAdmin = new Group($data[0], [$data[1]]);
            $groupAdmin->setName($data[0]);
            $groupAdmin->setRoles([$data[1]]);

            $manager->persist($groupAdmin);
            $this->addReference('group-'.$data[0], $groupAdmin);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['userGroup'];
    }
}
