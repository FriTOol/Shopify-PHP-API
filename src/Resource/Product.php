<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 30/11/2016
 * Time: 12:39
 */

namespace ShopifyApi\Resource;

use ShopifyApi\Resource\Collection\Product\ImageCollection;
use ShopifyApi\Resource\Collection\Product\MetafieldsCollection;
use ShopifyApi\Resource\Collection\Product\VariantCollection;
use ShopifyApi\Resource\Product\Metafield;

class Product extends ResourceAbstract
{
    use TagResourceTrait;

    /**
     * @var MetafieldsCollection
     */
    private $_metafields;

    /**
     * @var ImageCollection
     */
    private $_images;

    public function getId(): int
    {
        return intval($this->getRawData()->id);
    }

    public function getTitle(): string
    {
        return strval($this->getData('title'));
    }

    public function getBodyHtml(): string
    {
        return strval($this->getData('body_html'));
    }

    public function getVendor(): string
    {
        return strval($this->getData('vendor'));
    }

    public function getProductType(): string
    {
        return strval($this->getData('product_type'));
    }

    public function getHandle(): string
    {
        return strval($this->getData('handle'));
    }

    public function getPublishedAt(): ?\DateTime
    {
        $publishedAt = $this->getData('published_at');
        if (is_null($publishedAt)) {
            return null;
        }

        return new \DateTime($publishedAt);
    }

    public function getTemplateSuffix()
    {
        return $this->getData('template_suffix');
    }

    public function getPublishedScope()
    {
        return strval($this->getData('published_scope'));
    }

    public function getVariants(): VariantCollection
    {
        return new VariantCollection($this->getData('variants'), $this->getProxy());
    }

    public function getMetafields(): MetafieldsCollection
    {
        if (is_null($this->_metafields)) {
            $this->_metafields = new MetafieldsCollection(
                $this->getProxy()->getProductMetafields($this->getId())->metafields,
                $this->getProxy()
            );
            foreach ($this->_metafields as $metafield) {
                $metafield->setProduct($this);
            }
        }

        return $this->_metafields;
    }

    public function addMetafield(Metafield $metafield)
    {
        $metafield->setProduct($this);
        $this->_updatedData['metafields'][] = $metafield;
    }

    public function removeMetafield(Metafield $metafield)
    {
        if ($metafield->getId()) {
            $this->getProxy()->removeProductMetafield(
                $this->getId(),
                $metafield->getId()
            );
        }

        return $this;
    }

    public function getImages(): ImageCollection
    {
        if (is_null($this->_images)) {
            $this->_images = new ImageCollection(
                $this->getProxy()->getProductImages($this->getId())->images,
                $this->getProxy()
            );
        }

        return $this->_images;
    }

    public function save()
    {
        if (isset($this->_updatedData['metafields'])) {
            /** @var Metafield $metafield */
            foreach ($this->_updatedData['metafields'] as $metafield) {
                $metafield->save();
            }
        }
    }
}