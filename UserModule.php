<?php

namespace anda\user;

use Yii;
use yii\helpers\Url;
/**
 * user module definition class
 */
class UserModule extends \yii\base\Module
{
    public $userUploadDir = '@webroot';

    public $userUploadPath = 'uploads/user';

    public $userUploadUrl = '';

    public $admins = [];

    public $rbacUrl = ['/rbac'];

    public $userApi;

    public $modelMap = [];
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'anda\user\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        Yii::setAlias('anda/user','@vendor/andatech/yii2-user/');

        $this->layoutPath = '@anda/user/views/layouts';
        $this->layout = 'main';

        Yii::$app->user->loginUrl = ['/'.$this->id.'/auth/login'];

        $this->params();

        Yii::$app->mailer->viewPath = '@anda/user/mail';

        if(substr($this->userUploadDir, 0, 1) === '@'){
            $this->userUploadDir = Yii::getAlias($this->userUploadDir);
        }

        Yii::$app->errorHandler->errorAction = '/'.$this->id.'/default/error';

        //$userObj = new \anda\user\api\User();
        //$userObj->userModule = $this;
        /*if(!Yii::$app->user->isGuest){
            $user = User::findOne(Yii::$app->user->id);
            $this->userApi = (object)['data'=>$user->userData(), 'info'=>$user->userInfo()];
        }*/

        //print_r(Yii::$app->user);

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
