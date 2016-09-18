<?php
namespace suPnPsu\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use suPnPsu\user\models\SignupForm;

use app\models\Profile;

class RegistController extends Controller
{

    public function actionIndex()
    {
        $this->redirect('signup');
    }

    public function actionSignup()
    {
        //$this->layout = 'main-blank';
        $model = new SignupForm(['scenario' => 'signup']);
        //$model->scenario = 'signup';
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
