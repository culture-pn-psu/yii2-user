<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['bodyClass'] = 'hold-transition login-page';

?>

<div class="login-box">
	<div class="login-logo">
		<b>User</b> LOGIN
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Sign in to start your session</p>

		<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

		<?= $form->field($model, 'username',[
				'inputTemplate' => '{input}<span class="glyphicon glyphicon-user form-control-feedback"></span>',
				'options' => [
						'class'=>'form-group has-feedback'
				],
		])->textInput(['autofocus' => true, 'placeholder'=>$model->getAttributeLabel('username')])->label(false) ?>

		<?= $form->field($model, 'password',[
				'inputTemplate' => '{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>',
				'options' => [
						'class'=>'form-group has-feedback'
				],
		])->passwordInput(['placeholder'=>$model->getAttributeLabel('password')])->label(false) ?>

		
		<div class="row">
			<div class="col-xs-8">
				<?= $form->field($model, 'rememberMe')->checkbox() ?>
			</div>
			<!-- /.col -->
			<div class="col-xs-4">
				<?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
			</div>
			<!-- /.col -->
		</div>
		<div style="color:#999;margin:1em 0">
			If you forgot your password you can <?= Html::a('reset it', ['request-password-reset']) ?>.
		</div>

		<?php ActiveForm::end(); ?>

		<a href="#">I forgot my password</a><br>
		<a href="<?= Url::to(['regist/signup']); ?>" class="text-center">Register a new membership</a>

	</div>
	<!-- /.login-box-body -->
</div>