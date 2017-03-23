<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use culturePnPsu\user\models\Position;

/* @var $this yii\web\View */
/* @var $user culturePnPsu\user\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-<?= $user->isNewRecord ? 'success' : 'primary' ?>">
	<!-- form start -->
	<?php $form = ActiveForm::begin(); ?>
	<div class="box-body">
		<div class="row">
			<div class="col-sm-6">
				<h3>Account</h3>

				<?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>

				<?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>

				<?= $form->field($user, 'status')->dropDownList($user->statusList) ?>

				<?= $form->field($user, 'newPassword')->passwordInput() ?>

				<?= $form->field($user, 'newPasswordConfirm')->passwordInput() ?>
			</div>


			<div class="col-sm-6">
				<h3>Profile</h3>

				<?= $form->field($profile, 'firstname')->textInput(['maxlength' => true]) ?>

				<?= $form->field($profile, 'lastname')->textInput(['maxlength' => true]) ?>
                                
                                <?= $form->field($person, 'position_id')->dropDownList(Position::getList(),['prompt'=>'เลือกตำแหน่ง']) ?>

				<?= $form->field($profile, 'bio')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
	</div>
	<!-- /.box-body -->
	<div class="box-footer">
		<?= Html::submitButton($user->isNewRecord ? 'Create' : 'Update', ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary btn-flat pull-right']) ?>
	</div>
	<!-- /.box-footer -->
	<?php ActiveForm::end(); ?>
</div>
