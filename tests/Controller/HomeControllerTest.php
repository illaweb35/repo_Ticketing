<?php
namespace App\tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', 'home/index.html.twig');
        $this->assertEquals(200, $client->getResponse()->getstatusCode());
    }
}
