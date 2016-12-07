<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 07/12/2016
 * Time: 19:56
 */

namespace ShopifyApi\Resource\Cart;

use ShopifyApi\Resource\ResourceAbstract;

class LineItem extends ResourceAbstract
{
    public function getId(): int
    {
        return intval($this->getRawData()->id);
    }

    public function getProperties()
    {
        return $this->getRawData()->properties;
    }

    public function getQuantity(): int
    {
        return intval($this->getRawData()->quantity);
    }

    public function getVariantId(): int
    {
        return intval($this->getRawData()->variant_id);
    }

    public function getKey(): string
    {
        return strval($this->getRawData()->key);
    }

    public function getTitle(): string
    {
        return strval($this->getRawData()->title);
    }

    public function getPrice(): float
    {
        return floatval($this->getRawData()->price);
    }

    public function getOriginalPrice(): float
    {
        return floatval($this->getRawData()->original_price);
    }

    public function getDiscountedPrice(): float
    {
        return floatval($this->getRawData()->discounted_price);
    }

    public function getLinePrice(): float
    {
        return floatval($this->getRawData()->line_price);
    }

    public function getOriginalLinePrice(): float
    {
        return floatval($this->getRawData()->original_line_price);
    }

    public function getTotalDiscount(): float
    {
        return floatval($this->getRawData()->total_discount);
    }

    public function getDiscounts()
    {
        return $this->getRawData()->discounts;
    }

    public function getSku(): string
    {
        return strval($this->getRawData()->sku);
    }

    public function getGrams(): int
    {
        return intval($this->getRawData()->grams);
    }

    public function getVendor(): string
    {
        return $this->getRawData()->vendor;
    }

    public function getProductId(): int
    {
        return intval($this->getRawData()->product_id);
    }

    public function getGiftCard(): bool
    {
        return boolval($this->getRawData()->gift_card);
    }
}