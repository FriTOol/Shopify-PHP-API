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

//    public static abstract function create(array $data);
//
//    public static abstract function update(int $id, array $data);
//
//    public static abstract function delete(int $id);


    public function __construct(
        $rawData,
        Proxy $proxy = null,
        bool $isLoaded = false
    ) {
        $this->setRawData($rawData);
        if (is_null($proxy)) {
            $proxy = Proxy::getInstance();
        }
        $this->setProxy($proxy);
        $this->_isLoaded = $isLoaded;
    }

    public function getUpdatedData()
    {
        return $this->_updatedData;
    }

    public function resetUpdatedData()
    {
        $this->_updatedData = [];
    }

    public function getCreatedAt(): \DateTime
    {
        return new \DateTime($this->getRawData()->created_at);
    }

    public function getUpdatedAt(): \DateTime
    {
        return new \DateTime($this->getRawData()->updated_at);
    }

    protected function getData(string $name)
    {
        if (isset($this->_updatedData[$name])) {
            return $this->_updatedData[$name];
        } elseif (isset($this->getRawData()->$name)) {
            return $this->getRawData()->$name;
        }

        return null;
    }
}