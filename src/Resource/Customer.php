<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 27/10/2016
 * Time: 18:28
 */

namespace ShopifyApi\Resource;

use ShopifyApi\Resource\Collection\Customer\AddressCollection;
use ShopifyApi\Resource\Customer\Address;

class Customer extends ResourceAbstract
{
    use TagResourceTrait;

    /**
     * @var AddressCollection
     */
    private $_addresses;

    /**
     * @var Address
     */
    private $_defaultAddress;

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

    public function setNote(string $note): Customer
    {
        $this->_updatedData['note'] = $note;

        return $this;
    }

    public function getMultipassIdentifier()
    {
        return $this->getRawData()->multipass_identifier;
    }

    public function isTaxExempt(): bool
    {
        return $this->getRawData()->tax_exempt;
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

    public function getAddresses(): AddressCollection
    {
        if (is_null($this->_addresses)) {
            $data = [];
            if (isset($this->getRawData()->addresses)
                && count($this->getRawData()->addresses) > 0
            ) {
                $data = $this->getRawData()->addresses;
            }

            $this->_addresses = new AddressCollection($data, $this->getProxy());
            $this->_addresses->setCustomer($this);
        }
        return $this->_addresses;
    }

    public function getDefaultAddress(): Address
    {
        if (is_null($this->_defaultAddress)) {
            $this->_defaultAddress = new Address(
                $this->getRawData()->default_address,
                $this->getProxy()
            );
        }

        return $this->_defaultAddress;
    }

    public function addAddress(Address $address): Customer
    {
        if ($address->isDefault()) {
            $this->setDefaultAddress($address);
        }

        $address->setCustomer($this);
        $this->getAddresses()[] = $address;

        return $this;
    }

    public function setDefaultAddress(Address $address): Customer
    {
        $address->setCustomer($this);
        $address->setDefault();
        $this->_defaultAddress = $address;

        return $this;
    }

    public function setSendEmailInvite(bool $sendEmailInvite): Customer
    {
        $this->_updatedData['send_email_invite'] = $sendEmailInvite;

        return $this;
    }

    public function save()
    {
        if ($this->getRawData() && $this->getId()) {
            /** @var Address $address */
            foreach ($this->getAddresses() as $address) {
                $address->save();
            }

            if (count($this->_updatedData) > 0) {
                $this->getProxy()->updateCustomer(
                    $this->getId(),
                    $this->_updatedData
                );
            }
        } else {
            $addressData = $this->getAddresses()->getUpdatedData();
            $data = $this->_updatedData;
            $data['addresses'] = $addressData;

            $data = $this->getProxy()->createCustomer($data);
            $this->setRawData($data->customer);
        }

        $this->getDefaultAddress()->save();
        $this->resetUpdatedData();

        return true;
    }
}