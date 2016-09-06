<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
$this->params['bodyClass'] = 'hold-transition login-page';
?>
<?php /*
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please choose your new password:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
*/?>


<div class="login-box">
    <div class="login-logo">
        <b>Reset</b> PASSWORD
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Please choose your new password</p>

        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

        <?= $form->field($model, 'password',[
                'inputTemplate' => '{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>',
                'options' => [
                        'class'=>'form-group has-feedback'
                ],
        ])->passwordInput(['placeholder'=>$model->getAttributeLabel('password')])->label(false);
        ?>

        <?= $form->field($model, 'passwordConfirm',[
            'inputTemplate' => '{input}<span class="glyphicon glyphicon-log-in form-control-feedback"></span>',
            'options' => [
                'class'=>'form-group has-feedback'
            ],
        ])->passwordInput(['placeholder'=>$model->getAttributeLabel('passwordConfirm')])->label(false);
        ?>

        
        <div class="row">
            <div class="col-xs-8">
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'reset-password-button']) ?>
            </div>
            <!-- /.col -->
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <!-- /.login-box-body -->
</div>