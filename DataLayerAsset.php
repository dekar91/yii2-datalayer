<?php


namespace dekar91\datalayer;


use yii\web\AssetBundle;

class DataLayerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/dekar91/yii2-datalayer';

    public $js = [
        'dataLayer.js',
    ];
}