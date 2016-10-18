<?php

namespace culturePnPsu\user\components;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Description of navigate
 *
 * @author madone
 */
class AdminNavigate extends \firdows\menu\models\Navigate {

    public function getCount($router) {
        $count = '';
        $module = Url::base() . '/' . Yii::$app->controller->module->id.'/'.Yii::$app->controller->id;

        switch ($router) {            

            case "{$module}/index":
                $searchModel = new \culturePnPsu\user\models\UserSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $count = $dataProvider->getCount();
                $count = $count ? Html::tag('b', ' (' . $count . ')') : '';
                break;


            //case "{$module}/admin":
            case "{$module}/waiting":
                $searchModel = new \culturePnPsu\user\models\UserSearchWaiting();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $count = $dataProvider->getCount();
                $count = $count ? '<small class="label bg-yellow pull-right">' . $count . '</small>' : '';
                break;
            
            case "{$module}/banned":
                $searchModel = new \culturePnPsu\user\models\UserSearchBanned();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $count = $dataProvider->getCount();
                $count = $count ? Html::tag('b', ' (' . $count . ')') : '';
                break;
        }
        //$this->count = $count;
        return $count;
    }

}
