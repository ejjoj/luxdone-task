<?php

namespace App\Tests\Currency;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Classes\Tools;

class CurrencyTest extends ApiTestCase
{
    public function createRequest(string $currency = '',
                                  string $startDate = '',
                                  string $endDate = '') {
        $url = '/' . $currency . '/' . $startDate . '/' . $endDate . '/';
        return static::createClient()->request('GET', $url );
    }

    public function testResponse(): void {
        /**
         * given: currency - eur, startDate - 2020-04-05, endDate - 2020-07-09
         */
        $response = $this->createRequest('eur', '2020-04-05', '2020-07-09');

        /**
         * expected: Success
         */
        $this->assertResponseIsSuccessful();
    }
}
