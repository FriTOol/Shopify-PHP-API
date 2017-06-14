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
use ShopifyApi\Resource\Cart;
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
        string $domain,
        string $webhookSecret = '',
        array $configs = []
    ) {
        $configs = array_merge($this->_defaultConfigs, $configs);
        $this->_proxy = new Proxy($apiKey, $apiSecret, $storeUrl, $domain, $configs);
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

    public function getCustomersBySavedSearch(int $id, array $params = [])
    {
        return new CustomerCollection(
            $this->getProxy()->getCustomersBySavedSearch($id, $params)->customers,
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
        if (!$request->hasHeader('x-shopify-hmac-sha256')) {
            return false;
        }

        $calculatedHmac = base64_encode(hash_hmac(
            'sha256',
            $request->getBody()->getContents(),
            $this->_webhookSecret,
            true
        ));

        return ($request->getHeaderLine('x-shopify-hmac-sha256') == $calculatedHmac);
    }

    public function getCartByToken(string $token): Cart
    {
        return new Cart(
            $this->getProxy()->getCartByToken($token)->cart,
            $this->getProxy()
        );
    }

    public function createOrder(array $data)
    {
        return $this->getProxy()->createOrder($data);
    }

    public function createDraftOrder(array $data)
    {
        return $this->getProxy()->createDraftOrder($data)->draft_order;
    }

    public function draftOrderSendInvoice(int $draftOrderId, array $data = [])
    {
        return $this->getProxy()->draftOrderSendInvoice($draftOrderId, $data);
    }

    public function getOrders(array $params = []): array
    {
        $result = $this->getProxy()->getOrders($params);

        return $result->orders ?? [];
    }

    public function getShippingZones()
    {
        return $this->getProxy()->getShippingZones()->shipping_zones;
    }

    public function getShippingRates(string $cartToken, array $address)
    {
        $result = $this->getProxy()->getShippingRates($cartToken, $address);

        return $result->shipping_rates ?? [];
    }

    public function getCollect(int $id, array $params = []): array
    {
        $params['collection_id'] = $id;
        $result = $this->getProxy()->getCollect($params);

        return $result->collects ?? [];
    }

    public function getDiscountCodes(int $priceRuleId, array $params = []): array
    {
        $result = $this->getProxy()->getDiscountCodes($priceRuleId, $params);

        return $result->discount_codes ?? [];
    }

    public function getPriceRules(array $params = []): array
    {
        $result = $this->getProxy()->getPriceRules($params);

        return $result->price_rules ?? [];
    }

    public function getCustomCollections(array $params = []): array
    {
        $result = $this->getProxy()->getCustomCollections($params);

        return $result->custom_collections ?? [];
    }
}