<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 30/11/2016
 * Time: 13:14
 */

namespace ShopifyApi\Resource\Product;

use ShopifyApi\Resource\ResourceAbstract;

class Variant extends ResourceAbstract
{
    public function getId(): int
    {
        return intval($this->getRawData()->id);
    }

    public function getTitle(): string
    {
        return strval($this->_getData('title'));
    }

    public function getPrice(): float
    {
        return floatval($this->_getData('price'));
    }

    public function getSku(): string
    {
        return strval($this->_getData('sku'));
    }

    public function getPosition(): int
    {
        return intval($this->_getData('position'));
    }

    public function getGrams(): int
    {
        return intval($this->_getData('grams'));
    }
}