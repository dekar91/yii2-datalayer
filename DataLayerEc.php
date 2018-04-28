<?php


namespace dekar91\datalayer;


use yii\base\Component;

class DataLayerEc extends Component
{
    const ROOT_KEY = 'ecommerce';
    /**
     * @var DataLayer|null
     */
    private static $_dataLayer = null;

    public function __construct(DataLayer $dataLayer)
    {

        self::$_dataLayer = $dataLayer;

        $this::$_dataLayer->push([], self::ROOT_KEY);
    }

    private function &getRoot()
    {
        return $this::$_dataLayer->getItem(self::ROOT_KEY)[self::ROOT_KEY];
    }

    public function currencyCode(string $currencyCode)
    {
        $this->getRoot()['currencyCode'] = mb_strtoupper($currencyCode);
    }

    public function addProductImpression(array $product)
    {
        $root =  &$this->getRoot();
        if (!isset($root['promoView'], $root['promoView']['promotions']))
            $root['promoView'] = ['promotions' => []];

            array_push($root['promoView']['promotions'], [$product]);
    }

    public function addPromoClick(array $product, array $action = [])
    {
        $this->pushEcAction('promoClick', ['promotions' => $product], 'promotionClick', $action);
    }

    public function addPromoImpression(array $product)
    {

        if (!isset($this->getRoot()['impressions']))
            $this->getRoot()['impressions'] = [];

        array_push($this->getRoot()['impressions'], $product);

    }

    private function pushEcAction(string $ecAction, array $items, string $event = null, array $userAction = [])
    {
        $ecItem = [
            self::ROOT_KEY => [
                $ecAction => $items
            ]
        ];

        if ($userAction)
            $ecItem[self::ROOT_KEY][$ecAction]['action'] = $userAction;

        if ($event)
            $ecItem['event'] = $event;

        return $this::$_dataLayer->push($ecItem, $ecAction . $event);

    }

    public function addProductClick(array $product, array $action = [])
    {
        $this->pushEcAction('click', ['products' => $product], 'productClick', $action);
    }

    public function addProductDetails(array $product, array $action = [])
    {
        $this->pushEcAction('details', ['products' => $product], null, $action);
    }

    public function addToCart(array $product)
    {
        $this->pushEcAction('add', ['products' => $product], 'addToCart');
    }

    public function removeFromCart(array $product)
    {
        $this->pushEcAction('remove', ['products' => $product], 'removeFromCart');
    }

    public function checkout(array $product, array $action = [])
    {
        $this->pushEcAction('checkout', ['products' => $product], 'checkout', $action);
    }

    public function checkoutOption($step, $checkoutOption)
    {
        $this->pushEcAction('checkout_option', ['step' => $step, 'option' => $checkoutOption], 'checkoutOption');
    }

    public function purchase(array $purchase, array $products)
    {
        $this->getRoot()['purchase'] =
            [
                'actionField' => $purchase,
                'products' => $products
            ];
    }

    public function refund(array $transactionId, array $products = [])
    {
        $refund = [
            'actionField' => ['id' => $transactionId]
        ];

        if ($products)
            $refund['products'] = $products;

        $this->getRoot()['refund'] = $refund;

    }


}