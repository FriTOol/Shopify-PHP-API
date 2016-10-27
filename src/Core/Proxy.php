<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 27/10/2016
 * Time: 13:10
 */

namespace ShopifyApi\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Proxy
{
    const BASE_URL = 'https://%s/admin/';

    private $_apiKey;

    private $_apiSecret;

    private $_storeUrl;

    public function __construct(string $apiKey, string $apiSecret, string $storeUrl, array $configs = [])
    {
        $this->_apiKey = $apiKey;
        $this->_apiSecret = $apiSecret;
        $this->_storeUrl = $storeUrl;

        $configs['http_client']['base_uri'] = sprintf(
            self::BASE_URL,
            $this->_storeUrl
        );

        $this->_httpClient = new Client($configs['http_client']);
    }

    public function getCustomers(array $params = [])
    {
        return $this->_callApi('customers.json', $params);
    }

    private function _callApi(string $method, array $params = [])
    {
        $options = [
            'auth' => [$this->_apiKey, $this->_apiSecret],
            'query' => $params
        ];
//        try {
            $response = $this->_httpClient->get($method, $options);
//        var_dump($response->getBody()->getContents());
//        } catch (ClientException $exception) {
//            $data = json_decode($exception->getResponse()->getBody()->getContents());
//            switch (intval($data->response->code)) {
//                case 404: throw new NotFoundException($data->response->errors->error[0], 404, $exception);
//                case 505: throw new InternalServerErrorException($data->response->errors->error[0], 500, $exception);
//            }
//            throw $exception;
//        }
        $data = \json_decode($response->getBody()->getContents());
        return $data;
    }
}