<?php

use yii\helpers\Html;
use yii\helpers\BaseStringHelper;
//use firdows\menu\models\Navigate;
use suPnPsu\material\components\Navigate;
use mdm\admin\components\Helper;
use culturePnPsu\user\components\AdminNavigate;

/* @var $this \yii\web\View */
/* @var $content string */

$controller = $this->context;
//$menus = $controller->module->menus;
//$route = $controller->route;
$user = Yii::$app->user->identity->profile->resultInfo;
$module = $this->context->module->id."/".Yii::$app->controller->id;
?>
<?php $this->beginContent('@app/views/layouts/main.php') ?>

<div class="row">
    <div class="col-md-3">
        
        <?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app','เพิ่มผู้ใช้'), ["/{$module}/create"], ['class' => 'btn btn-success btn-block margin-bottom']) ?>
        

        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?= Yii::t('app','ระบบจัดการผู้ใช้') ?>
                </h3>

                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body no-padding">
                
                

                <?php
                $menuItems = [
                    [
                        'label' => 'ผู้ใช้ทั้งหมด',
                        'url' => ["/{$module}/index"], 'icon' => 'fa fa-book'
                    ],
                    [
                        'label' => 'ผู้ที่ลงทะเบียน',
                        'url' => ["/{$module}/waiting"],
                        'icon' => 'fa fa-adn'
                    ],
                    [
                        'label' => 'ผู้ใช้ที่ถูกแบน',
                        'url' => ["/{$module}/banned"],
                        'icon' => 'fa fa-adn'
                    ],
                    [
                        'label' => 'ผู้ใช้ที่ถูกลบ',
                        'url' => ["/{$module}/deleted"],
                        'icon' => 'fa fa-user-secret'
                    ],
                ];
                
                $menuItems = Helper::filter($menuItems);
                $menuItems = AdminNavigate::genCount($menuItems);
                
                //print_r($menuItems);

                $nav = new Navigate();
                echo dmstr\widgets\Menu::widget([
                    'options' => ['class' => 'nav nav-pills nav-stacked'],
                    //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
                    'items' => $menuItems,
                ])
                ?>                 

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /. box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <?= $content ?>
        <!-- /. box -->
    </div>
    <!-- /.col -->
</div>


<?php $this->endContent(); ?>
