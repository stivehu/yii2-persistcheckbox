<?php

namespace stivehu\grid;

use Yii;
use yii\web\AssetBundle;

/**
 * Description of Assets
 *
 * @author stive
 */
class Asserts extends AssetBundle
{

    public $sourcePath = '@persistcheckbox/assets';
    public $js = [
        'jquery.enhanced.cookie.js',
        'persistcheckbox.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'stivehu\rangecomp\Asserts'
    ];

    public function init()
    {
        Yii::setAlias('@persistcheckbox', __DIR__);
        return parent::init();
    }

}
