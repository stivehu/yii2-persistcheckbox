<?php

/**
 * @link http://www.yiiframework.com/
 * @license http://www.yiiframework.com/license/
 */

namespace stivehu\grid;

use Closure;
use stivehu\enhancedcookie\EnhancedCookie;
use stivehu\rangecomp\Rangecomp;
use yii\base\InvalidValueException;
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

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        \Yii::$app->view->registerJs('var cookieName = "' . $this->cookieName . '"', \yii\web\View::POS_HEAD);
        Asserts::register($this->grid->getView());
        return parent::init();
    }

    /**
     * @param mixed $model
     * @param mixed $key
     * @param int $index
     * @return string
     */
    protected function renderDataCellContent($model, $key, $index): string
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

        try {
            $bigCookie = EnhancedCookie::getBigCookie($this->cookieName);
            if ((null !== $bigCookie) && ($selectedItem = Rangecomp::rangeDeCompress(Json::decode($bigCookie)))) {
                if (in_array($model->id, $selectedItem)) {
                    $checked = true;
                }
            }
        } catch (\yii\base\InvalidArgumentException $ex) {

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
