<?php
/**
 * User: Anatoly Skornyakov
 * Email: anatoly@skornyakov.net
 * Date: 27/10/2016
 * Time: 13:10
 */

namespace ShopifyApi\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\ClientException;

class Proxy
{
    const BASE_URL = 'https://%s/admin/';

    private $apiKey;

    private $apiSecret;

    private $storeUrl;

    private $domain;

    /**
     * @var Proxy
     */
    private static $instance = null;

    public function __construct(
        string $apiKey,
        string $apiSecret,
        string $storeUrl,
        string $domain,
        array $configs = []
    ) {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->storeUrl = $storeUrl;
        $this->domain = $domain;

        $configs['http_client']['base_uri'] = sprintf(
            self::BASE_URL,
            $this->storeUrl
        );

        $this->_httpClient = new Client($configs['http_client']);
        self::$instance = $this;
    }

    public static function getInstance(): Proxy
    {
        return self::$instance;
    }

    private function callApi(string $method, string $url, array $options = [])
    {
        $options['auth'] = [$this->apiKey, $this->apiSecret];
        //        try {
        $response = $this->_httpClient->request($method, $url, $options);
        //        } catch (ClientException $exception) {
        //            $data = json_decode($exception->getResponse()->getBody()->getContents());
        //            switch (intval($data->response->code)) {
        //                case 404: throw new NotFoundException($data->response->errors->error[0], 404, $exception);
        //                case 505: throw new InternalServerErrorException($data->response->errors->error[0], 500, $exception);
        //            }
        //            throw $exception;
        //        }
        $data = \json_decode($response->getBody()->getContents());

        return $data;
    }

    public function getApi(string $url, array $query = [], array $options = [])
    {
        $options['query'] = $query;

        return $this->callApi('get', $url, $options);
    }

    public function putApi(string $url, array $formParams = [])
    {
        return $this->callApi('put', $url, ['form_params' => $formParams]);
    }

    public function postApi(string $url, array $formParams = [])
    {
        return $this->callApi('post', $url, ['json' => $formParams]);
    }

    public function delApi(string $url, array $formParams = [])
    {
        return $this->callApi('delete', $url, ['form_params' => $formParams]);
    }

    public function getCustomers(array $params = [])
    {
        return $this->getApi('customers.json', $params);
    }

    public function getCustomersBySavedSearch(int $id, array $params = [])
    {
        return $this->getApi(
            sprintf(
                '/admin/customer_saved_searches/%d/customers.json',
                $id
                ),
            $params
        );
    }

    public function getCustomer(int $id)
    {
        return $this->getApi(sprintf('customers/%d.json', $id));
    }

    public function findCustomers(array $params = [])
    {
        return $this->getApi('customers/search.json', $params);
    }

    public function updateCustomer($id, $data)
    {
        return $this->putApi(
            sprintf('customers/%d.json', $id),
            ['customer' => $data]
        );
    }

    public function createCustomer($data)
    {
        return $this->postApi('customers.json', ['customer' => $data]);
    }

    public function deleteCustomer(int $id)
    {
        return $this->delApi(sprintf('customers/%d.json', $id));
    }

    public function customerSetDefaultAddress(int $customerId, int $addressId)
    {
        return $this->putApi(
            sprintf(
                'customers/%d/addresses/%d/default.json',
                $customerId,
                $addressId
            )
        );
    }

    public function createCustomerAddress(int $customerId, $data)
    {
        return $this->postApi(
            sprintf('customers/%d/addresses.json', $customerId),
            ['address' => $data]
        );
    }

    public function updateCustomerAddress(
        int $customerId,
        int $addressId,
        $data
    ) {
        return $this->putApi(
            sprintf('customers/%d/addresses/%d.json', $customerId, $addressId),
            ['address' => $data]
        );
    }

    public function createCustomerMetafield(int $customerId, array $data)
    {
        return $this->postApi(
            sprintf('customers/%d/metafields.json', $customerId),
            ['metafield' => $data]
        );
    }

    public function getProducts(array $params = [])
    {
        return $this->getApi('products.json', $params);
    }

    public function getProduct(int $productId)
    {
        return $this->getApi(
            sprintf(
                'products/%d.json',
                $productId
            )
        );
    }

    public function getProductMetafields(int $productId)
    {
        return $this->getApi(
            sprintf('products/%d/metafields.json', $productId)
        );
    }

    public function removeProductMetafield(int $productId, int $metafieldId)
    {
        return $this->delApi(
            sprintf(
                'products/%d/metafields/%d.json',
                $productId,
                $metafieldId
            )
        );
    }

    public function addProductMetafield(int $productId, array $data)
    {
        return $this->postApi(
            sprintf('products/%d/metafields.json', $productId),
            ['metafield' => $data]
        );
    }

    public function saveProductMetafield(
        int $productId,
        int $metafieldId,
        array $data
    ) {
        return $this->putApi(
            sprintf('products/%d/metafields/%d.json', $productId, $metafieldId),
            ['metafield' => $data]
        );
    }

    public function getProductImages(int $productId)
    {
        return $this->getApi(sprintf('products/%d/images.json', $productId));
    }

    public function getProductImage(int $productId, int $imagesId)
    {
        return $this->getApi(
            sprintf(
                'products/%d/images/%s.json',
                $productId,
                $imagesId
            )
        );
    }

    public function getCartByToken(string $token)
    {
        return $this->getApi(sprintf('carts/%s.json', $token));
    }

    public function getShippingRates($cartId, $shippingAddress)
    {
        $options = [
            'cookies' => CookieJar::fromArray(
                ['cart' => $cartId],
                $this->domain
            ),
        ];

        return $this->getApi(
            '/cart/shipping_rates.js',
            ['shipping_address' => $shippingAddress],
            $options
        );
    }

    public function createOrder($order)
    {
        return $this->postApi('/admin/orders.json', ['order' => $order]);
    }

    public function createDraftOrder(array $draftOrder)
    {
        return $this->postApi('/admin/draft_orders.json', ['draft_order' => $draftOrder]);
    }

    public function draftOrderSendInvoice(int $draftOrderId, array $data = [])
    {
        return $this->postApi(
            sprintf('/admin/draft_orders/%d/send_invoice.json', $draftOrderId),
                ['draft_order_invoice' => $data]
        );
    }

    public function getOrders(array $params = [])
    {
        return $this->getApi('/admin/orders.json', $params);
    }

    public function getShippingZones()
    {
        return $this->getApi('/admin/shipping_zones.json');
    }

    public function getCountries()
    {
        return $this->getApi('/admin/countries.json');
    }

    public function getCollect(array $params)
    {
        return $this->getApi('/admin/collects.json', $params);
    }

    public function getPriceRules(array $params)
    {
        return $this->getApi('/admin/price_rules.json', $params);
    }

    public function getDiscountCodes(int $priceRuleId, array $params)
    {
        return $this->getApi(
            sprintf('/admin/price_rules/%d/discount_codes.json', $priceRuleId),
                $params
        );
    }
}