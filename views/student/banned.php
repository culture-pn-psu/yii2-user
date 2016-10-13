<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel suPnPsu\user\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ผู้ที่ลงเบียน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='box box-info'>
    <div class='box-header'>
        <h3 class='box-title'><?= Html::encode($this->title) ?></h3>
    </div><!--box-header -->

    <div class='box-body pad'>

        <div class="table-responsive">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],                        
                   
                    
                    [
                        'attribute' => 'username',
                        'label' => 'รหัสนักศึกษา',
                        'format' => 'html',
                        'value' => function($model) {
                            return Html::a($model->username, ['check', 'id' => $model->id]);
                        }
                    ],
                    //'email:email',
                    [
                        'attribute' => 'profile.fullname',
                        'value' => 'profile.fullname',
                        'label' => 'ชื่อ - สกุล',
                    ],
                        [
                        'attribute' => 'profile.person.position_id',
                        'value' => 'profile.person.position.title',
                        'label' => 'ตำแหน่งในองค์การ',
                    ],
                        [
                        'attribute' => 'profile.person.faculty',
                        'value' => 'profile.person.faculty',
                        'label' => 'คณะ/หน่วยงาน',
                    ],
                        [
                        'attribute' => 'profile.person.major',
                        'value' => 'profile.person.major',
                        'label' => 'สาขา/ฝ่ายงาน',
                    ],         
                    // 'created_at',
                    // 'updated_at',
                    // ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
        </div>
        
        
    </div>
</div>
