<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model suPnPsu\user\models\Account */

$this->title = 'Change Password: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Settings',];
$this->params['breadcrumbs'][] = 'Change password';
?>
<div class="account-update">

	<div class="row">
		<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
			<?php $form = ActiveForm::begin(); ?>
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Change password</h3>
				</div>
				<div class="box-body">
					<?= $form->field($model, 'currentPassword')->passwordInput(['autofocus' => true]) ?>
					<hr />
					<?= $form->field($model, 'newPassword')->passwordInput() ?>
					<?= $form->field($model, 'newPasswordConfirm')->passwordInput() ?>
				</div>
				<div class="box-footer">
					<div class="form-group">
						<?= Html::submitButton('<i class="fa fa-check" aria-hidden="true"></i> Change Password', ['class' => 'btn btn-primary']) ?>
					</div>
				</div>
			</div>
			<?php ActiveForm::end(); ?>
		</div>

	</div>

</div>