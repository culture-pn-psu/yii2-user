<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user culturePnPsu\user\models\User */

$this->title = 'Update User: ' . $user->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->id, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'user' => $user,
        'profile' => $profile,
        'person' => $person
    ])
    ?>

</div>
