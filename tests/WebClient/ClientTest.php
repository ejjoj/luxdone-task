<?php

namespace App\Tests\WebClient;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientTest extends WebTestCase
{
    public function testShouldNotBeAbleToGetAnyResultPassingNoParameters(): void {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testShouldGet400WhilePassingNotValidDate() : void {
        $client = static::createClient();
        $client->request('GET', '/eur/abc/dsa/');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testShouldNotBeAbleToProceedWithUnsupportedCurrency() : void {
        $client = static::createClient();
        $client->request('GET', '/jpy/2020-02-11/2020-02-20/');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}
