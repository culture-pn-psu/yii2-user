<?php

namespace culturePnPsu\user\models;

use culturePnPsu\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $username;
    public $email;
    public $password;
    public $passwordConfirm;
    public $acceptLicence = false;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                ['username', 'filter', 'filter' => 'trim'],
                ['username', 'required'],
                ['username', 'unique', 'targetClass' => '\culturePnPsu\user\models\User', 'message' => 'ชื่อผู้ใช้นี้ได้อยู่ในระบบแล้ว'],
                ['username', 'string', 'min' => 2, 'max' => 255],
                ['email', 'filter', 'filter' => 'trim'],
            //['email', 'required'],
            ['email', 'email'],
                ['email', 'string', 'max' => 255],
                ['email', 'unique', 'targetClass' => '\culturePnPsu\user\models\User', 'message' => 'อีเมลล์นี้มีการใช้งานแล้ว'],
                [['password',], 'required'],
                [['password', 'passwordConfirm'], 'string', 'min' => 6],
            //[['passwordConfirm',], 'required', 'on' => 'signup'],
            //['passwordConfirm', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            ['acceptLicence', 'boolean'],
                ['acceptLicence', 'required'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup() {
        if (!$this->validate() || !$this->acceptLicence) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }

    public function checkPsuPassport() {

        if (@function_exists('ldap_connect')) {
            $ldap = new \culturePnPsu\user\components\Ldap();
            /* $ldap->server = ['dc2.psu.ac.th','dc7.psu.ac.th','dc1.psu.ac.th'];
              $ldap->basedn = 'dc=psu,dc=ac,dc=th';
              $ldap->domain = 'psu.ac.th'; */
            $ldap->server = $this->module->ldapConfig['server'];
            $ldap->basedn = $this->module->ldapConfig['basedn'];
            $ldap->domain = $this->module->ldapConfig['domain'];
            $ldap->username = $this->username;
            $ldap->password = $this->password;
            $authen = $ldap->Authenticate();
            if (!$authen['status']) {
                $this->addError('password', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง.');
            }
        } else {
            $soap = new \culturePnPsu\user\components\Soap();
            $soap->username = $this->username;
            $soap->password = $this->password;
            $authen = $soap->Authenticate();

            if (!$authen['status']) {
                $this->addError('password', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง.');
            }
        }
        return $authen;
    }

}
