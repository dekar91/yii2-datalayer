<?php

error_reporting(E_ALL);

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');
defined('VENDOR_DIR') or define('VENDOR_DIR', __DIR__ . implode(DIRECTORY_SEPARATOR, ['', '..', 'vendor']));

Yii::setAlias('@tests', __DIR__);
Yii::setAlias('@vendor', VENDOR_DIR);
Yii::setAlias('@data', __DIR__ . DIRECTORY_SEPARATOR . '_data');

Yii::setAlias('@webroot/assets', '@tests/_output');
Yii::setAlias('@web/assets', '@tests/_output');
Yii::setAlias('@vendor/yiimaker/yii2-social-share/src/assets/src', '@tests/../src/assets/src');
