<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
$this->params['bodyClass'] = 'hold-transition register-page';
?>
<?php
//echo $this->context->module->userUploadDir;
?>
<div class="register-box">
    <div class="register-logo">
        <b>Sign</b>UP
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Register a new membership</p>
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <?= $form->field($model, 'username',[
            'inputTemplate' => '{input}<span class="glyphicon glyphicon-user form-control-feedback"></span>',
            'options' => [
                'class'=>'form-group has-feedback'
            ],
        ])->textInput(['autofocus' => true, 'placeholder'=>$model->getAttributeLabel('username')])->label(false);
        ?>

        <?= $form->field($model, 'email',[
            'inputTemplate' => '{input}<span class="glyphicon glyphicon-envelope form-control-feedback"></span>',
            'options' => [
                'class'=>'form-group has-feedback'
            ],
        ])->textInput(['placeholder'=>$model->getAttributeLabel('email')])->label(false);
        ?>

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
            <?= $form->field($model, 'acceptLicence')->checkbox() ?>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <?= Html::submitButton('Register', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'register-button']) ?>
        </div>
        <!-- /.col -->
      </div>

        

        <?php ActiveForm::end(); ?>
    
    

    <a href="<?= Url::to(['auth/login']); ?>" class="text-center">I already have a membership</a>
  </div>
  <!-- /.form-box -->
</div>