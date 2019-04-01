<?php
/**
 * LoadDiverseData Données de configuration de l'application GLSR.
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
use App\Entity\Settings\Diverse\FamilyLog;
use App\Entity\Settings\Diverse\ZoneStorage;
use App\Entity\Settings\Diverse\Unit;
use App\Entity\Settings\Diverse\Tva;

/**
 * LoadDiverse Data.
 *
 * @category DataFixtures
 */
class LoadDiverseData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Load FamilyLog
        $familyArray = [
            ['name' => 'Alimentaire'],
            ['name' => 'Non alimentaire'],
            ['name' => 'Surgelé', 'parent' => 1],
            ['name' => 'Frais', 'parent' => 1],
            ['name' => 'Sec', 'parent' => 1],
            ['name' => 'Boissons', 'parent' => 1],
            ['name' => 'Fruits&Légumes', 'parent' => 3],
            ['name' => 'Patisseries', 'parent' => 3],
            ['name' => 'Viandes', 'parent' => 3],
            ['name' => 'Fruits&Légumes', 'parent' => 4],
            ['name' => 'Patisseries', 'parent' => 4],
            ['name' => 'Viandes', 'parent' => 4],
            ['name' => 'Fruits&Légumes', 'parent' => 5],
            ['name' => 'Patisseries', 'parent' => 5],
            ['name' => 'Bières', 'parent' => 6],
            ['name' => 'Vins', 'parent' => 6],
        ];
        foreach ($familyArray as $key => $family) {
            $familyLog = new FamilyLog();
            $familyLog->setName($family['name']);
            if (isset($family['parent'])) {
                $parent = $familyLogs[$family['parent'] - 1];
                $familyLog->setParent($parent);
            }
            $familyLogs[$key] = $familyLog;

            $manager->persist($familyLog);

            $order = $key + 1;
            $this->addReference('family-log'.$order, $familyLog);
        }

        // Load ZoneStorage
        $zoneArray = [
            ['name' => 'Chambre négative'],
            ['name' => 'Chambre posistive'],
            ['name' => 'Réserve sèche'],
            ['name' => 'Réserve boissons'],
            ['name' => 'Armoire à boissons'],
            ['name' => 'Caisse'],
        ];
        foreach ($zoneArray as $key => $zone) {
            $zoneStorage = new ZoneStorage();
            $zoneStorage->setName($zone['name']);

            $manager->persist($zoneStorage);

            $order = $key + 1;
            $this->addReference('zoneStorage'.$order, $zoneStorage);
        }

        // Load Unit
        $unitArray = [
            ['name' => 'Boite', 'abbr' => 'BOI'],
            ['name' => 'Bouteille', 'abbr' => 'BTE'],
            ['name' => 'Carton', 'abbr' => 'CAR'],
            ['name' => 'Colis', 'abbr' => 'CLS'],
            ['name' => 'Kilogramme', 'abbr' => 'KG'],
            ['name' => 'Litre', 'abbr' => 'L'],
            ['name' => 'Pièce', 'abbr' => 'PIE'],
        ];
        foreach ($unitArray as $key => $unit) {
            $unitStorage = new Unit();
            $unitStorage->setName($unit['name'])
                ->setAbbr($unit['abbr']);

            $manager->persist($unitStorage);

            $order = $key + 1;
            $this->addReference('unit'.$order, $unitStorage);
        }

        // Load Tva
        $tvaArray = [
            ['rate' => '0.055'],
            ['rate' => '0.1'],
            ['rate' => '0.2'],
        ];
        foreach ($tvaArray as $key => $tvaRate) {
            $tva = new Tva();
            $tva->setRate($tvaRate['rate']);

            $manager->persist($tva);

            $order = $key + 1;
            $this->addReference('tva'.$order, $tva);
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 4;
    }
}
