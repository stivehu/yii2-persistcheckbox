<?php

/**
 * @link https://github.com/stivehu/yii2-persistcheckbox/
 * @license http://www.yiiframework.com/license/
 */

namespace stivehu\grid;

use Closure;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * PersistCheckBoxColumn create persistent checkbox
 *
 * @author Gábor István
 */
class PersistCheckBoxColumn extends CheckboxColumn
{

    /**
     * @var string
     *
     */
    public $cookieName = 'selected';

    public function init()
    {
        \Yii::$app->view->registerJs('var cookieName = "' . $this->cookieName . '"', \yii\web\View::POS_HEAD);
        Asserts::register($this->grid->getView());
        return parent::init();
    }

    /**
     * append the fragmented cookies
     * @param cookie root name
     * @return appended cookie
     */
    private function getBigCookie($cookieName)
    {
        $result = false;
        if (isset($_COOKIE[$cookieName])) {
            $result = $_COOKIE[$cookieName];
        }

        for ($i = 1; $i < 1000; $i++) {
            if (isset($_COOKIE[$cookieName . "---$i"])) {
                $result = $result . $_COOKIE[$cookieName . "---$i"];
            } else {
                break;
            }
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {

        if ($this->checkboxOptions instanceof Closure) {
            $options = call_user_func($this->checkboxOptions, $model, $key, $index, $this);
        } else {
            $options = $this->checkboxOptions;
            if (!isset($options['value'])) {
                $options['value'] = is_array($key) ? json_encode($key, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : $key;
            }
        }
        $checked = false;
        if ($selectedItem = \stivehu\rangecomp\Rangecomp::rangeDeCompress(Json::decode($this->getBigCookie($this->cookieName)))) {
            if (in_array($model->id, $selectedItem)) {
                $checked = true;
            }
        }
        return Html::checkbox($this->name, $checked, $options);
    }

    /**
     * No need summary cell
     * @return type null
     */
    public function renderPageSummaryCell()
    {
        return null;
    }

}
