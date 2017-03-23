<?php

namespace culturePnPsu\user\models;

use Yii;
use culturePnPsu\user\assets\CropImageUploadBehavior;
//use karpoff\icrop\CropImageUploadBehavior;
use yii\helpers\Html;
use \yii\helpers\StringHelper;
use culturePnPsu\user\models\User;

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
class Profile extends \yii\db\ActiveRecord {

    public $module = null;
    public $imageFile;

    public function init() {
        parent::init();

        if ($this->module === null)
            $this->module = Yii::$app->getModule('user');
        //$this->module = Yii::$app->controller->module;
    }

    /**
     * @inheritdoc
     */
    function behaviors() {
        if ($this->module === null)
            $this->module = Yii::$app->getModule('user');
        //$this->module = Yii::$app->controller->module;
        //$user_id = $this->user_id;
        $userUploads = [
            'path' => $this->module->userUploadDir . '/' . $this->module->userUploadPath . '/{extra_folder}',
            'url' => $this->module->userUploadUrl . '/' . $this->module->userUploadPath . '/{extra_folder}',
        ];
//        echo Yii::getAlias('@uploads');
//        print_r($userUploads);
//        exit();


        return [
                [
                'class' => CropImageUploadBehavior::className(),
                'attribute' => 'avatar',
                'attribute_folder' => 'user_id',
                'scenarios' => ['insert', 'update'],
                'path' => $userUploads['path'] . "/avatars",
                'url' => $userUploads['url'] . "/avatars",
                'ratio' => 1,
                'crop_field' => 'avatar_offset',
                'cropped_field' => 'avatar_cropped',
            ],
                [
                'class' => CropImageUploadBehavior::className(),
                'attribute' => 'cover',
                'attribute_folder' => 'user_id',
                'scenarios' => ['insert', 'update'],
                'path' => $userUploads['path'] . "/covers",
                'url' => $userUploads['url'] . "/covers",
                'ratio' => 5,
                'crop_field' => 'cover_offset',
                'cropped_field' => 'cover_cropped',
            ],
        ];
    }

    public static function tableName() {
        return 'user_profile';
    }

    public function rules() {
        return [
                [['user_id',], 'required'],
                [['user_id'], 'integer'],
                [['bio', 'data'], 'string'],
                [['login_by'], 'string', 'max' => 10],
                [['firstname', 'lastname', 'avatar_offset', 'avatar_cropped', 'cover_offset', 'cover_cropped'], 'string', 'max' => 255],
                [['avatar', 'cover'], 'file', 'extensions' => 'jpg, jpeg, gif, png', 'on' => ['insert', 'update', 'index']],
        ];
    }

    public function attributeLabels() {
        return [
            'user_id' => 'User ID',
            'firstname' => 'ชื่อ',
            'lastname' => 'นามสกุล',
            'avatar' => 'รูปประจำตัว',
            'cover' => 'รูปหน้าปก',
            'bio' => 'ประวัติ',
            'data' => 'ข้อมูลอื่นๆ',
            'login_by' => 'เข้าใช้ระบบด้วย',
            'fullname' => 'ชื่อ-นามสกุล'
        ];
    }

    public function getUser() {
        return $this->hasOne(\culturePnPsu\user\models\User::className(), ['id' => 'user_id']);
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            $dir = realpath(rtrim($this->module->userUploadDir, '/') . '/' . trim($this->module->userUploadPath, '/'));
            $items = [
                $dir . '/avatars/' . $this->avatar,
                $dir . '/avatars/' . $this->avatar_cropped,
                $dir . '/covers/' . $this->cover,
                $dir . '/covers/' . $this->cover_cropped
            ];
            foreach ($items as $item) {
                if (is_file($item)) {
                    unlink($item);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function getResultData($id = null) {
        if ($id !== null) {
            static::findOne($id);
        }

        $result = (object) [
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
<<<<<<< HEAD
                    // 'major' => $this->person ? $this->person->major : null,
                    // 'faculty' => $this->person ? $this->person->faculty : null,
                    // 'tel' => $this->person ? $this->person->tel : null,
                    // 'address' => $this->person ? $this->person->faculty : null,
=======
                    //'major' => $this->person ? $this->person->major : null,
                    //'faculty' => $this->person ? $this->person->faculty : null,
                    'tel' => $this->person ? $this->person->tel : null,
                    'address' => $this->person ? $this->person->address : null,
>>>>>>> 4f99ce76add2d38b077bf459cb854e5e44611a09
        ];

        return $result;
    }

    public function getResultInfo($id = null) {

        $data = $this->getResultData($id);

        $userUploadPath = $this->module->userUploadDir;
        $userUploadPath .= '/' . $this->module->userUploadPath;

        $data->firstname = $this->verifyValue($data->firstname);
        $data->lastname = $this->verifyValue($data->lastname);
        $data->fullname = $this->verifyValue($data->fullname);
        $data->avatar = $this->verifyImage($userUploadPath . '/' . $data->id . '/avatars/' . $data->avatar, 'default-avatar.jpg');
        $data->cover = $this->verifyImage($userUploadPath . '/' . $data->id . '/covers/' . $data->cover, 'default-cover.jpg');
        $data->bio = $this->verifyValue($data->bio);
        $data->data = $this->verifyValue($data->data);
        $roles = [];
        foreach ($data->roles as $key => $role) {
            $roles[$key] = ucfirst($role->description);
        }
        $data->roles = $roles;

        return $data;
    }

    private function verifyValue($val) {
        return ($val === null) ? 'Not set' : $val;
    }

    private function checkImgPsu($id) {

        $folder = substr($id, 0, 2);
        $external_link = 'http://intranet.pn.psu.ac.th/registry/student_photo/' . $folder . '/' . $id . '.jpg';
//        echo $external_link;
//        exit();
        if (@getimagesize($external_link)) {
            return $external_link;
        } else {
            return false;
        }
    }

    private function verifyImage($val, $defaultImage = 'no-image.jpg') {
        //return 'http://intranet.pn.psu.ac.th/registry/student_photo/56/5620610077.jpg';
//        if (@getimagesize($val)) {
//            return $val;
//        } 
        if (is_file($val)) {
            $file = realpath($val);
            $webPath = realpath($this->module->userUploadDir);
            $fileUrl = str_replace($webPath, '', $file);
            $fileUrl = str_replace('\\', '/', $fileUrl);
            $fileUrl = rtrim($this->module->userUploadUrl, '/') . '/' . ltrim($fileUrl, '/');
            return $fileUrl;
        } else {
            $asset = Yii::$app->assetManager;
            $assetUrl = $asset->getPublishedUrl('@culturePnPsu/user/client');
            $assetDir = Yii::getAlias('@webroot/assets/') . basename($assetUrl);
            if (!is_dir($assetDir)) {
                $asset->publish('@culturePnPsu/user/client');
            }
            return $assetUrl . '/images/' . $defaultImage;
        }
    }

    public function getFullName() {
        if ($this->firstname === null && $this->lastname === null) {
            return null;
        }
        return $this->firstname . ' ' . $this->lastname;
    }

    public static function updateProfile($id, $data) {
        //echo $id;
        //exit();

        if ($model = self::find()->where(['user_id' => $id])->one()) {
//            print_r($model);
//            exit();
            if ($model->load(['Profile' => $data])) {
                $model->save();
            }
        } else {
            $model = new self();
            if ($model->load(['Profile' => $data])) {
                $model->user_id = $id;
                $model->save();
            }
        }
    }

    public function getPerson() {
        return $this->hasOne(\culturePnPsu\user\models\Person::className(), ['user_id' => 'user_id']);
    }

    public function getStatusChange() {

        $str = '';
        $controller = Yii::$app->controller->id;
        if ($this->user->status == 1) {
            $str .= Html::a('อนุมัตเป็นสมาชิก', ['/user/' . $controller . '/change', 'id' => $this->user->id], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => 'ยืนยันการอนุมัติ?',
                            'method' => 'post',
                        ],
            ]);
            $str .= ' ';

            $str .= Html::a('ไม่อนุมัต', ['/user/' . $controller . '/change', 'id' => $this->user->id, 'banned' => '1'], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'ยืนยันที่จะไม่อนุมัติ?',
                            'method' => 'post',
                        ],
            ]);
        }







        return $str;
    }

    public function getWidget() {
        $state = StringHelper::truncate($this->person->major, 20) . ' ' . StringHelper::truncate($this->person->faculty, 20);
        $str = '<div class="user-block">
                <img class="img-circle" src="' . $this->resultInfo->avatar . '" alt="User Image">
                <span class="username"><a href="#">' . $this->fullname . '</a></span>
                <span class="description">' . $state . '</span>
              </div>';
        return $str;


//        $str = '<div class="widget-user-header">
//              <div class="widget-user-image">
//                <img class="img-circle" src="'.$this->avatar.'" alt="User Avatar">
//              </div>
//              <h3 class="widget-user-username">'.$this->fullname.'</h3>
//              <h5 class="widget-user-desc">'.$state.'</h5>
//            </div>';
//        return $str;
    }
    
    public function getFullnameImg() {
        $profile = $this->resultInfo;
        return Html::beginTag('div', ['class' => 'user-circle'])
                . Html::beginTag('div', ['class' => 'circle', 'style' => ''])
                . Html::img($profile->avatar, ['class' => '', 'style' => ''])
                . Html::endTag('div')
                . Html::beginTag('span', ['class' => 'username', 'style' => ''])
                . Html::a($this->fullname, ['#'])
                . Html::beginTag('span', ['class' => 'description'])
                //. $this->personPosition . ' ' . $this->personParent.'<br />'
                . (($this->person) ? ($this->person->tel ? 'เบอร์ติดต่อ ' . $this->person->tel : '') : '')
                . Html::endTag('span')
                . Html::endTag('span')
                . Html::endTag('div');
    }
    
    public static function getList(){
        return \yii\helpers\ArrayHelper::map(self::find()->all(),'user_id','fullname');
    }

}
