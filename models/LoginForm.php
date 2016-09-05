<?php
namespace anda\user\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $ldap = Yii::$app->ldap;
            $ldap->server = ['dc2.psu.ac.th','dc7.psu.ac.th','dc1.psu.ac.th'];
            $ldap->basedn = 'dc=psu,dc=ac,dc=th';
            $ldap->domain = 'psu.ac.th';
            $ldap->username = $this->username;
            $ldap->password = $this->password;
            $authen = $ldap->Authenticate();
            if(!$user || !$authen['status']){
                $this->addError($attribute, 'Incorrect username or password.');
            }else{
                //Yii::$app->session['userInfo'] = $authen['info']; //Register Session
            }
        }
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    /*public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }*/

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            //$user = User::findOne(['username' => $this->username]);
            if (($user = User::findOne(['username' => $this->username])) !== null) {
                switch ($user->status) {
                    case User::STATUS_DELETED:
                        $this->addError('username', 'Your user is deactive.');
                        break;
                    case User::STATUS_WAITING:
                        $this->addError('username', 'Your user is not confirm.');
                        break;
                    case User::STATUS_BANNED:
                        $this->addError('username', 'Your user is banned.');
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
            
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
