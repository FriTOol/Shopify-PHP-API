<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 03/12/2016
 * Time: 19:52
 */

namespace ShopifyApi\Resource\Product;

use ShopifyApi\Resource\ResourceAbstract;

class Image extends ResourceAbstract
{
    public function getId(): int
    {
        return intval($this->getRawData()->id);
    }

    public function getSrc(): string
    {
        return strval($this->getData('src'));
    }
}