<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 27/10/2016
 * Time: 14:23
 */
namespace ShopifyApi\Resource\Collection;
use ShopifyApi\ProxyTrait;
use ShopifyApi\Resource\ResourceAbstract;
use ShopifyApi\Resource\ResourceRawDataTrait;

abstract class CollectionAbstract implements \IteratorAggregate, \Countable, \ArrayAccess
{
    use ResourceRawDataTrait, ProxyTrait;

    /**
     * @var array
     */
    protected $_collection = [];

    abstract protected function _convertData();

    public function __construct($rawData, $ambassador)
    {
        $this->setRawData($rawData);
        $this->setProxy($ambassador);
        $this->_convertData();
    }

    public function count()
    {
        return count($this->_collection);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->_collection);
    }

    public function offsetExists($offset)
    {
        return isset($this->_collection[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->_collection[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->_collection[] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->_collection[$offset]);
    }

    public function getUpdatedData()
    {
        $data = array_map(
            function(ResourceAbstract $resource) {
                return $resource->getUpdatedData();
            },
            $this->_collection
        );

        return $data;
    }

}