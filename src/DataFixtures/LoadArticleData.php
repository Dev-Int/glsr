<?php
/**
 * LoadArticleData Articles data of the GLSR application..
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

use App\Entity\Settings\Article;
use App\Entity\Settings\Diverse\Material;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Load Article Data.
 *
 * @category DataFixtures
 */
class LoadArticleData extends Fixture implements DependentFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $datas = $this->getDatas();
        foreach ($datas as $key => $data) {
            $article = new Article();
            $article->setName($data['name'])
                ->setSupplier($data['supplier'])
                ->setFamilyLog($data['familyLog'])
                ->addZoneStorage($data['zoneStorage'])
                ->setUnitStorage($data['unitStorage'])
                ->setUnitWorking($data['unitWorking'])
                ->setPrice($data['price'])
                ->setPackaging($data['packaging'])
                ->setTva($data['tva'])
                ->setMinStock($data['minStock']);

            $manager->persist($article);
            $order = $key + 1;
            $this->addReference('article'.$order, $article);

            $material = new Material();
            $material->setName($data['name'])
                ->setUnitWorking($data['unitWorking'])
                ->addArticle($this->getReference('article'.$order))
                ->setActive(1);

            $manager->persist($material);
            $this->addReference('material'.$order, $material);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LoadDiverseData::class,
            LoadSupplierData::class,
        ];
    }

    /**
     * Return float random.
     *
     * @param int $min
     * @param int $max
     * @param int $decimals
     */
    protected function getRandFloat(int $min, int $max, int $decimals): float
    {
        $divisor = \pow(10, $decimals);

        return \mt_rand($min, $max * $divisor) / $divisor;
    }

    /**
     * Get the array fixture's datas
     */
    protected function getDatas(): array
    {
        /**
         * Supplier references
         */
        $davigel = $this->getReference('supplier1');
        $davifrais = $this->getReference('supplier2');
        $davisec = $this->getReference('supplier3');
        $loireBoissons = $this->getReference('supplier4');

        /**
         * Categories references
         */
        $frais = $this->getReference('family-log4');
        $sec = $this->getReference('family-log5');
        $viandeSurgele = $this->getReference('family-log9');
        $fruitLegumesFrais = $this->getReference('family-log10');
        $vins = $this->getReference('family-log16');

        /**
         * Storage area references
         */
        $zoneSurgele = $this->getReference('zoneStorage1');
        $zoneFrais = $this->getReference('zoneStorage2');
        $zoneSec = $this->getReference('zoneStorage3');
        $zoneBoisson = $this->getReference('zoneStorage4');

        /**
         * Units references
         */
        $bouteille = $this->getReference('unit2');
        $kilogramme = $this->getReference('unit5');
        $piece = $this->getReference('unit7');

        /**
         * VAT references
         */
        $tvaReduit = $this->getReference('tva1');

        /**
         * Articles datas
         */
        $datas = [
            ['name' => 'Salade', 'supplier' => $davifrais, 'familyLog' => $fruitLegumesFrais,
            'zoneStorage' => $zoneFrais, 'unitStorage' => $piece, 'unitWorking' => $kilogramme,
            'price' => $this->getRandFloat(0, 12, 3), 'packaging' => $this->getRandFloat(5, 125, 3),
            'tva' => $tvaReduit, 'minStock' => $this->getRandFloat(3, 25, 3), ],
            ['name' => 'Bavette 150gr', 'supplier' => $davigel, 'familyLog' => $viandeSurgele,
            'zoneStorage' => $zoneSurgele, 'unitStorage' => $piece, 'unitWorking' => $piece,
            'price' => $this->getRandFloat(0, 12, 3), 'packaging' => $this->getRandFloat(5, 125, 3),
            'tva' => $tvaReduit, 'minStock' => $this->getRandFloat(3, 25, 3), ],
            ['name' => 'Baguettine', 'supplier' => $davigel, 'familyLog' => $viandeSurgele,
            'zoneStorage' => $zoneSurgele, 'unitStorage' => $piece, 'unitWorking' => $piece,
            'price' => $this->getRandFloat(0, 12, 3), 'packaging' => $this->getRandFloat(5, 125, 3),
            'tva' => $tvaReduit, 'minStock' => $this->getRandFloat(3, 25, 3), ],
            ['name' => 'Steack haché 20%MG 120g', 'supplier' => $davigel, 'familyLog' => $viandeSurgele,
            'zoneStorage' => $zoneSurgele, 'unitStorage' => $piece, 'unitWorking' => $piece,
            'price' => $this->getRandFloat(0, 12, 3), 'packaging' => $this->getRandFloat(5, 125, 3),
            'tva' => $tvaReduit, 'minStock' => $this->getRandFloat(3, 25, 3), ],
            ['name' => 'Ananas poche 2.3 KG', 'supplier' => $davisec, 'familyLog' => $sec,
            'zoneStorage' => $zoneSec, 'unitStorage' => $piece, 'unitWorking' => $kilogramme,
            'price' => $this->getRandFloat(0, 12, 3), 'packaging' => $this->getRandFloat(5, 125, 3),
            'tva' => $tvaReduit, 'minStock' => $this->getRandFloat(3, 25, 3), ],
            ['name' => 'Appareil Champigons 2 KG', 'supplier' => $davifrais, 'familyLog' => $frais,
            'zoneStorage' => $zoneFrais, 'unitStorage' => $piece, 'unitWorking' => $kilogramme,
            'price' => $this->getRandFloat(0, 12, 3), 'packaging' => $this->getRandFloat(5, 125, 3),
            'tva' => $tvaReduit, 'minStock' => $this->getRandFloat(3, 25, 3), ],
            ['name' => 'Bacon tranche Barq 88G', 'supplier' => $davifrais, 'familyLog' => $frais,
            'zoneStorage' => $zoneFrais, 'unitStorage' => $piece, 'unitWorking' => $kilogramme,
            'price' => $this->getRandFloat(0, 12, 3), 'packaging' => $this->getRandFloat(5, 125, 3),
            'tva' => $tvaReduit, 'minStock' => $this->getRandFloat(3, 25, 3), ],
            ['name' => 'Beurre doux 8Gx125', 'supplier' => $davifrais, 'familyLog' => $frais,
            'zoneStorage' => $zoneFrais, 'unitStorage' => $kilogramme, 'unitWorking' => $piece,
            'price' => $this->getRandFloat(0, 12, 3), 'packaging' => $this->getRandFloat(5, 125, 3),
            'tva' => $tvaReduit, 'minStock' => $this->getRandFloat(3, 25, 3), ],
            ['name' => 'Boule pour oeuf neige', 'supplier' => $davifrais, 'familyLog' => $frais,
            'zoneStorage' => $zoneFrais, 'unitStorage' => $piece, 'unitWorking' => $piece,
            'price' => $this->getRandFloat(0, 12, 3), 'packaging' => $this->getRandFloat(5, 125, 3),
            'tva' => $tvaReduit, 'minStock' => $this->getRandFloat(3, 25, 3), ],
            ['name' => 'Champignons émincé 500G', 'supplier' => $davifrais, 'familyLog' => $fruitLegumesFrais,
            'zoneStorage' => $zoneFrais, 'unitStorage' => $kilogramme, 'unitWorking' => $kilogramme,
            'price' => $this->getRandFloat(0, 12, 3), 'packaging' => $this->getRandFloat(5, 125, 3),
            'tva' => $tvaReduit, 'minStock' => $this->getRandFloat(3, 25, 3), ],
            ['name' => 'Chorizo prétr. 500G', 'supplier' => $davifrais, 'familyLog' => $fruitLegumesFrais,
            'zoneStorage' => $zoneFrais, 'unitStorage' => $kilogramme, 'unitWorking' => $kilogramme,
            'price' => $this->getRandFloat(0, 12, 3), 'packaging' => $this->getRandFloat(5, 125, 3),
            'tva' => $tvaReduit, 'minStock' => $this->getRandFloat(3, 25, 3), ],
            ['name' => 'V.RG Bourgueil 75cl', 'supplier' => $loireBoissons, 'familyLog' => $vins,
            'zoneStorage' => $zoneBoisson, 'unitStorage' => $bouteille, 'unitWorking' => $bouteille,
            'price' => 5.11, 'packaging' => $this->getRandFloat(5, 125, 3),
            'tva' => $tvaReduit, 'minStock' => $this->getRandFloat(3, 25, 3), ],
        ];

        return $datas;
    }
}
