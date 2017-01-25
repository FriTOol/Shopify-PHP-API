<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 30/11/2016
 * Time: 13:26
 */

namespace ShopifyApi\Resource;

class Metafield extends ResourceAbstract
{
    public function getId(): int
    {
        return intval($this->getRawData()->id);
    }

    public function getNamespace(): string
    {
        return strval($this->getData('namespace'));
    }

    public function setNamespace(string $namespace): Metafield
    {
        $this->_updatedData['namespace'] = $namespace;

        return $this;
    }

    public function getKey(): string
    {
        return strval($this->getData('key'));
    }

    public function setKey(string $key): Metafield
    {
        $this->_updatedData['key'] = $key;

        return $this;
    }

    public function getValue()
    {
        return $this->getData('value');
    }

    public function setValue($value): Metafield
    {
        $this->_updatedData['value'] = $value;

        return $this;
    }

    public function getValueType(): string
    {
        return strval($this->getData('value_type'));
    }

    public function setValueType(string $valueType): Metafield
    {
        $this->_updatedData['value_type'] = $valueType;

        return $this;
    }

    public function getDescription(): string
    {
        return strval($this->getData('description'));
    }

    public function getOwnerId(): int
    {
        return intval($this->getData('owner_id'));
    }

    public function getOwnerResource(): string
    {
        return strval($this->getData('owner_resource'));
    }
}