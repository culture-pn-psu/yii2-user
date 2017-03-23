<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\user\models\User */

$this->title = $model->profile->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-body">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>
        <div class="row">
            <div class="col-sm-6">
                <h3>Account</h3>


                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'username',
                        'auth_key',
                        'email:email',
                        'statusName',
                        'created_at:date',
                        'updated_at:date',
                    ],
                ])
                ?>
            </div>
            <div class="col-sm-6">

                <h3>Profile</h3>
                <?=
                DetailView::widget([
                    'model' => $model->profile,
                    'attributes' => [
                        'fullname',
                        //'lastname',
                        //'avatar',
                        //'cover',
                        'bio',
                        [
                            'label' => 'ตำแหน่ง',
                            'value'=> $model->person->position->title
                        ],
                        [
                            'label' => 'สาขา',
                            'value'=> $model->person->major
                        ],
                        [
                            'label' => 'คณะ',
                            'value'=> $model->person->faculty
                        ],
                        
                    ],
                ])
                ?>

            </div>
        </div>


    </div>
</div>
