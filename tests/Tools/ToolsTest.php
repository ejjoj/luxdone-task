<?php

namespace App\Tests\Tools;

use App\Classes\Tools;
use PHPUnit\Framework\TestCase;

class ToolsTest extends TestCase {

    public function testStatsData(): void {
        $arr = [];

        /**
         * Given an array of three items that contains pairs of key-values like bid, ask, and goes like [7, 4, -2].
         */

        $arr = [
            [
                'bid' => 7,
                'ask' => 7,
            ],
            [
                'bid' => 4,
                'ask' => 4,
            ],
            [
                'bid' => -2,
                'ask' => -2,
            ],
        ];

        $result = Tools::getStatsData($arr);

        /**
         * Expected: Success.
         */

        $this->assertSame((float)round(sqrt(14), 4), (float)$result['standard_deviation_ask']);
        $this->assertSame(3.0, $result['bid_avg']);
    }
}
