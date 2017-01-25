<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 07/11/2016
 * Time: 17:21
 */

namespace ShopifyApi\Resource\Customer;

use ShopifyApi\Resource\Customer;
use ShopifyApi\Resource\ResourceAbstract;

class Address extends ResourceAbstract
{
    /**
     * @var Customer
     */
    private $_customer;

    public function setCustomer(Customer $customer)
    {
        $this->_customer = $customer;
    }

    public function getId(): int
    {
        return intval($this->getData('id'));
    }

    public function getFirstName(): string
    {
        return strval($this->getData('first_name'));
    }

    public function setFirstName(string $firstName): Address
    {
        $this->_updatedData['first_name'] = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return strval($this->getData('last_name'));
    }

    public function setLastName(string $lastName): Address
    {
        $this->_updatedData['last_name'] = $lastName;

        return $this;
    }

    public function getCompany(): string
    {
        return strval($this->getData('company'));
    }


    public function setCompany(string $company): Address
    {
        $this->_updatedData['company'] = $company;

        return $this;
    }

    public function getAddress1(): string
    {
        return strval($this->getData('address1'));
    }

    public function setAddress1(string $address1): Address
    {
        $this->_updatedData['address1'] = $address1;

        return $this;
    }

    public function getAddress2(): string
    {
        return strval($this->getData('address2'));
    }

    public function setAddress2(string $address2): Address
    {
        $this->_updatedData['address2'] = $address2;

        return $this;
    }

    public function getCity(): string
    {
        return strval($this->getData('city'));
    }

    public function setCity(string $city): Address
    {
        $this->_updatedData['city'] = $city;

        return $this;
    }

    public function getProvince(): string
    {
        return strval($this->getData('province'));
    }

    public function setProvince(string $province): Address
    {
        $this->_updatedData['province'] = $province;

        return $this;
    }

    public function getCountry(): string
    {
        return strval($this->getData('country'));
    }

    public function setCountry(string $country): Address
    {
        $this->_updatedData['country'] = $country;

        return $this;
    }

    public function getZip(): string
    {
        return strval($this->getData('zip'));
    }

    public function setZip(string $zip): Address
    {
        $this->_updatedData['zip'] = $zip;

        return $this;
    }

    public function getPhone(): string
    {
        return strval($this->getData('phone'));
    }

    public function setPhone(string $phone): Address
    {
        $this->_updatedData['phone'] = $phone;

        return $this;
    }

    public function getName(): string
    {
        return strval($this->getData('name'));
    }

    public function setName(string $name): Address
    {
        $this->_updatedData['name'] = $name;

        return $this;
    }

    public function getProvinceCode(): string
    {
        return strval($this->getData('province_code'));
    }

    public function setProvinceCode(string $provinceCode): Address
    {
        $this->_updatedData['province_code'] = $provinceCode;

        return $this;
    }

    public function getCountryCode(): string
    {
        return strval($this->getData('country_code'));
    }

    public function setCountryCode(string $countryCode): Address
    {
        $this->_updatedData['country_code'] = $countryCode;

        return $this;
    }

    public function isDefault(): bool
    {
        return boolval($this->getData('default'));
    }

    public function setDefault(): Address
    {
        $this->_updatedData['default'] = true;

        return $this;
    }

    public function save()
    {
        $isDefault = false;
        if (isset($this->_updatedData['default'])) {
            $isDefault = boolval($this->_updatedData['default']);
            unset($this->_updatedData['default']);
        }

        if (count($this->_updatedData) > 0) {
            if ($this->getId()) {
                $this->getProxy()->updateCustomerAddress(
                    $this->_customer->getId(), $this->getId(), $this->_updatedData
                );
            } else {
                $data = $this->getProxy()->createCustomerAddress(
                    $this->_customer->getId(), $this->_updatedData
                );
                $this->setRawData($data->customer_address);
            }
        }

        if ($isDefault) {
            $this->getProxy()->customerSetDefaultAddress(
                $this->_customer->getId(),
                $this->getId()
            );
        }

        $this->resetUpdatedData();

        return true;
    }
}