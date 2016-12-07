<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 07/12/2016
 * Time: 19:55
 */

namespace ShopifyApi\Resource\Collection\Cart;

use ShopifyApi\Resource\Cart\LineItem;
use ShopifyApi\Resource\Collection\CollectionAbstract;

class LineItemCollection extends CollectionAbstract
{
    protected function _convertData()
    {
        foreach ($this->getRawData() as $rawData) {
            $this->_collection[] = new LineItem($rawData, $this->getProxy());
        }
    }
}