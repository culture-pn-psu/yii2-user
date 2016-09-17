<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use karpoff\icrop\CropImageUpload;

/* @var $this yii\web\View */
/* @var $model suPnPsu\user\models\Profile */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$this->registerCss("
.widget-user .widget-user-header{
    position: relative;
    background-size: cover;
    background-position: 50% 50%;
    background-repeat: no-repeat;
}
.widget-user .widget-user-header{
    height: 200px;
}
.widget-user .widget-user-image{
    top: 145px;
}
.widget-user .btn-change-photo{
    position: absolute;
    right: 15px;
    bottom: 15px;
    display: none;
}
.widget-user .widget-user-image:hover .btn-change-photo,
.widget-user .widget-user-header:hover .btn-change-photo{
    display: inherit;
}
.widget-user .modal-change-photo input[type=\"file\"]{
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
}
");
?>

<div class="profile-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="box box-widget widget-user">

            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-black" style="background-image: url('<?= $model->resultInfo->cover; ?>');">
                <div style="color: #333">
                  <?php
Modal::begin([
    'header' => '<h4 class="modal-title">Change Cover</h4>',
    'options' => [
        'class' => 'modal-change-photo',
    ],
    'toggleButton' => [
      'label' => '<i class="fa fa-picture-o" aria-hidden="true"></i>',
      'class' => 'btn btn-default btn-change-photo'
    ],
    'footer' => Html::submitButton('<i class="fa fa-check-circle-o" aria-hidden="true"></i> Update', ['class'=>'btn btn-primary']),
]);

echo $form->field($model, 'cover')->widget(CropImageUpload::className());

Modal::end();
                  ?>

                </div>
            </div>
            <div class="widget-user-image">
                <img class="img-circle" src="<?= $model->resultInfo->avatar; ?>" alt="User Avatar">
                <div style="color: #333">
                    <?php
  Modal::begin([
      'header' => '<h4 class="modal-title">Change Cover</h4>',
      'options' => [
          'class' => 'modal-change-photo',
      ],
      'toggleButton' => [
        'label' => '<i class="fa fa-picture-o" aria-hidden="true"></i>',
        'class' => 'btn btn-default btn-change-photo'
      ],
      'footer' => Html::submitButton('<i class="fa fa-check-circle-o" aria-hidden="true"></i> Update', ['class'=>'btn btn-primary']),
  ]);

  echo $form->field($model, 'avatar')->widget(CropImageUpload::className());

  Modal::end();
                    ?>
                </div>
            </div>
            
            
            <div class="box-footer">
              <div class="row" style="margin-top: 30px;">
                <div class="col-sm-12">

                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'bio')->textarea(['rows' => 6]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
    <?php ActiveForm::end(); ?>

</div>
