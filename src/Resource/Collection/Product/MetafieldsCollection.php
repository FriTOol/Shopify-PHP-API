<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 30/11/2016
 * Time: 16:42
 */

namespace ShopifyApi\Resource\Collection\Product;

use ShopifyApi\Resource\Collection\CollectionAbstract;
use ShopifyApi\Resource\Product\Metafield;

class MetafieldsCollection extends CollectionAbstract
{
    protected function _convertData()
    {
        foreach ($this->getRawData() as $rawData) {
            $this->_collection[] = new Metafield($rawData, $this->getProxy());
        }
    }
}