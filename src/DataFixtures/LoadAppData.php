<?php
/**
 * LoadAppData GLSR application datas.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @see https://github.com/Dev-Int/glsr
 */

namespace App\DataFixtures;

use App\Entity\Settings\Company;
use App\Entity\Settings\Settings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * LoadApp Data.
 *
 * @category DataFixtures
 */
class LoadAppData extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

        // Load Company
        $app = new Company();
        $app->setName('Dev-Int')
            ->setStatus('S.A.R.L.')
            ->setAddress('2, rue de la chèvre')
            ->setZipCode('75000')
            ->setTown('Paris')
            ->setPhone($phoneUtil->parse('0140000000', 'FR'))
            ->setFax($phoneUtil->parse('0140000000', 'FR'))
            ->setEmail('info@dev-int.net')
            ->setContact('Ursule')
            ->setGsm($phoneUtil->parse('0640000000', 'FR'));

        $manager->persist($app);

        // Load Settings
        $settings = new Settings();
        $settings->setInventoryStyle('zonestorage')
            ->setCalculation('weighted')
            ->setCurrency('EUR');

        $manager->persist($settings);

        $manager->flush();
    }
}
