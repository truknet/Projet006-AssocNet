<?php

namespace tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontControllerTest extends WebTestCase
{

    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(1, $crawler->filter('h4:contains("Vous représentez une association")')->count());
    }

    public function testLienAccueilDansIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $linkAccueil = $crawler->filter('a:contains(" Accueil")');
        $crawler =$client->click($linkAccueil->link());
        $this->assertEquals(1, $crawler->filter('h4:contains("Infos")')->count());
    }

    public function testLienAnnuaireDansIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $linkAccueil = $crawler->filter('a:contains(" Annuaire")');
        $crawler =$client->click($linkAccueil->link());
        $this->assertEquals(1, $crawler->filter('div.panel-heading:contains("Catégories")')->count());
    }

}

