<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InventoryControllerTest extends WebTestCase
{
    public function testIndex() {
        $client = self::createClient(
//            array(),
//            array(
//               'HTTP_HOST' => 'symfony2.local',
//            )
        );

        $crawler = $client->request('GET', '/inventory/');
        $this->assertEquals(1, $crawler->filter('.container .row #content h2:contains("Inventaires - Liste")')->count());

//        $this->assertContains('Inventaires - Liste', $crawler->filter('.container .row #content h2')->text());
    }

    public function testCreate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/inventory/');
        $this->assertCount(8, $crawler->filter('table.records_list tbody tr'));
        $crawler = $client->click($crawler->filter('.new_entry a')->link());
        $form = $crawler->filter('form button[type="submit"]')->form(array(
            'inventory[date]' => new \DateTime(),
            'inventory[active]' => true,
            'inventory[amount]' => 10.99,
            'inventory[file]' => 'Lorem ipsum dolor sit amet',
                    ));
        $client->submit($form);
        $crawler = $client->followRedirect();
        $crawler = $client->click($crawler->filter('.record_actions a')->link());
        $this->assertCount(9, $crawler->filter('table.records_list tbody tr'));
    }

//    public function testCreateError()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/inventory/new');
//        $form = $crawler->filter('form button[type="submit"]')->form();
//        $crawler = $client->submit($form);
//        $this->assertGreaterThan(0, $crawler->filter('form div.has-error')->count());
//        $this->assertTrue($client->getResponse()->isSuccessful());
//    }
//
//    /**
//     * @depends testCreate
//     */
//    public function testEdit()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/inventory/');
//        $this->assertCount(1, $crawler->filter('table.records_list tbody tr:contains("First value")'));
//        $this->assertCount(0, $crawler->filter('table.records_list tbody tr:contains("Changed")'));
//        $crawler = $client->click($crawler->filter('table.records_list tbody tr td .btn-group a')->eq(1)->link());
//        $form = $crawler->filter('form button[type="submit"]')->form(array(
//            'inventory[date]' => new \DateTime(),
//            'inventory[active]' => true,
//            'inventory[amount]' => 10.99,
//            'inventory[file]' => 'Changed',
//            // ... adapt fields value here ...
//        ));
//        $client->submit($form);
//        $crawler = $client->followRedirect();
//        $crawler = $client->click($crawler->filter('.record_actions a')->link());
//        $this->assertCount(0, $crawler->filter('table.records_list tbody tr:contains("First value")'));
//        $this->assertCount(1, $crawler->filter('table.records_list tbody tr:contains("Changed")'));
//    }
//
//    /**
//     * @depends testCreate
//     */
//    public function testEditError()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/inventory/');
//        $crawler = $client->click($crawler->filter('table.records_list tbody tr td .btn-group a')->eq(1)->link());
//        $form = $crawler->filter('form button[type="submit"]')->form(array(
//            'inventory[field_name]' => '',
//            // ... use a required field here ...
//        ));
//        $crawler = $client->submit($form);
//        $this->assertGreaterThan(0, $crawler->filter('form div.has-error')->count());
//    }
//
//    /**
//     * @depends testCreate
//     */
//    public function testDelete()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/inventory/');
//        $this->assertTrue($client->getResponse()->isSuccessful());
//        $this->assertCount(1, $crawler->filter('table.records_list tbody tr'));
//        $crawler = $client->click($crawler->filter('table.records_list tbody tr td .btn-group a')->eq(0)->link());
//        $client->submit($crawler->filter('form#delete button[type="submit"]')->form());
//        $crawler = $client->followRedirect();
//        $this->assertCount(0, $crawler->filter('table.records_list tbody tr'));
//    }
}
