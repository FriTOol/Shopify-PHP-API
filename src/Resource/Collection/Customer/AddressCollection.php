<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 07/11/2016
 * Time: 17:46
 */


namespace ShopifyApi\Resource\Collection\Customer;

use ShopifyApi\Resource\Collection\CollectionAbstract;
use ShopifyApi\Resource\Customer;
use ShopifyApi\Resource\Customer\Address;

class AddressCollection extends CollectionAbstract
{
    /**
     * @var Customer
     */
    private $_customer;

    protected function _convertData()
    {
        foreach ($this->getRawData() as $rawData) {
            $this->_collection[] = new Address($rawData, $this->getProxy());
        }
    }

    public function setCustomer(Customer $customer)
    {
        $this->_customer = $customer;
    }
}