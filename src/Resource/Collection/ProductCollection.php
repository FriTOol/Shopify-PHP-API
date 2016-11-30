<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 30/11/2016
 * Time: 12:39
 */

namespace ShopifyApi\Resource\Collection;

use ShopifyApi\Resource\Product;

class ProductCollection extends CollectionAbstract
{
    protected function _convertData()
    {
        foreach ($this->getRawData() as $rawData) {
            $this->_collection[] = new Product($rawData, $this->getProxy());
        }
    }
}