<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 27/10/2016
 * Time: 13:05
 */

namespace ShopifyApi;

use Psr\Http\Message\RequestInterface;
use ShopifyApi\Core\Proxy;
use ShopifyApi\Resource\Collection\CustomerCollection;
use ShopifyApi\Resource\Collection\ProductCollection;
use ShopifyApi\Resource\Customer;
use ShopifyApi\Resource\Product;

class ShopifyApi
{
    /**
     * @var Proxy
     */
    private $_proxy;

    private $_defaultConfigs = [
        'http_client' => [
            'timeout' => 5,
            'allow_redirects' => true,
        ]
    ];

    /**
     * @var string
     */
    private $_webhookSecret;

    public function __construct(
        string $apiKey,
        string $apiSecret,
        string $storeUrl,
        string $webhookSecret = '',
        array $configs = []
    ) {
        $configs = array_merge($this->_defaultConfigs, $configs);
        $this->_proxy = new Proxy($apiKey, $apiSecret, $storeUrl, $configs);
        $this->_webhookSecret = $webhookSecret;
    }

    public function getProxy(): Proxy
    {
        return $this->_proxy;
    }

    public function getCustomers(array $params = [])
    {
        return new CustomerCollection(
            $this->getProxy()->getCustomers($params)->customers,
            $this->getProxy()
        );
    }

    public function getCustomer(int $id): Customer
    {
        return new Customer($this->getProxy()->getCustomer($id)->customer, $this->getProxy());
    }

    public function updateCustomer(int $id, array $data)
    {
        return $this->getProxy()->updateCustomer($id, $data);
    }

    public function findCustomersByEmail(string $email)
    {
        $params = [
            'query' => 'email:' . $email
        ];

        return new CustomerCollection($this->getProxy()->findCustomers($params)->customers, $this->getProxy());
    }

    public function getProducts(array $params = []): ProductCollection
    {
        return new ProductCollection(
            $this->getProxy()->getProducts($params)->products,
            $this->getProxy()
        );
    }

    public function getProduct(int $productId): Product
    {
        return new Product(
            $this->getProxy()->getProduct($productId)->product,
            $this->getProxy()
        );
    }

    public function verifyWebhook(RequestInterface $request): bool
    {
        if (!$request->hasHeader('HTTP_X_SHOPIFY_HMAC_SHA256')) {
            return false;
        }

        $calculatedHmac = base64_encode(hash_hmac(
            'sha256',
            $request->getBody()->getContents(),
            $this->_webhookSecret,
            true
        ));

        return ($request->getHeader('HTTP_X_SHOPIFY_HMAC_SHA256') == $calculatedHmac);
    }
}