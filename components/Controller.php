<?php
namespace suPnPsu\user\components;

use Yii;
use suPnPsu\user\models\User;

class Controller extends \yii\web\Controller
{
	//public $userApi;

	public function beforeAction($action)
	{
		if(!parent::beforeAction($action))
			return false;

		if(Yii::$app->user->isGuest){
			Yii::$app->user->setReturnUrl(Yii::$app->request->url);
			Yii::$app->getResponse()->redirect(['/'.$this->module->id.'/auth/login'])->send();
			return false;
		}
		else{
			//$this->userApi = User::getUserApi();
			return true;
		}
	}
}
