<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model suPnPsu\user\models\User */

$this->title = $model->profile->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$profile = $model->profile->resultInfo;
?>
<div class="box">

    <div class="box-body">

        <div class="row">
            <div class="col-sm-3">
                <img src="<?= $profile->avatar ?>" class="img-thumbnail"  width="100%"/> 
            </div>
            <div class="col-sm-9">

                <h1><?= Html::encode($this->title) ?></h1>               
                
                <?=$model->profile->statusChange?>
                
                <h3>Account</h3>
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        'username',
                        //'auth_key',
                        'email:email',
                        'statusName',                            
                        'created_at:date',
                    //'updated_at:date',
                    ],
                ])
                ?>

                <h3>Profile</h3>
                <?=
                DetailView::widget([
                    'model' => $model->profile,
                    'attributes' => [
                        'fullname',
                        'bio',
                    ],
                ])
                ?>

            </div>
        </div>

    </div>
</div>
