<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model culturePnPsu\user\models\Profile */

$this->title = 'Update Profile: ' . $model->resultInfo->fullname;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Settings',];
$this->params['breadcrumbs'][] = 'Profile';
?>
<div class="profile-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
