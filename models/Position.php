<?php

namespace culturePnPsu\user\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "position".
 *
 * @property integer $id
 * @property string $title
 * @property integer $parent_id
 */
class Position extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['role'], 'string', 'max' => 64],
            [['title'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'ตำแหน่ง'),
            'role' => Yii::t('app', 'บทบาท'),
            'parent_id' => Yii::t('app', 'ภายใต้ตำแหน่ง'),
        ];
    }
    
    
    public static function getList(){
        return ArrayHelper::map(self::find()->all(),'id','title');
        
    }
}
