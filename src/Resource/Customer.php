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
        return strval($this->_getData('email'));
    }

    public function setEmail(string $email): Customer
    {
        $this->_updatedData['email'] = $email;

        return $this;
    }

    public function isVerifiedEmail(): bool
    {
        return $this->_getData('verified_email');
    }

    public function setIsVerifiedEmail(bool $isVerified): Customer
    {
        $this->_updatedData['verified_email'] = $isVerified;

        return $this;
    }

    public function isAcceptsMarketing(): bool
    {
        return $this->_getData('accepts_marketing');
    }

    public function setIsAcceptsMarketing(bool $isAccepts): Customer
    {
        $this->_updatedData['accepts_marketing'] = $isAccepts;

        return $this;
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
        return strval($this->_getData('first_name'));
    }

    public function setFirstName(string $firstName): Customer
    {
        $this->_updatedData['first_name'] = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return strval($this->_getData('last_name'));
    }

    public function setLastName(string $lastName): Customer
    {
        $this->_updatedData['last_name'] = $lastName;

        return $this;
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
        return strval($this->_getData('note'));
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
        $strTags = $this->_getData('tags');
        if (trim($strTags) != '') {
            $tags = explode(',', $strTags);
            $tags = array_map(function ($tag) { return trim($tag); }, $tags);
        }

        return $tags;
    }

    public function setTags(array $tags): Customer
    {
        $this->_updatedData['tags'] = implode(', ', $tags);

        return $this;
    }

    public function addTag(string $tag): Customer
    {
        $tags = $this->getTags();
        $tags[] = $tag;
        $this->setTags($tags);

        return $this;
    }

    public function removeTag(string $removeTag): Customer
    {
        $removeTag = strtolower($removeTag);
        $tags = array_filter($this->getTags(), function (string $tag) use ($removeTag) {
            return strtolower($tag) != $removeTag;
        });
        $this->setTags($tags);

        return $this;
    }

    public function setSendEmailWelcome(bool $isSend): Customer
    {
        $this->_updatedData['send_email_welcome'] = $isSend;

        return $this;
    }

    public function setPassword(string $password): Customer
    {
        $this->_updatedData['password'] = $password;
        $this->_updatedData['password_confirmation'] = $password;

        return $this;
    }

    public function save()
    {
        if ($this->getRawData() && $this->getId()) {
            $this->getProxy()->updateCustomer($this->getId(), $this->_updatedData);
        } else {
            $data = $this->getProxy()->createCustomer($this->_updatedData);
            $this->setRawData($data->customer);
        }
    }
}