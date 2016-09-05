<?php

namespace anda\user\controllers;

use Yii;
use anda\user\models\Profile;
//use anda\user\models\ProfileSearch;
use anda\user\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\UploadedFile;

/**
 * SettingsController implements the CRUD actions for Profile model.
 */
class SettingsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['ContentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'only' => [
                'cover',
                'avatar',
            ],
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->redirect(['profile']);
    }

    public function actionProfile()
    {
        $model = $this->findModel(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'You have successfully change your profile.');
            return $this->redirect(['profile']);
        } else {
            return $this->render('profile', [
                'model' => $model,
            ]);
        }
    }

    public function actionAccount()
    {
        $model = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'You have successfully change your account.');
            return $this->refresh();
            //return $this->redirect(['account']);
        } else {
            return $this->render('account', [
                'model' => $model,
            ]);
        }
    }

    public function actionChangePassword()
    {
        $model = Yii::$app->user->identity;
        $model->scenario = 'changePassword';
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->password = $model->newPassword;
            $model->save(false);

            Yii::$app->session->setFlash('success', 'You have successfully change your password.');

            return $this->refresh();
        }

        return $this->render('change-password', ['model'=>$model]);
    }

    public function actionCover()
    {
        $model = $this->findModel(Yii::$app->user->id);

        $result = [
            'process' => false,
            'message' => 'Change cover fail.',
        ];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $result = [
                'process' => true,
                'message' => 'Change cover successfully.',
            ];
        }

        return $result;
    }

    public function actionAvatar()
    {
        $model = $this->findModel(Yii::$app->user->id);

        $result = [
            'process' => false,
            'message' => 'Change avatar fail.',
        ];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $result = [
                'process' => true,
                'message' => 'Change avatar successfully.',
            ];
        }

        return $result;
    }

    

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
