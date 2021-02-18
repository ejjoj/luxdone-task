<?php

namespace App\Controller;

use App\Classes\FetchData;
use App\Classes\Tools;
use App\Classes\Validate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @Route("/")
 */
class CurrencyController extends AbstractController
{
    /**
     * @Route("/{currency}/{startDate}/{endDate}/", name="currency")
     */
    public function index(HttpClientInterface $client,
                          string $currency = '',
                          string $startDate = '',
                          string $endDate = ''): Response {
        $fetchData = new FetchData($client);
        $response = $fetchData->fetchDataFromNBP($currency, $startDate, $endDate);
        if ($response['error']) {
            return $this->json($response['message'], $response['status']);
        }
        $rates = $response['content']['rates'];
        $statsData = Tools::getStatsData($rates);
        if ($statsData) {
            return $this->json([
                'standard_deviation' => $statsData['standard_deviation_ask'],
                'average_price' => $statsData['bid_avg']
            ]);
        }
    }
}
