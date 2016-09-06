<?php
use yii\helpers\Html;
?>
<div class="row">
<?php foreach ($model->covers() as $key => $cover): ?>
	<div class="col-sm-3 pad">
	<a href="#!" class="cover-item" basename="<?= basename(Yii::$app->homeUrl.$cover); ?>">
		<img src="<?= Yii::$app->homeUrl.$cover; ?>" class="img-responsive" style="height: 87px;">
	</a>
	</div>
<?php endforeach; ?>
</div>