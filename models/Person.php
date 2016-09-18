<?php

namespace suPnPsu\user\models;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property integer $user_id
 * @property integer $status
 * @property integer $position_id
 * @property integer $title_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $tel
 * @property string $address
 * @property string $major
 * @property string $faculty
 *
 * @property User $user
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'position_id', 'title_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'tel', 'address', 'major', 'faculty'], 'required'],
            [['user_id', 'status', 'position_id', 'title_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['tel'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 255],
            [['major', 'faculty'], 'string', 'max' => 200],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User Id'),
            'status' => Yii::t('app', 'Status'),
            'position_id' => Yii::t('app', 'Position'),
            'title_id' => Yii::t('app', 'Title'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
            'created_by' => Yii::t('app', 'Created by'),
            'updated_by' => Yii::t('app', 'Updated by'),
            'tel' => Yii::t('app', 'เบอร์โทรศัพท์'),
            'address' => Yii::t('app', 'ที่อยู่'),
            'major' => Yii::t('app', 'สาขา/ฝ่ายงาน'),
            'faculty' => Yii::t('app', 'คณะ/หน่วยงาน'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
