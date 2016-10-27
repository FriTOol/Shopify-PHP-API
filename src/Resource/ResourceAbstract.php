<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 27/10/2016
 * Time: 18:29
 */

namespace ShopifyApi\Resource;

use ShopifyApi\Core\Proxy;
use ShopifyApi\ProxyTrait;

abstract class ResourceAbstract
{
    use ProxyTrait, ResourceRawDataTrait;

    protected $_isLoaded = false;

    public function __construct($rawData, Proxy $proxy, bool $isLoaded = false)
    {
        $this->setRawData($rawData);
        $this->setProxy($proxy);
        $this->_isLoaded = $isLoaded;
    }

    public function save()
    {

    }
}