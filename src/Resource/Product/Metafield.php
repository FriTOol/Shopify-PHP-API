<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 30/11/2016
 * Time: 16:29
 */

namespace ShopifyApi\Resource\Product;

use ShopifyApi\Resource\Metafield as MainMetafield;
use ShopifyApi\Resource\Product;

class Metafield extends MainMetafield
{
    /**
     * @var Product
     */
    private $_product;

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->_product;
    }

    public function setProduct(Product $product): Metafield
    {
        $this->_product = $product;

        return $this;
    }

    public function save()
    {
        if ($this->getRawData() && $this->getId()) {
            $data = $this->getProxy()->saveProductMetafield(
                $this->getProduct()->getId(),
                $this->getId(),
                $this->_updatedData
            );
        } else {
            $data = $this->getProxy()->addProductMetafield(
                $this->getProduct()->getId(),
                $this->_updatedData
            );
        }

        $this->setRawData($data->metafield);
        $this->resetUpdatedData();
    }
}