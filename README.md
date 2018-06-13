[![Latest Stable Version](https://poser.pugx.org/dekar91/yii2-datalayer/v/stable)](https://packagist.org/packages/dekar91/yii2-datalayer)
[![License](https://poser.pugx.org/dekar91/yii2-datalayer/license)](https://packagist.org/packages/dekar91/yii2-datalayer)
[![Total Downloads](https://poser.pugx.org/dekar91/yii2-datalayer/downloads)](https://packagist.org/packages/dekar91/yii2-datalayer)
[![Build Status](https://travis-ci.org/dekar91/yii2-datalayer.svg?branch=master)](https://travis-ci.org/dekar91/yii2-datalayer)


# Yii2 DataLayer helper

This extension is managed to help you fulfill dataLayer variable with initial data on fly.
Some Google enhanced e-commerce features are also available.

## Installation
* The minimum required PHP version is PHP 7.1,
* [Yii2](https://www.yiiframework.com/) is required.
### Using composer
Add following line in your require section:
```
"dekar91/yii2-datalayer": "@stable"

```
Then, register the component in your application config:
```
        'dataLayer' => [
            'class' => 'dekar91\datalayer\DataLayer'
        ],
```


## Configuration
Plugin involves both PHP and JavaScript functionality. PHP component supports following parameters:

| Parameter  | Default | Description |
| ------------- | ------------- | ------------- |
| autoPublish  | true | Whether catch EVENT_END_PAGE event in order to render DataLayer. If false you should render datalayer by yourself though getJs or render method  |
| observers  | ['ec' => ['class' => DataLayerEc::class]] |Array of classes may be used like wrapper on datalayer accessible by key each element must be following format: 'key' => ['class' => {name of class to be loaded}, 'options' => {Additional options}.   |
| customEvents  | [] | Array of event must be handled by JavaScript.Format: ['jsSelector' => 'nameOfEvent', 'customEventData'] |

Configuration example:
```
        'dataLayer' => [
            'class' => 'dekar91\datalayer\DataLayer',
            'options' => [
                'autoPublish' => true,
                'observers' => ['ec' => ['class' => DataLayerEc::class]],
                'customEvents' => [
                    ['.btn-checkout', 'click' , ['event' => 'checkoutEvent']],
                    ]
                ]
        ],
```

with this configuration you DataLayer will be published, DataLayerEc can be used by Yii::app()-> dalaLayer->ec,
click on .btn-checkout will be handled and event information will be pushed in dataLayer.

## Usage
### Basic usage
You can push in dataLayer before rendering though **Yii::app()-> dalaLayer->push();**

#### Methods
| Method  | Description |
| ------------- | ------------- |
| render($return = false) | Render or return dataLayer Js variable |
| push(array $data, string $key = null) | push data to dataLayer with corresponding key. |
| &getItem($key) | return element of dataLayer by link |

### Enhanced e-commerce
Some basic functions of [Enhanced e-commerce](https://developers.google.com/analytics/devguides/collection/analyticsjs/enhanced-ecommerce) are supported by default class DataLayerEc.
 Please look though google documentation for further details.
 
**Be careful!** Do not push data in ajax request, it will not take effect.

#### Methods:
| Method  |
| ------------- |
|currencyCode(string $currencyCode)|
|addProductImpression(array $product)|
|addPromoClick(array $product, array $action = [])|
|addPromoImpression(array $product)|
|addProductClick(array $product, array $action = [])|
|addProductDetails(array $product, array $action = [])|
|addToCart(array $product)|
|removeFromCart(array $product)|
|checkout(array $product, array $action = [])|
|checkoutOption($step, $checkoutOption)|
|purchase(array $purchase, array $products)|
|refund(array $transactionId, array $products = [])|



### User-defined observers
It's possible to extend dataLayer functionality by custom classes. While class is registered though observers property it can be used by Yii::app()->dataLayer->customClass. DataLayer object will be passed as first parameter in constructor.
