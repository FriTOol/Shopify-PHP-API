<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 30/11/2016
 * Time: 12:59
 */

namespace ShopifyApi\Resource;

trait TagResourceTrait
{
    public function hasTag(string $tag): bool
    {
        return in_array($tag, $this->getTags());
    }

    public function getTags(): array
    {
        $tags = [];
        $strTags = $this->getData('tags');
        if (trim($strTags) != '') {
            $tags = explode(',', $strTags);
            $tags = array_map(function ($tag) { return trim($tag); }, $tags);
        }

        return $tags;
    }

    public function setTags(array $tags)
    {
        $this->_updatedData['tags'] = implode(', ', $tags);

        return $this;
    }

    public function addTag(string $tag)
    {
        $tags = $this->getTags();
        $tags[] = $tag;
        $this->setTags($tags);

        return $this;
    }

    public function removeTag(string $removeTag)
    {
        $removeTag = strtolower($removeTag);
        $tags = array_filter($this->getTags(), function (string $tag) use ($removeTag) {
            return strtolower($tag) != $removeTag;
        });
        $this->setTags($tags);

        return $this;
    }
}