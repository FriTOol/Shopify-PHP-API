<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 27/10/2016
 * Time: 13:05
 */

namespace ShopifyApi;

use ShopifyApi\Core\Proxy;
use ShopifyApi\Resource\Collection\CustomerCollection;

class ShopifyApi
{
    /**
     * @var Proxy
     */
    private $_proxy;

    private $_defaultConfigs = [
        'http_client' => [
            'timeout' => 5,
            'allow_redirects' => true,
        ]
    ];

    public function __construct(string $apiKey, string $apiSecret, string $storeUrl, array $configs = [])
    {
        $configs = array_merge($this->_defaultConfigs, $configs);
        $this->_proxy = new Proxy($apiKey, $apiSecret, $storeUrl, $configs);
    }

    public function getProxy(): Proxy
    {
        return $this->_proxy;
    }

    public function getCustomers(array $params = [])
    {
        return new CustomerCollection($this->getProxy()->getCustomers($params)->customers, $this->getProxy());
    }
}