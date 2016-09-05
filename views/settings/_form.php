<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model anda\user\models\Profile */
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
.widget-user .btn-change-avatar, .widget-user .btn-change-cover{
    position: absolute;
    right: 15px;
    bottom: 15px;
    display: none;
}
.widget-user .widget-user-image:hover .btn-change-avatar, 
.widget-user .widget-user-header:hover .btn-change-cover{
    display: inherit;
}
");
?>

<div class="profile-form">
    <div class="box box-widget widget-user">

            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-black" style="background-image: url('<?= $model->info()->cover; ?>');">
                <div style="color: #333">
                <?php $formCover = ActiveForm::begin(); ?>
                <?= $formCover->field($model, 'cover')->hiddenInput()->label(false) ?>
                <?php ActiveForm::end(); ?>
                <?php
                $fieldID = Html::getInputId($model, 'cover');
                echo \mirage\basicfilemanager\widgets\ModalBrowser::widget([
                    'browserUrl' => '/basicfilemanager',
                    'fieldID' => $fieldID,
                    'returnType' => 'basename', //url(default), absolute, behind, basename
                        //url คือ ที่อยู่ของไฟล์ (/project/uploads/images/abc.jpg),
                        //absolute คือ ที่อยู่ของไฟล์แบบเต็ม (http://www.example.com/project/uploads/images/abc.jpg),
                        //behind คือ ที่ตั้งไฟล์โดยเริ่มนับจากหลังคอนฟิคไดเรคทอรี่อัพโหลด (images/abc.jpg),
                        //basename คือ ใช้ชื่อไฟล์อ่างเดียว (abc.jpg)
                    'options' => [
                        'subDir' => 'user/'.$model->user_id.'/cover', //บังคับเข้า dir
                        'changeDir' => false, //การอนุญาตให้เปลี่ยน dir ได้
                        'createDir' => false, //การอนุญาติให้สร้าง dir
                        //'upload' => false, //การอนุญาติให้ upload
                    ],
                    'modalOptions'=>[ //ค่า config ของ bootstrap modal
                        'header' => '<strong>Covers</strong>',
                        'id' => 'modalCover',
                        'toggleButton' => [
                            'label' => '<i class="glyphicon glyphicon-picture"></i>', 
                            'id' => 'cover-btn-browse',
                            'class'=>'btn btn-default btn-change-cover'
                        ],
                    ],
                ]);

                $coverUrl = Yii::$app->homeUrl.'uploads/user/'.$model->user_id.'/cover/';
                //$coverUrl = '';
                $actionCoverUrl = Url::to(['cover']);
                $this->registerJS("
function modalCover_after_selected_function(){
    $('#$formCover->id').trigger('submit');
}
", $this::POS_HEAD);
                $this->registerJS("
$(document).on('submit', '#$formCover->id', function(e) {
    e.preventDefault();
    $.post('$actionCoverUrl',$(this).serialize(), function( data ) {
        if(data.message){
            location.reload();
        }
    });
});
");
                ?>
                </div>
              <!--<h3 class="widget-user-username"><?= $model->info()->fullname; ?></h3>
              <h5 class="widget-user-desc">Web Designer</h5>-->
            </div>
            <div class="widget-user-image">
                <img class="img-circle" src="<?= $model->info()->avatar; ?>" alt="User Avatar">
                <div style="color: #333">
                <?php $formAvatar = ActiveForm::begin(); ?>
                <?= $formAvatar->field($model, 'avatar')->hiddenInput()->label(false) ?>
                <?php ActiveForm::end(); ?>
                <?php
                $fieldID = Html::getInputId($model, 'avatar');
                echo \mirage\basicfilemanager\widgets\ModalBrowser::widget([
                    'browserUrl' => '/basicfilemanager',
                    'fieldID' => $fieldID,
                    'returnType' => 'basename',
                    'options' => [
                        'subDir' => 'user/'.$model->user_id.'/avatar',
                        'changeDir' => false,
                        'createDir' => false,
                        //'upload' => false,
                    ],
                    'modalOptions'=>[ //ค่า config ของ bootstrap modal
                        'header' => '<strong>Avatars</strong>',
                        'id' => 'modalAvatar',
                        'toggleButton' => [
                            'label' => '<i class="glyphicon glyphicon-picture"></i>', 
                            'id' => 'avatar-btn-browse',
                            'class'=>'btn btn-default btn-change-avatar'
                        ],
                    ],
                ]);

                $avatarUrl = Yii::$app->homeUrl.'uploads/user/'.$model->user_id.'/avatar/';
                //$avatarUrl = '';
                $actionAvatarUrl = Url::to(['avatar']);
                $this->registerJS("
function modalAvatar_after_selected_function(){
    $('#$formAvatar->id').trigger('submit');
}
", $this::POS_HEAD);
                $this->registerJS("
$(document).on('submit', '#$formAvatar->id', function(e) {
    e.preventDefault();
    $.post('$actionAvatarUrl',$(this).serialize(), function( data ) {
        if(data.message){
            location.reload();
        }
    });
});
");
                ?>
                
                </div>
            </div>
            <div class="box-footer">
              <div class="row" style="margin-top: 30px;">
                <div class="col-sm-12">
                  <?php $form = ActiveForm::begin(); ?>
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

    <?php ActiveForm::end(); ?>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
    

</div>

<?php
