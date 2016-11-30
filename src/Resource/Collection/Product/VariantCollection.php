<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 30/11/2016
 * Time: 13:18
 */

namespace ShopifyApi\Resource\Collection\Product;

use ShopifyApi\Resource\Collection\CollectionAbstract;
use ShopifyApi\Resource\Product;

class VariantCollection extends CollectionAbstract
{
    protected function _convertData()
    {
        foreach ($this->getRawData() as $rawData) {
            $this->_collection[] = new Product\Variant($rawData, $this->getProxy());
        }
    }
}
