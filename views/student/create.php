<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model culturePnPsu\user\models\User */

$this->title = 'สร้างผู้ใช้';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <?= $this->render('_form', [
        'user' => $user,
        'profile' => $profile,
        'person' => $person
    ]) ?>
</div>
