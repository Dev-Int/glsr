<?php
/**
 * LoadAppData Données de l'application GLSR.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <lq@dev-int.net>
 * @copyright 2018 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: $Id$
 *
 * @see https://github.com/Dev-Int/glsr
 */

namespace App\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Settings\Company;
use App\Entity\Settings\Settings;

/**
 * LoadApp Data.
 *
 * @category DataFixtures
 */
class LoadAppData extends AbstractFixture implements OrderedFixtureInterface
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
            ->setMail('info@dev-int.net')
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

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
