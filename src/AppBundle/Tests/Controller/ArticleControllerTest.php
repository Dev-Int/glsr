<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Article;

class ArticleControllerTest extends WebTestCase
{
    public function testIndex() {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article/');
        
        $this->assertCount(
            Article::NUM_ITEMS,
            $crawler->filter('article.name'),
            'Le message montre le bon nombre d\'articles.'
        );
    }

    public function testCreate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article');
        $this->assertCount(0, $crawler->filter('table.records_list tbody tr'));
        $form = $crawler->filter('form button[type="submit"]')->form(array(
            'article[name]' => 'Lorem ipsum dolor sit amet',
            'article[supplier]' => 1,
            'article[familyLog]' => 1,
            'article[zoneStorages]' => 1,
            'article[unitStorage]' => 1,
            'article[packaging]' => 10.99,
            'article[price]' => 10.99,
            'article[minstock]' => 10.99,
            'article[quantity]' => 0,
            'article[active]' => true,
            'article[slug]' => 'lorem-ipsum-dolor-sit-amet',
            )
        );
        $client->submit($form);
//        $crawler = $client->followRedirect();
//        $crawler = $client->click($crawler->filter('.record_actions button')->link());
//        $this->assertCount(1, $crawler->filter('table.records_list tbody tr'));
    }

    public function testCreateError()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article/admin/new');
        $form = $crawler->filter('form button[name="article[save]"]')->form();
        $crawler = $client->submit($form);
        $this->assertGreaterThan(0, $crawler->filter('form div.has-error')->count());
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * @depends testCreate
     */
    public function testEdit()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article/');
        $this->assertCount(1, $crawler->filter('table.records_list tbody tr:contains("First value")'));
        $this->assertCount(0, $crawler->filter('table.records_list tbody tr:contains("Changed")'));
        $crawler = $client->click($crawler->filter('table.records_list tbody tr td .btn-group a')->eq(1)->link());
        $form = $crawler->filter('form button[type="submit"]')->form(array(
            'article[name]' => 'Changed',
            'article[packaging]' => 10.99,
            'article[price]' => 10.99,
            'article[quantity]' => 10.99,
            'article[minstock]' => 10.99,
            'article[active]' => true,
            'article[slug]' => 'Changed',
            // ... adapt fields value here ...
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();
        $crawler = $client->click($crawler->filter('.record_actions a')->link());
        $this->assertCount(0, $crawler->filter('table.records_list tbody tr:contains("First value")'));
        $this->assertCount(1, $crawler->filter('table.records_list tbody tr:contains("Changed")'));
    }

    /**
     * @depends testCreate
     */
    public function testEditError()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article/');
        $crawler = $client->click($crawler->filter('table.records_list tbody tr td .btn-group a')->eq(1)->link());
        $form = $crawler->filter('form button[type="submit"]')->form(array(
            'article[name]' => '',
            // ... use a required field here ...
        ));
        $crawler = $client->submit($form);
        $this->assertGreaterThan(0, $crawler->filter('form div.has-error')->count());
    }

    /**
     * @depends testCreate
     */
    public function testDelete()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article/');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertCount(1, $crawler->filter('table.records_list tbody tr'));
        $crawler = $client->click($crawler->filter('table.records_list tbody tr td .btn-group a')->eq(0)->link());
        $client->submit($crawler->filter('form#delete button[type="submit"]')->form());
        $crawler = $client->followRedirect();
        $this->assertCount(0, $crawler->filter('table.records_list tbody tr'));
    }    /**
     * @depends testCreate
     */
    public function testSort()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/article/');
        $this->assertCount(1, $crawler->filter('table.records_list th')->eq(0)->filter('a i.fa-sort'));
        $crawler = $client->click($crawler->filter('table.records_list th a')->link());
        $crawler = $client->followRedirect();
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertCount(1, $crawler->filter('table.records_list th a i.fa-sort-up'));
    }
}
