<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 27/10/2016
 * Time: 18:16
 */

namespace ShopifyApi;

use ShopifyApi\Core\Proxy;

trait ProxyTrait
{
    /**
     * @var Proxy
     */
    protected $_proxy;
    /**
     * @return Proxy
     */
    public function getProxy(): Proxy
    {
        return $this->_proxy;
    }
    /**
     * @param Proxy $proxy
     */
    public function setProxy(Proxy $proxy)
    {
        $this->_proxy = $proxy;
    }
}