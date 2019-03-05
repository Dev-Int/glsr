<?php
/**
 * LoadSupplierData Datas of the suppliers of the GLSR application.
 *
 * PHP Version 7
 *
 * @author    Quétier Laurent <info@developpement-interessant.com>
 * @copyright 2014 Dev-Int GLSR
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version GIT: <git_id>
 *
 * @see https://github.com/Dev-Int/glsr
 */

namespace App\DataFixtures;

use App\Entity\Settings\Supplier;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

/**
 * Load Supplier Data.
 *
 * @category DataFixtures
 */
class LoadSupplierData extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Serialization of phone numbers
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        // References of logistics families
        $surgele = $this->getReference('family-log3');
        $frais = $this->getReference('family-log4');
        $sec = $this->getReference('family-log5');
        $boissons = $this->getReference('family-log6');

        // Datas of suppliers
        $datas = [
            ['name' => 'Davigel', 'address' => '12, rue du gel', 'zipCode' => 75001,
            'town' => 'Paris', 'phone' => $phoneUtil->parse('0140000001', 'FR'),
            'fax' => $phoneUtil->parse('0140000001', 'FR'),
            'mail' => 'info@davigel.fr', 'contact' => 'David Gel',
            'gsm' => $phoneUtil->parse('0160000001', 'FR'), 'family' => $surgele,
            'delayDeliv' => 2, 'orderDate' => [2, 5], ],
            ['name' => 'Davifrais', 'address' => '12, rue du frais',
            'zipCode' => 75001, 'town' => 'Paris',
            'phone' => $phoneUtil->parse('0140000002', 'FR'),
            'fax' => $phoneUtil->parse('0140000002', 'FR'),
            'mail' => 'info@davifris.fr', 'contact' => 'David Frais',
            'gsm' => $phoneUtil->parse('0160000002', 'FR'), 'family' => $frais,
            'delayDeliv' => 2, 'orderDate' => [2, 5], ],
            ['name' => 'Davisec', 'address' => '12, rue du sec', 'zipCode' => 75001,
            'town' => 'Paris', 'phone' => $phoneUtil->parse('0140000003', 'FR'),
            'fax' => $phoneUtil->parse('0140000003', 'FR'),
            'mail' => 'info@davisecl.fr', 'contact' => 'David Sec',
            'gsm' => $phoneUtil->parse('0160000003', 'FR'), 'family' => $sec,
            'delayDeliv' => 3, 'orderDate' => [3], ],
            ['name' => 'Loire Boissons', 'address' => '12, rue de la soif',
            'zipCode' => 75001, 'town' => 'Paris',
            'phone' => $phoneUtil->parse('0140000004', 'FR'),
            'fax' => $phoneUtil->parse('0140000004', 'FR'),
            'mail' => 'info@davisecl.fr', 'contact' => 'David Sec',
            'gsm' => $phoneUtil->parse('0160000004', 'FR'), 'family' => $boissons,
            'delayDeliv' => 3, 'orderDate' => [5], ],
        ];

        foreach ($datas as $key => $data) {
            $supplier = new Supplier();
            $supplier->setName($data['name'])
                ->setAddress($data['address'])
                ->setZipCode($data['zipCode'])
                ->setTown($data['town'])
                ->setPhone($data['phone'])
                ->setFax($data['fax'])
                ->setMail($data['mail'])
                ->setContact($data['contact'])
                ->setGsm($data['gsm'])
                ->setFamilyLog($data['family'])
                ->setDelaydeliv($data['delayDeliv'])
                ->setOrderdate($data['orderDate']);

            $manager->persist($supplier);
            $order = $key + 1;
            $this->addReference('supplier'.$order, $supplier);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [LoadDiverseData::class];
    }

    public static function getGroups(): array
    {
        return ['settingsGroup'];
    }
}
