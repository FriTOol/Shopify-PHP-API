<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 07/12/2016
 * Time: 19:43
 */

namespace ShopifyApi\Resource;

use ShopifyApi\Resource\Cart\LineItem;
use ShopifyApi\Resource\Collection\Cart\LineItemCollection;

class Cart extends ResourceAbstract
{
    public function getId(): string
    {
        return $this->getRawData()->id;
    }

    public function getToken(): string
    {
        return $this->getRawData()->token;
    }

    public function getNote(): string
    {
        return $this->getRawData()->note;
    }

    public function getLineItems(): LineItemCollection
    {
        return new LineItemCollection(
            $this->getRawData()->line_items,
            $this->getProxy()
        );
    }

    public function getPrice(): float
    {
        $price = 0.0;
        /** @var LineItem $lineItem */
        foreach ($this->getLineItems() as $lineItem) {
            $price += $lineItem->getDiscountedPrice();
        }

        return floatval($price);
    }

    public function getWeight(): int
    {
        $weight = 0.0;
        /** @var LineItem $lineItem */
        foreach ($this->getLineItems() as $lineItem) {
            $weight += $lineItem->getGrams();
        }

        return intval($weight);
    }
}