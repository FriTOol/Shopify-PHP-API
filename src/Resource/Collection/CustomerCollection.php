<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 27/10/2016
 * Time: 14:21
 */

namespace ShopifyApi\Resource\Collection;

use ShopifyApi\Resource\Customer;

class CustomerCollection extends CollectionAbstract
{
    protected function _convertData()
    {
        foreach ($this->getRawData() as $rawData) {
            $this->_collection[] = new Customer($rawData, $this->getProxy());
        }
    }
}