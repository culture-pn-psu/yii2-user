<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<div class="error-page">
    <h2 class="headline text-<?= $this->context->errorColor($statusCode); ?>"><?= $statusCode; ?></h2>

    <div class="error-content">
        <h3>
            <i class="fa fa-warning text-<?= $this->context->errorColor($statusCode); ?>"></i> <?= Html::encode($this->title) ?>
        </h3>

        <h4>
            <?= nl2br(Html::encode($message)) ?>
        </h4>

        <p>
            The above error occurred while the Web server was processing your request.
        </p>
        <p>
            Please contact us if you think this is a server error. Thank you.
        </p>
    </div>
</div>
