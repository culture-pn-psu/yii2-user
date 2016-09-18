<?php

namespace suPnPsu\user\controllers;

use Yii;
use suPnPsu\user\models\User;
use suPnPsu\user\models\UserSearch;
use suPnPsu\user\models\Profile;
use suPnPsu\user\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use suPnPsu\user\filters\AccessRule;
use suPnPsu\user\models\UserSearchWaiting;

/**
 * AdminController implements the CRUD actions for User model.
 */
class AdminController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        //'actions' => ['index'],
                        'allow' => true,
                        'roles' => $this->module->admins,
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
    }
    
    public function actions() {
        $this->layout = 'left-menu-admin';
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        //print_r(Yii::$app->user->identity);
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionWaiting()
    {
        //print_r(Yii::$app->user->identity);
        $searchModel = new UserSearchWaiting();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('waiting', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $user = new User(['scenario' => 'create']);
        $profile = new Profile();

        if ($user->load(Yii::$app->request->post())) {
            $user->setPassword(Yii::$app->request->post('User')['newPassword']);
            $user->generateAuthKey();
            $user->save();
            return $this->redirect(['view', 'id' => $user->id]);
            //print_r($user->attributes);
        } else {
            return $this->render('create', [
                'user' => $user,
                'profile' => $profile,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        $profile = $user->profile;

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            $profile->load(Yii::$app->request->post());
            $profile->save();
            return $this->redirect(['view', 'id' => $user->id]);
        } else {
            return $this->render('update', [
                'user' => $user,
                'profile' => $user->profile
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
