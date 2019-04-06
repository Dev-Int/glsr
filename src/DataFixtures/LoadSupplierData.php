<?php
/**
 * LoadSupplierData Données de l'application GLSR.
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

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Settings\Supplier;
use App\DataFixtures\LoadDiverseData;

/**
 * Load Supplier Data.
 *
 * @category DataFixtures
 */
class LoadSupplierData extends Fixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        /**
         * Serialization of phone numbers
         */
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

        /**
         * Categories references
         */
        $surgele = $this->getReference('family-log3');
        $frais = $this->getReference('family-log4');
        $sec = $this->getReference('family-log5');
        $boissons = $this->getReference('family-log6');

        /**
         * Suppliers datas
         */
        $datas = [
            ['name' => 'Davigel', 'address' => '12, rue du gel', 'zipCode' => 75001,
            'town' => strtoupper('Paris'), 'phone' => $phoneUtil->parse('0140000001', 'FR'),
            'fax' => $phoneUtil->parse('0140000001', 'FR'),
            'mail' => 'info@davigel.fr', 'contact' => 'David Gel',
            'gsm' => $phoneUtil->parse('0160000001', 'FR'), 'family' => $surgele,
            'delayDeliv' => 2, 'orderDate' => [2, 5], ],
            ['name' => 'Davifrais', 'address' => '12, rue du frais',
            'zipCode' => 75001, 'town' => strtoupper('Paris'),
            'phone' => $phoneUtil->parse('0140000002', 'FR'),
            'fax' => $phoneUtil->parse('0140000002', 'FR'),
            'mail' => 'info@davifrais.fr', 'contact' => 'David Frais',
            'gsm' => $phoneUtil->parse('0160000002', 'FR'), 'family' => $frais,
            'delayDeliv' => 2, 'orderDate' => [2, 5], ],
            ['name' => 'Davisec', 'address' => '12, rue du sec', 'zipCode' => 75001,
            'town' => strtoupper('Paris'), 'phone' => $phoneUtil->parse('0140000003', 'FR'),
            'fax' => $phoneUtil->parse('0140000003', 'FR'),
            'mail' => 'info@davisec.fr', 'contact' => 'David Sec',
            'gsm' => $phoneUtil->parse('0160000003', 'FR'), 'family' => $sec,
            'delayDeliv' => 3, 'orderDate' => [3], ],
            ['name' => 'Loire Boissons', 'address' => '12, rue de la soif',
            'zipCode' => 75001, 'town' => strtoupper('Paris'),
            'phone' => $phoneUtil->parse('0140000004', 'FR'),
            'fax' => $phoneUtil->parse('0140000004', 'FR'),
            'mail' => 'info@loire-boissons.fr', 'contact' => 'Laurence Boisset',
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
                ->setEMail($data['mail'])
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
}
