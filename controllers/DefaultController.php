<?php

namespace anda\user\controllers;

use Yii;
use anda\user\components\Controller;
use anda\user\models\User;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
{
	public function actionError(){
		//$this->layout = 'main-error';
		$exception = Yii::$app->errorHandler->exception;

		if ($exception !== null) {
			$statusCode = $exception->statusCode;
			$name = $exception->getName();
			$message = $exception->getMessage();
			
			
			return $this->render('error', [
				'exception' => $exception,
				'statusCode' => $statusCode,
				'name' => $name,
				'message' => $message
			]);
		}
	}
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function errorColor($code)
    {
    	$errorColors = [
			'400' => 'yellow',
			'403' => 'red',
			'500' => 'red'
		];

		if(array_key_exists($code, $errorColors)){
			return $errorColors[$code];
		}

		return 'red';
    }
}
