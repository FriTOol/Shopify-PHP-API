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
        return strval($this->getData('title'));
    }

    public function getPrice(): float
    {
        return floatval($this->getData('price'));
    }

    public function getSku(): string
    {
        return strval($this->getData('sku'));
    }

    public function getPosition(): int
    {
        return intval($this->getData('position'));
    }

    public function getGrams(): int
    {
        return intval($this->getData('grams'));
    }

    public function getImage(): Image
    {
        return new Image(
            $this->getProxy()->getProductImage(
                $this->getData('product_id'),
                $this->getData('image_id')
            )->image,
            $this->getProxy()
        );
    }

    public function hasImage()
    {
        return !is_null($this->getData('image_id'));
    }
}