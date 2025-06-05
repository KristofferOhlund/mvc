<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TwigAdventureTest extends WebTestCase
{
    public function testInit(): void
    {
        $client = static::createClient();
        $client->request('GET', '/proj/init');

        $this->assertResponseRedirects();
    }
}
