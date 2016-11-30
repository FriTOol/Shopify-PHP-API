<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 30/11/2016
 * Time: 13:33
 */

namespace ShopifyApi\Resource\Collection;

use ShopifyApi\Resource\Metafield;

class MetafieldsCollection extends CollectionAbstract
{
    protected function _convertData()
    {
        foreach ($this->getRawData() as $rawData) {
            $this->_collection[] = new Metafield($rawData, $this->getProxy());
        }
    }
}