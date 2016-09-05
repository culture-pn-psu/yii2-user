<?php
namespace anda\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use anda\user\models\SignupForm;

use app\models\Profile;

class RegistController extends Controller
{
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        //'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/

    public function actionIndex()
    {
        $this->redirect('signup');
    }

    public function actionSignup()
    {
        $this->layout = 'main-blank';
        $model = new SignupForm(['scenario' => 'signup']);
        //$model->scenario = 'signup';
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                /*if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }*/
                return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
