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

    protected $_updatedData = [];

    public function __construct($rawData, Proxy $proxy, bool $isLoaded = false)
    {
        $this->setRawData($rawData);
        $this->setProxy($proxy);
        $this->_isLoaded = $isLoaded;
    }

    protected function _getData(string $name)
    {
        if (isset($this->_updatedData[$name])) {
            return $this->_updatedData[$name];
        } elseif (isset($this->getRawData()->$name)) {
            return $this->getRawData()->$name;
        }

        return null;
    }

    public function getUpdatedData()
    {
        return $this->_updatedData;
    }

    public function resetUpdatedData()
    {
        $this->_updatedData = [];
    }
}