<?php

namespace culturePnPsu\user;

/**
 * user module definition class
 */

 use Yii;


class Module extends \yii\base\Module
{
    public $userUploadDir = '@webroot';

    public $userUploadPath = 'uploads/user';

    public $userUploadUrl = '';

    public $loginBy = 'db';

    public $ldapConfig = [
      'server' => ['dc2.psu.ac.th','dc7.psu.ac.th','dc1.psu.ac.th'],
      'basedn' => 'dc=psu,dc=ac,dc=th',
      'domain' => 'psu.ac.th'
    ];

    public $admins = [];

    public $rbacUrl = '#!';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'culturePnPsu\user\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Yii::setAlias('@culturePnPsu','@vendor/culture-pn-psu');
        $this->defaultRoute = 'settings/profile';
        //$this->layout = 'left-menu.php';
        
<<<<<<< HEAD
        $this->layoutPath = '@culturePnPsu/user/views/layouts';
        $this->layout = 'main';
=======
//        $this->layoutPath = '@culturePnPsu/user/views/layouts';
//        $this->layout = 'main';
>>>>>>> 4f99ce76add2d38b077bf459cb854e5e44611a09

        //Yii::$app->user->loginUrl = ['/'.$this->id.'/auth/login'];

        $this->params();

<<<<<<< HEAD
        Yii::$app->mailer->viewPath = '@culturePnPsu/user/mail';
=======
        //Yii::$app->mailer->viewPath = '@culturePnPsu/user/mail';
>>>>>>> 4f99ce76add2d38b077bf459cb854e5e44611a09

        if(substr($this->userUploadDir, 0, 1) === '@'){
            $this->userUploadDir = Yii::getAlias($this->userUploadDir);
        }

        $route = Yii::$app->urlManager->parseRequest(Yii::$app->request)[0];
        $arr = explode('/', $route);
        if(trim($arr[0]) === $this->id){
            Yii::$app->errorHandler->errorAction = '/'.$this->id.'/default/error';
        }

    }

    public function params()
    {
        if(substr($this->userUploadDir, 0, 1) === '@'){
            $userUploadDir = Yii::getAlias($this->userUploadDir);
        }
        Yii::$app->params['adminEmail'] = 'miragestudioth@gmail.com';
        Yii::$app->params['supportEmail'] = 'support@example.com';
        Yii::$app->params['user.passwordResetTokenExpire'] = 3600;
        Yii::$app->params['userUploadDir'] = $userUploadDir;
        Yii::$app->params['userUploadPath'] = $this->userUploadPath;
        Yii::$app->params['userUploadUrl'] = $this->userUploadUrl;
    }
}
