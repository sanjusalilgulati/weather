<?php

namespace devleaks\weather;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\base\Widget;
use Yii;

/**
 * Weather js+css app from http://codepen.io/Enzo_Eghermanne/details/NPByRG
 */

/**
 * Asset Widget based to load Packery JavaScript library {@link http://packery.metafizzy.co)
 * @package devleaks\metafizzy
 *
 * @author Pierre M <devleaks.be@gmail.com>
 */
class Weather extends Widget {
    /**
     * @var array the HTML attributes for the div tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array Plugin options
     */
    public $pluginOptions = [];

    /**
     * Initializes the object.
     * This method is invoked at the end of the constructor after the object is initialized with the
     * given configuration.
     */
    public function init()
    {
        //checks for the element id
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        parent::init();
    }

    /**
     * Render chosen select
     * @return string|void
     */
    public function run()
    {
        $this->registerAssets();
    }

    /**
     * Register client assets
     */
    protected function registerAssets()
    {
        $view = $this->getView();
        WeatherAsset::register($view);
		if(!isset($this->pluginOptions['imgPath'])) {
			$images = WeatherImageAsset::register($view);
			$this->pluginOptions['imgPath'] = $images->baseUrl.'/images/';
		}
        $js = '$("#' . $this->options['id'] . '").weatherWidget(' . $this->getPluginOptions() . ');';
        $view->registerJs($js, $view::POS_END);
    }

    /**
     * Return plugin options in json format
     * @return string
     */
    public function getPluginOptions()
    {
        return Json::encode($this->pluginOptions);
    }
}