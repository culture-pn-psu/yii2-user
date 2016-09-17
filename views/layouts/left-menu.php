<?php

use yii\helpers\Html;
use yii\helpers\BaseStringHelper;
//use firdows\menu\models\Navigate;
use suPnPsu\material\components\Navigate;
use mdm\admin\components\Helper;

/* @var $this \yii\web\View */
/* @var $content string */

$controller = $this->context;
//$menus = $controller->module->menus;
//$route = $controller->route;
$user = Yii::$app->user->identity->profile->resultInfo;
$module = $this->context->module->id;
?>
<?php $this->beginContent('@app/views/layouts/main.php') ?>

<div class="row">
    <div class="col-md-3">




        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <?= $user->fullname ?>
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
                        'label' => 'Profile',
                        'url' => ["/{$module}/settings/profile"], 'icon' => 'fa fa-book'
                    ],
                    [
                        'label' => 'Account',
                        'url' => ["/{$module}/settings/account"],
                        'icon' => 'fa fa-adn'
                    ],
                    [
                        'label' => 'Chanage Password',
                        'url' => ["/{$module}/settings/change-password"],
                        'icon' => 'fa fa-key'
                    ],
                ];
                $menuItems = Helper::filter($menuItems);

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
