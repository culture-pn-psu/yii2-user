<?php

namespace anda\user\models;

use Yii;
use karpoff\icrop\CropImageUploadBehavior;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $avatar_offset
 * @property string $avatar_cropped
 * @property string $avatar
 * @property string $cover_offset
 * @property string $cover_cropped
 * @property string $cover
 * @property string $bio
 * @property string $data
 */
class Profile extends \yii\db\ActiveRecord
{

    public $module = null;

    public $imageFile;

    public function init()
    {
        parent::init();

        if($this->module === null)
            $this->module = Yii::$app->getModule('user');
            //$this->module = Yii::$app->controller->module;

    }
    /**
     * @inheritdoc
     */
    function behaviors()
    {
        if($this->module === null)
            $this->module = Yii::$app->getModule('user');
            //$this->module = Yii::$app->controller->module;
        $userUploads = [
            'path' => $this->module->userUploadDir.'/'.$this->module->userUploadPath,
            'url' => $this->module->userUploadUrl.'/'.$this->module->userUploadPath,
        ];
        return [
            [
                'class' => CropImageUploadBehavior::className(),
                'attribute' => 'avatar',
                'scenarios' => ['insert', 'update'],
                'path' => $userUploads['path'].'/avatars',
                'url' => $userUploads['url'].'/avatars',
                'ratio' => 1,
                'crop_field' => 'avatar_offset',
                'cropped_field' => 'avatar_cropped',
            ],
            [
                'class' => CropImageUploadBehavior::className(),
                'attribute' => 'cover',
                'scenarios' => ['insert', 'update'],
                'path' => $userUploads['path'].'/covers',
                'url' => $userUploads['url'].'/covers',
                'ratio' => 5,
                'crop_field' => 'cover_offset',
                'cropped_field' => 'cover_cropped',
            ],
        ];
    }

    public static function tableName()
    {
        return 'user_profile';
    }

    public function rules()
    {
        return [
            [['user_id',], 'required'],
            [['user_id'], 'integer'],
            [['bio', 'data'], 'string'],
            [['firstname', 'lastname', 'avatar_offset', 'avatar_cropped', 'cover_offset', 'cover_cropped'], 'string', 'max' => 255],
            [['avatar', 'cover'], 'file', 'extensions' => 'jpg, jpeg, gif, png', 'on' => ['insert', 'update']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'firstname' => 'ชื่อ',
            'lastname' => 'นามสกุล',
            'avatar' => 'รูปประจำตัว',
            'cover' => 'รูปหน้าปก',
            'bio' => 'ประวัติ',
            'data' => 'ข้อมูลอื่นๆ',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(\anda\user\models\User::className(), ['id' => 'user_id']);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $dir = realpath(rtrim($this->module->userUploadDir, '/').'/'.trim($this->module->userUploadPath, '/'));
            $items = [
                $dir.'/avatars/'.$this->avatar,
                $dir.'/avatars/'.$this->avatar_cropped,
                $dir.'/covers/'.$this->cover,
                $dir.'/covers/'.$this->cover_cropped
            ];
            foreach ($items as $item) {
                if(is_file($item)){
                    unlink($item);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function getResultData($id = null)
    {
        if($id !== null){
            static::findOne($id);
        }

        $result = (object)[
            'id' => $this->user_id,
            'username' => $this->user->username,
            'email' => $this->user->email,
            'created_at' => $this->user->created_at,
            'updated_at' => $this->user->updated_at,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'fullname' => $this->fullname,
            'avatar' => $this->avatar_cropped,
            'cover' => $this->cover_cropped,
            'bio' => $this->bio,
            'data' => $this->data,
            'roles' => Yii::$app->authManager->getRolesByUser($this->user_id),
        ];

        return $result;
    }

    public function getResultInfo($id = null)
    {

        $data = $this->getResultData($id);

        $userUploadPath = $this->module->userUploadDir;
        $userUploadPath .= '/'.$this->module->userUploadPath;

        $data->firstname = $this->verifyValue($data->firstname);
        $data->lastname = $this->verifyValue($data->lastname);
        $data->fullname = $this->verifyValue($data->fullname);
        $data->avatar = $this->verifyImage($userUploadPath.'/avatars/'.$data->avatar, 'default-avatar.jpg');
        $data->cover = $this->verifyImage($userUploadPath.'/covers/'.$data->cover, 'default-cover.jpg');
        $data->bio = $this->verifyValue($data->bio);
        $data->data = $this->verifyValue($data->data);
        $roles = [];
        foreach ($data->roles as $key => $role) {
            $roles[$key] = ucfirst($role->description);
        }
        $data->roles = $roles;

        return $data;
    }

    private function verifyValue($val)
    {
        return ($val === null) ? 'Not set' : $val;
    }

    private function verifyImage($val, $defaultImage = 'no-image.jpg')
    {
        if(is_file($val)){
            $file = realpath($val);
            $webPath = realpath($this->module->userUploadDir);
            $fileUrl = str_replace($webPath, '', $file);
            $fileUrl = str_replace('\\', '/', $fileUrl);
            $fileUrl = rtrim($this->module->userUploadUrl, '/').'/'.ltrim($fileUrl, '/');
            return $fileUrl;
        }else{
            $asset = Yii::$app->assetManager;
            $assetUrl = $asset->getPublishedUrl('@anda/user/client');
            $assetDir = Yii::getAlias('@webroot/assets/').basename($assetUrl);
            if(!is_dir($assetDir)){
                $asset->publish('@anda/user/client');
            }
            return $assetUrl.'/images/'.$defaultImage;
        }
    }


    public function getFullName() {
        if($this->firstname === null && $this->lastname === null){
            return null;
        }
        return $this->firstname . ' ' . $this->lastname;
    }
}
