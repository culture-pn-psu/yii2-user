<?php
namespace anda\user\api;
/**
* 
*/
use Yii;
//use anda\user\UserModule;
use anda\user\models\User as UserModel;


class User
{
	public $userModule = '';

	private $user;

	public function __construct($config=[])
	{
		if(isset($config['moduleId'])){
			$this->userModule = Yii::$app->getModule($config['moduleId']);
		}
		$this->user = UserModel::findOne(Yii::$app->user->id);
		$view = Yii::$app->getView();
		\anda\user\assets\UserAsset::register($view);
	}

	public function userData()
	{
		$user = $this->user;
		
        return (object)[
            'id' => Yii::$app->user->id,
            'username' => Yii::$app->user->identity->username,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'firstname' => $user->profile->firstname,
            'lastname' => $user->profile->lastname,
            'fullname' => $user->profile->fullname,
            'avatar' => $user->profile->avatar,
            'cover' => $user->profile->cover,
            'bio' => $user->profile->bio,
            'data' => $user->profile->data,
            'roles' => Yii::$app->authManager->getRoles($user->id),
        ];
	}
	
	public function userInfo()
	{
		$userData = $this->userData();

		$user = $this->user;
		$userUploadPath = $this->userModule->userUploadDir.'/'.$user->id;

		$userData->firstname = $this->verifyValue($userData->firstname);
		$userData->lastname = $this->verifyValue($userData->lastname);
		$userData->fullname = $this->verifyValue($userData->fullname);
		$userData->avatar = $this->verifyImage($userUploadPath.'/avatar/'.$userData->avatar, 'default-avatar.jpg');
		$userData->cover = $this->verifyImage($userUploadPath.'/cover/'.$userData->cover, 'default-cover.jpg');
		$userData->bio = $this->verifyValue($userData->bio);
		$userData->data = $this->verifyValue($userData->data);
		$userData->roles = (count($userData->roles) > 0) ? $userData->roles : [(object)['name' => null]];

		return $userData;
	}

	private function path2url($file)
	{
		$url = Yii::$app->homeUrl;
		$url .= $this->userModule->userUploadUrl;
		$url .= str_replace(Yii::getAlias('@webroot/'), '', $file);
		return $url;
	}

	private function verifyValue($val)
	{
		return ($val === null) ? 'Not set' : $val;
	}

	private function verifyImage($val, $defaultImage = 'no-image.jpg')
	{
		$assetDir = Yii::$app->assetManager->getPublishedUrl('@anda/user/client');

		if(is_file($val)){
			return $this->path2url($val);
		}
		//return $this->path2url(dirname(dirname($val)).'/'.$defaultImage);
		return $assetDir.'/images/'.$defaultImage;
	}
}