<?php

namespace App\Tests\Controller;

use App\Controller\HotelController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class HotelControllerTest extends WebTestCase
{

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hotel/index');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hotel index');
    }
}
