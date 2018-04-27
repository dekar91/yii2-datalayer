<?php

/**
 * @package Yii2-DataLayer
 * @author DekaR
 * @license MIT
 */

namespace dekar91\datalayer;

use yii\base\Component;
use yii\helpers\Html;
use yii\web\View;
use Yii;

class DataLayer extends Component implements \ArrayAccess
{
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    const EVENT_BEFORE_RENDER = self::class.'beforeRender';
    const EVENT_AFTER_RENDER = self::class.'afterRender';
    const EVENT_CHANGED = self::class.'changed';

    public $autoPublish = true;
    public $options = [];

    private $_observedObjects = [];
    public $observers = [];
    private $_defaultObservers =  ['ec' => DataLayerEc::class];

    private $_dataLayer = [];


    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->observers += $this->_defaultObservers;

        $view = Yii::$app->view;
        $jsOptions = json_encode($this->options);
        $assetBundle = DataLayerAsset::register($view);

        if($this->autoPublish)
            Yii::$app->view->on(View::EVENT_END_PAGE, [$this, 'renderEvent']);

        $view->registerJs("DataLayer.init({$jsOptions});");
    }

    public function offsetExists($offset)
    {
       return isset($this->_dataLayer[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->_dataLayer[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->_dataLayer[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->_dataLayer[$offset]);
    }

    public function  &getItem($key)
    {
        return $this->_dataLayer[$key];

    }

    /**
     * @param array $data
     * @param string |null $key
     */
    public function push(array $data, string $key = null) {
        if($key)
            $this->_dataLayer[$key] = isset($this->_dataLayer[$key])
                ? $this->_dataLayer[$key] + $data
                : $data;
        else
            array_push($this->_dataLayer, $data);

        $this->trigger(self::EVENT_CHANGED);
    }

    /**
     * @return string
     */
    private function _getJS()
    {
        return ' dataLayer = '.json_encode(array_values($this->_dataLayer), JSON_UNESCAPED_UNICODE).'; ';
    }

    public function renderEvent()
    {
        \Yii::$app->view->registerJs($this->_getJS(), View::POS_HEAD, 'dataLayer');
    }

    /**
     * @param bool $return
     * @return array
     */
    public function render($return = false) {

        if(!$return) {
            $this->trigger(self::EVENT_BEFORE_RENDER);

            echo Html::script($this->_getJS());

            $this->trigger(self::EVENT_AFTER_RENDER);

            return null;
        }
        else
            return [array_values($this->_dataLayer)];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->_getJS();
    }

    public function addEvent(string $eventName, array $customData)
    {
        $event = [
            'event' => $eventName
        ];

        if($customData)
            $event += $customData;

        $this->push($event);
    }

    public function __get($name)
    {
        if(in_array($name, array_keys($this->observers)))
        {
            if(empty($this->_observedObjects[$name]))
            {
                if(class_exists($this->observers[$name]))
                    $this->_observedObjects[$name] = new $this->observers[$name]($this);
            }

            return $this->_observedObjects[$name];
        }


        return parent::__get($name); // TODO: Change the autogenerated stub
    }

}