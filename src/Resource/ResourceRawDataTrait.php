<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 27/10/2016
 * Time: 14:24
 */

namespace ShopifyApi\Resource;

trait ResourceRawDataTrait
{
    protected $_rawData;

    /**
     * @return mixed
     */
    public function getRawData()
    {
        return $this->_rawData;
    }

    /**
     * @param mixed $rawData
     */
    public function setRawData($rawData)
    {
        $this->_rawData = $rawData;
    }
}