<?php
/**
 * LoadArticleData Données de l'application GLSR.
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
use App\Entity\Settings\Article;
use App\Entity\Settings\Diverse\Material;
use App\DataFixtures\LoadDiverseData;
use App\DataFixtures\LoadSupplierData;

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

    public function getDependencies()
    {
        return [
            LoadDiverseData::class,
            LoadSupplierData::class,
        ];
    }

    /**
     * Return float random.
     *
     * @param integer $min
     * @param integer $max
     */
     protected function rnd_fl(int $min = 0, int $max = null): float
    {
        return (float)rand($min, $max) / (float)getrandmax();
    }

    /**
     * Get the fixture's datas
     *
     * @return void
     */
    protected function getDatas()
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
            ['name' => 'Salade', 'supplier' => $davifrais,
            'familyLog' => $fruitLegumesFrais, 'zoneStorage' => $zoneFrais,
            'unitStorage' => $piece, 'unitWorking' => $kilogramme, 'price' => 2.99,
            'packaging' => 12.0, 'tva' => $tvaReduit, 'minStock' => 2.0, ],
            ['name' => 'Bavette 150gr', 'supplier' => $davigel,
            'familyLog' => $viandeSurgele, 'zoneStorage' => $zoneSurgele,
            'unitStorage' => $piece, 'unitWorking' => $piece, 'price' => 2.99,
            'packaging' => 28, 'tva' => $tvaReduit, 'minStock' => 2.0, ],
            ['name' => 'Baguettine', 'supplier' => $davigel,
            'familyLog' => $viandeSurgele, 'zoneStorage' => $zoneSurgele,
            'unitStorage' => $piece, 'unitWorking' => $piece, 'price' => 15.2,
            'packaging' => 90.0, 'tva' => $tvaReduit, 'minStock' => 20.0, ],
            ['name' => 'Steack haché 20%MG 120g', 'supplier' => $davigel,
            'familyLog' => $viandeSurgele, 'zoneStorage' => $zoneSurgele,
            'unitStorage' => $piece, 'unitWorking' => $piece, 'price' => 1.22,
            'packaging' => 50.0, 'tva' => $tvaReduit, 'minStock' => 12.0, ],
            ['name' => 'Ananas poche 2.3 KG', 'supplier' => $davisec,
            'familyLog' => $sec, 'zoneStorage' => $zoneSec,
            'unitStorage' => $piece, 'unitWorking' => $kilogramme, 'price' => 4.05,
            'packaging' => 4, 'tva' => $tvaReduit, 'minStock' => 3.0, ],
            ['name' => 'Appareil Champigons 2 KG', 'supplier' => $davifrais,
            'familyLog' => $frais, 'zoneStorage' => $zoneFrais,
            'unitStorage' => $piece, 'unitWorking' => $kilogramme, 'price' => 6.39,
            'packaging' => 4.0, 'tva' => $tvaReduit, 'minStock' => 2.0, ],
            ['name' => 'Bacon tranche Barq 88G', 'supplier' => $davifrais,
            'familyLog' => $frais, 'zoneStorage' => $zoneFrais,
            'unitStorage' => $piece, 'unitWorking' => $kilogramme, 'price' => 0.75,
            'packaging' => 6.0, 'tva' => $tvaReduit, 'minStock' => 2, ],
            ['name' => 'Beurre doux 8Gx125', 'supplier' => $davifrais,
            'familyLog' => $frais, 'zoneStorage' => $zoneFrais,
            'unitStorage' => $kilogramme, 'unitWorking' => $piece, 'price' => 6.83,
            'packaging' => 1.0, 'tva' => $tvaReduit, 'minStock' => 0.5, ],
            ['name' => 'Boule pour oeuf neige', 'supplier' => $davifrais,
            'familyLog' => $frais, 'zoneStorage' => $zoneFrais,
            'unitStorage' => $piece, 'unitWorking' => $piece, 'price' => 1.75,
            'packaging' => 6.0, 'tva' => $tvaReduit, 'minStock' => 2.0, ],
            ['name' => 'Champignons émincé 500G', 'supplier' => $davifrais,
            'familyLog' => $fruitLegumesFrais, 'zoneStorage' => $zoneFrais,
            'unitStorage' => $kilogramme, 'unitWorking' => $kilogramme,
            'price' => 3.17, 'packaging' => 3.5, 'tva' => $tvaReduit,
            'minStock' => 1.0, ],
            ['name' => 'Chorizo prétr. 500G', 'supplier' => $davifrais,
            'familyLog' => $fruitLegumesFrais, 'zoneStorage' => $zoneFrais,
            'unitStorage' => $kilogramme, 'unitWorking' => $kilogramme,
            'price' => 5.11, 'packaging' => 6, 'tva' => $tvaReduit, 'minStock' => 1.0, ],
            ['name' => 'V.RG Bourgueil 75cl', 'supplier' => $loireBoissons,
            'familyLog' => $vins, 'zoneStorage' => $zoneBoisson,
            'unitStorage' => $bouteille, 'unitWorking' => $bouteille,
            'price' => 5.11, 'packaging' => 6.0, 'tva' => $tvaReduit, 'minStock' => 3.0, ],
        ];

        return $datas;
    }
}
