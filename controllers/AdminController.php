<?php

namespace culturePnPsu\user\controllers;

use Yii;
use culturePnPsu\user\models\User;
use culturePnPsu\user\models\UserSearch;
use culturePnPsu\user\models\Profile;
use culturePnPsu\user\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use culturePnPsu\user\filters\AccessRule;
use culturePnPsu\user\models\UserSearchWaiting;
use culturePnPsu\user\models\Person;

/**
 * AdminController implements the CRUD actions for User model.
 */
class AdminController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
                    'change' => ['post'],
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
    public function actionIndex() {
        //print_r(Yii::$app->user->identity);
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionWaiting() {
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
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    public function actionCheck($id) {
        return $this->render('check', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $user = new User(['scenario' => 'create']);
        $profile = new Profile();
        $person = new Person();

        if ($user->load(Yii::$app->request->post())) {
            $user->setPassword(Yii::$app->request->post('User')['newPassword']);
            $user->generateAuthKey();
            $user->save();

            $person->load(Yii::$app->request->post());
            $person->save();
            
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($person->role);
            $info = $auth->assign($role, $user->id); 

            return $this->redirect(['view', 'id' => $user->id]);
            //print_r($user->attributes);
        } else {
            return $this->render('create', [
                        'user' => $user,
                        'profile' => $profile,
                        'person' => $person
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $user = $this->findModel($id);
        $profile = $user->profile;
        $person = $profile->person ? $profile->person : new Person();

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            $profile->load(Yii::$app->request->post());
            $profile->save();

            $person->load(Yii::$app->request->post());
            $person->save();
            
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($person->position->role);
            $auth->revokeAll($id);
            $info = $auth->assign($role, $id);            
            
            return $this->redirect(['view', 'id' => $user->id]);
        } else {
            return $this->render('update', [
                        'user' => $user,
                        'profile' => $user->profile,
                        'person' => $person
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
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
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    ###########################

    public function actionChange($id) {
        //echo $id;
        $user = $this->findModel($id);
        $user->status = 10;

        $auth = Yii::$app->authManager;
        $role = $auth->getRole('user');
        $info = $auth->assign($role, $id);
        if ($user->save() && $info) {
            return $this->goBack();
        }
    }

}
