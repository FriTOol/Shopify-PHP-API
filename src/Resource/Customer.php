<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 27/10/2016
 * Time: 18:28
 */

namespace ShopifyApi\Resource;

class Customer extends ResourceAbstract
{
    public function getId(): int
    {
        return intval($this->getRawData()->id);
    }

    public function getEmail(): string
    {
        return strval($this->getRawData()->email);
    }

    public function isVerifiedEmail(): bool
    {
        return $this->getRawData()->verified_email;
    }

    public function isAcceptsMarketing(): bool
    {
        return $this->getRawData()->accepts_marketing;
    }

    public function getCreatedAt(): \DateTime
    {
        return new \DateTime($this->getRawData()->created_at);
    }

    public function getUpdatedAt(): \DateTime
    {
        return new \DateTime($this->getRawData()->updated_at);
    }

    public function getFirstName(): string
    {
        return strval($this->getRawData()->first_name);
    }

    public function getLastName(): string
    {
        return strval($this->getRawData()->last_name);
    }

    public function getOrderCount(): int
    {
        return intval($this->getRawData()->orders_count);
    }

    public function getState(): string
    {
        return $this->getRawData()->state;
    }

    public function getTotalSpent(): float
    {
        return floatval($this->getRawData()->total_spent);
    }

    public function getLastOrderId(): int
    {
        return intval($this->getRawData()->last_order_id);
    }

    public function getNote(): string
    {
        return strval($this->getRawData()->note);
    }

    public function getMultipassIdentifier()
    {
        return $this->getRawData()->multipass_identifier;
    }

    public function isTaxExempt(): bool
    {
        return $this->getRawData()->tax_exempt;
    }

    public function getTags(): array
    {
        $tags = [];

        if (trim($this->getRawData()->tags) != '') {
            $tags = explode(',', $this->getRawData()->tags);
            $tags = array_map(function ($tag) { return trim($tag); }, $tags);
        }

        return $tags;
    }
}