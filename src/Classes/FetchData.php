<?php


namespace App\Classes;


use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FetchData {

    private $client;
    private $msg = [
        'error' => false,
        'message' => '',
        'content' => [],
        'status' => 200
    ];

    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }

    private function setMsg(bool $error = false,
                            string $message = '',
                            array $content = [],
                            int $status = 200) : void {
        $this->msg['error'] = $error;
        $this->msg['content'] = $content;
        $this->msg['message'] = $message;
        $this->msg['status'] = $status;
    }

    private function getMsg() : array {
        return $this->msg;
    }

    public function fetchDataFromNBP(string $currency = '',
                                     string $startDate = '',
                                     string $endDate = '') : array {
        if (!Validate::isSupportedCurrency($currency)) {
            $this->setMsg(true, 'Currency code is not supported or is invalid', [], 400);
            return $this->getMsg();
        }

        if (!Validate::isDate($startDate)) {
            $this->setMsg(true, 'Start date format is invalid or date is invalid', [], 400);
            return $this->getMsg();
        }

        if (!Validate::isDate($endDate)) {
            $this->setMsg(true, 'End date format is invalid or date is invalid', [], 400);
            return $this->getMsg();
        }

        try {
            $currencyToLower = strtolower($currency);
            $response = $this->client->request(
                'GET',
                'http://api.nbp.pl/api/exchangerates/rates/c/' . $currencyToLower . '/' . $startDate . '/' . $endDate . '/?format=json'
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                $content = $response->toArray();
                $this->setMsg(false, '', $content, $statusCode);
                return $this->getMsg();
            }

            switch ($statusCode) {
                case 404:
                    $this->setMsg(true, 'Not found', [], $statusCode);
                    return $this->getMsg();
                default:
                    $this->setMsg(true, 'Internal Server Error', [], $statusCode);
                    return $this->getMsg();
            }

        } catch(TransportExceptionInterface
        | ClientExceptionInterface
        | DecodingExceptionInterface
        | RedirectionExceptionInterface |
        ServerExceptionInterface $e) {
            $this->setMsg(true, $e, [], 500);
            return $this->getMsg();
        }
    }
}