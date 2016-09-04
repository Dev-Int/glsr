<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * PHPUnit's data providers allow to execute the same tests repeated times
     * using a different set of data each time.
     * See http://symfony.com/doc/2.8/form/unit_testing.html#testing-against-different-sets-of-data
     *
     * @dataProvider getPublicUrls
     */
    public function testPublicUrls($url)
    {
        $client = self::createClient();
        if ($url === '/article/' or $url === '/supplier/') {
            $stub = $this->getMockForAbstractClass('\AppBundle\Controller\AbstractController');
            $stub->expects($this->any());

            if ($url === '/article/') {
                $this->assertTrue(
                    $stub->abstractIndexAction('Article', null),
                    sprintf('The "%s" public URL loads correctly.', $url)
                );
            }
            if ($url === '/supplier/') {
                $this->assertTrue(
                    $stub->abstractIndexAction('Supplier', null),
                    sprintf('The "%s" public URL loads correctly.', $url)
                );
            }
        } else {
            $client->request('GET', $url);
            $this->assertTrue(
                $client->getResponse()->isSuccessful(),
                sprintf('The "%s" public URL loads correctly.', $url)
            );
        }
    }

    /**
     * The application contains a lot of secure URLs which shouldn't be
     * publicly accessible. This tests ensures that whenever a user tries to
     * access one of those pages, a redirection to the login form is performed.
     *
     * @dataProvider getSecureUrls
     */
    public function testSecureUrls($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isRedirect());
        $this->assertEquals(
            'http://symfony2.local/login',
            $client->getResponse()->getTargetUrl(),
            sprintf('The "%s" secure URL redirects to the login form.', $url)
        );
    }

    public function getPublicUrls()
    {
        return array(
            array('/'),
            array('/login'),
            array('/inventory/'),
            array('/article/'),
            array('/supplier/'),
        );
    }

    public function getSecureUrls()
    {
        return array(
            array('/admin/user/'),
            array('/admin/group/'),
            array('/admin/settings/company/'),
            array('/admin/settings/application/'),
            array('/admin/settings/divers/familylog/'),
            array('/admin/settings/divers/zonestorage/'),
            array('/admin/settings/divers/unitstorage/'),
            array('/admin/settings/divers/tva/'),
            array('/article/admin/new'),
            array('/supplier/admin/new'),
        );
    }

    public function testIndex() {
        $client = self::createClient(
            array(),
            array(
               'HTTP_HOST' => 'symfony2.local',
            )
        );

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Accueil', $crawler->filter('.container .row #content h2')->text());
    }

}
