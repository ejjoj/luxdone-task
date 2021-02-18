<?php


namespace App\Classes;


class Tools {
    public static function getStatsData(array $input = []) : array {
        if ($input) {
            $bid_sum = $ask_sum = $standard_deviation = 0;
            $input_count = count($input);
            foreach ($input as $item) {
                $bid_sum += $item['bid'];
                $ask_sum += $item['ask'];
            }
            $bid_sum /= $input_count;
            $ask_sum /= $input_count;

            foreach ($input as $item) {
                $standard_deviation += pow(abs(($item['ask'] - $ask_sum)), 2);
            }

            $standard_deviation = sqrt($standard_deviation / $input_count);

            return [
              'bid_avg' => round($bid_sum, 4),
              'standard_deviation_ask' => round($standard_deviation, 4)
            ];
        }
        return [];
    }

}