<?php

/**
 * @link http://www.yiiframework.com/
 * @license http://www.yiiframework.com/license/
 */

namespace stivehu\grid;

use Closure;
use stivehu\enhancedcookie\EnhancedCookie;
use stivehu\rangecomp\Rangecomp;
use Yii;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

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
        Yii::$app->view->registerJs('var cookieName = "' . $this->cookieName . '"', View::POS_HEAD);
        Asserts::register($this->grid->getView());
        return parent::init();
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
        if ($selectedItem = Rangecomp::rangeDeCompress(Json::decode(EnhancedCookie::getBigCookie($this->cookieName)))) {
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
