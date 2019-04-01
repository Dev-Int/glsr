<?php
/**
 * LoadArticleData Données de l'application GLSR.
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
use App\Entity\Settings\Article;
use App\Entity\Settings\Diverse\Material;

/**
 * Load Article Data.
 *
 * @category DataFixtures
 */
class LoadArticleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Références des fournisseurs
        $davigel = $this->getReference('supplier1');
        $davifrais = $this->getReference('supplier2');
        $davisec = $this->getReference('supplier3');
        $loireBoissons = $this->getReference('supplier4');
        // Références des catégories
        $surgele = $this->getReference('family-log3');
        $frais = $this->getReference('family-log4');
        $sec = $this->getReference('family-log5');
        $boissons = $this->getReference('family-log6');
        $fruitLegumesSurgele = $this->getReference('family-log7');
        $patisseriesSurgele = $this->getReference('family-log8');
        $viandeSurgele = $this->getReference('family-log9');
        $fruitLegumesFrais = $this->getReference('family-log10');
        $patisseriesFrais = $this->getReference('family-log11');
        $viandeFrais = $this->getReference('family-log12');
        $fruitLegumesSec = $this->getReference('family-log13');
        $patisseriesSec = $this->getReference('family-log14');
        $bieres = $this->getReference('family-log15');
        $vins = $this->getReference('family-log16');
        // Références des zones de stockage
        $zoneSurgele = $this->getReference('zoneStorage1');
        $zoneFrais = $this->getReference('zoneStorage2');
        $zoneSec = $this->getReference('zoneStorage3');
        $zoneBoisson = $this->getReference('zoneStorage4');
        // Références des unités
        $boite = $this->getReference('unit1');
        $bouteille = $this->getReference('unit2');
        $carton = $this->getReference('unit3');
        $colis = $this->getReference('unit4');
        $kilogramme = $this->getReference('unit5');
        $litre = $this->getReference('unit6');
        $piece = $this->getReference('unit7');
        // Références des TVA
        $tvaReduit = $this->getReference('tva1');
        $tvaMoyen = $this->getReference('tva2');
        $tvaLuxe = $this->getReference('tva3');
        // Datas des articles
        $datas = [
            ['name' => 'Salade', 'supplier' => $davifrais,
            'familyLog' => $fruitLegumesFrais, 'zoneStorage' => $zoneFrais,
            'articleUnit.unitStorage' => $piece, 'unitWorking' => $kilogramme, 'price' => 2.99,
            'articleUnit.packaging' => 12, 'tva' => $tvaReduit, 'minStock' => 2, ],
            ['name' => 'Bavette 150gr', 'supplier' => $davigel,
            'familyLog' => $viandeSurgele, 'zoneStorage' => $zoneSurgele,
            'articleUnit.unitStorage' => $piece, 'unitWorking' => $piece, 'price' => 2.99,
            'articleUnit.packaging' => 28, 'tva' => $tvaReduit, 'minStock' => 2, ],
            ['name' => 'Baguettine', 'supplier' => $davigel,
            'familyLog' => $viandeSurgele, 'zoneStorage' => $zoneSurgele,
            'articleUnit.unitStorage' => $piece, 'unitWorking' => $piece, 'price' => 15.2,
            'articleUnit.packaging' => 90, 'tva' => $tvaReduit, 'minStock' => 20, ],
            ['name' => 'Steack haché 20%MG 120g', 'supplier' => $davigel,
            'familyLog' => $viandeSurgele, 'zoneStorage' => $zoneSurgele,
            'articleUnit.unitStorage' => $piece, 'unitWorking' => $piece, 'price' => 1.22,
            'articleUnit.packaging' => 50, 'tva' => $tvaReduit, 'minStock' => 12, ],
            ['name' => 'Ananas poche 2.3 KG', 'supplier' => $davisec,
            'familyLog' => $sec, 'zoneStorage' => $zoneSec,
            'articleUnit.unitStorage' => $piece, 'unitWorking' => $kilogramme, 'price' => 4.05,
            'articleUnit.packaging' => 4, 'tva' => $tvaReduit, 'minStock' => 3, ],
            ['name' => 'Appareil Champigons 2 KG', 'supplier' => $davifrais,
            'familyLog' => $frais, 'zoneStorage' => $zoneFrais,
            'articleUnit.unitStorage' => $piece, 'unitWorking' => $kilogramme, 'price' => 6.39,
            'articleUnit.packaging' => 4, 'tva' => $tvaReduit, 'minStock' => 2, ],
            ['name' => 'Bacon tranche Barq 88G', 'supplier' => $davifrais,
            'familyLog' => $frais, 'zoneStorage' => $zoneFrais,
            'articleUnit.unitStorage' => $piece, 'unitWorking' => $kilogramme, 'price' => 0.75,
            'articleUnit.packaging' => 6, 'tva' => $tvaReduit, 'minStock' => 2, ],
            ['name' => 'Beurre doux 8Gx125', 'supplier' => $davifrais,
            'familyLog' => $frais, 'zoneStorage' => $zoneFrais,
            'articleUnit.unitStorage' => $kilogramme, 'unitWorking' => $piece, 'price' => 6.83,
            'articleUnit.packaging' => 1, 'tva' => $tvaReduit, 'minStock' => 0.5, ],
            ['name' => 'Boule pour oeuf neige', 'supplier' => $davifrais,
            'familyLog' => $frais, 'zoneStorage' => $zoneFrais,
            'articleUnit.unitStorage' => $piece, 'unitWorking' => $piece, 'price' => 1.75,
            'articleUnit.packaging' => 6, 'tva' => $tvaReduit, 'minStock' => 2, ],
            ['name' => 'Champignons émincé 500G', 'supplier' => $davifrais,
            'familyLog' => $fruitLegumesFrais, 'zoneStorage' => $zoneFrais,
            'articleUnit.unitStorage' => $kilogramme, 'unitWorking' => $kilogramme,
            'price' => 3.17, 'articleUnit.packaging' => 3.5, 'tva' => $tvaReduit,
            'minStock' => 1, ],
            ['name' => 'Chorizo prétr. 500G', 'supplier' => $davifrais,
            'familyLog' => $fruitLegumesFrais, 'zoneStorage' => $zoneFrais,
            'articleUnit.unitStorage' => $kilogramme, 'unitWorking' => $kilogramme,
            'price' => 5.11, 'articleUnit.packaging' => 6, 'tva' => $tvaReduit, 'minStock' => 1, ],
            ['name' => 'V.RG Bourgueil 75cl', 'supplier' => $loireBoissons,
            'familyLog' => $vins, 'zoneStorage' => $zoneBoisson,
            'articleUnit.unitStorage' => $bouteille, 'unitWorking' => $bouteille,
            'price' => 5.11, 'articleUnit.packaging' => 6, 'tva' => $tvaReduit, 'minStock' => 3, ],
        ];

        foreach ($datas as $key => $data) {
            $article = new Article();
            $article->setName($data['name'])
                ->setSupplier($data['supplier'])
                ->setFamilyLog($data['familyLog'])
                ->addZoneStorage($data['zoneStorage'])
                // ->setArticleUnit($data['articleUnit.unitStorage'])
                // ->setArticleUnit($data['articleUnit.packaging'])
                // ->setUnitStorage($data['unitStorage'])
                ->setUnitWorking($data['unitWorking'])
                ->setPrice($data['price'])
                ->setTva($data['tva'])
                ->setMinStock($data['minStock']);

            $manager->persist($article);
            $order = $key + 1;
            $this->addReference('article'.$order, $article);

            $material = new Material();
            $material->setName($data['name'])
                ->setUnitWorking($data['unitWorking'])
                ->addArticle($this->getReference('article'.$order))
                ->setMultiple(0)
                ->setActive(1);

            $manager->persist($material);
            $this->addReference('material'.$order, $material);
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
        return 6;
    }
}
