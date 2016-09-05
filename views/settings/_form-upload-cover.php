<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="row">
	<div class="col-xs-12">
<?php $form = ActiveForm::begin(['action' => ['cover-upload'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $form->field($model, 'imageFile')->fileInput(['class'=>'pull-left'])->label(false) ?>

<?= Html::submitButton('<i class="glyphicon glyphicon-cloud-upload"></i>', ['class' => 'btn btn-default pull-right']) ?>
<?php ActiveForm::end(); ?>
	</div>
</div>

<?php
$coverListUrl = Url::to(['settings/cover']);
$js = <<<JS
$(document).on('submit', '#$form->id', function(e) {
	e.preventDefault();
	var formData = new FormData(this);
	$.ajax({
		type:'POST',
		url: $(this).attr('action'),
		data:formData,
		cache:false,
		contentType: false,
		processData: false,
		success:function(data){
			console.log("success");
			console.log(data);
			$.get( "$coverListUrl", function( data ) {
				$( "#content-covers" ).html( data );
				//alert( "Load was performed." );
			});
		},
		error: function(data){
			console.log("error");
			console.log(data);
		}
	});
});
JS;
$this->registerJs($js);
?>