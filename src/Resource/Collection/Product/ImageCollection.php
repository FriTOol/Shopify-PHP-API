<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 03/12/2016
 * Time: 19:53
 */

namespace ShopifyApi\Resource\Collection\Product;

use ShopifyApi\Resource\Collection\CollectionAbstract;
use ShopifyApi\Resource\Product\Image;

class ImageCollection extends CollectionAbstract
{
    protected function _convertData()
    {
        foreach ($this->getRawData() as $rawData) {
            $this->_collection[] = new Image($rawData, $this->getProxy());
        }
    }
}