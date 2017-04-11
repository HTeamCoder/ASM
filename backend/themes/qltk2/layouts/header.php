<?php
/**
 * Created by PhpStorm.
 * User: HungLuongHien
 * Date: 6/23/2016
 * Time: 1:24 PM
 */
use yii\helpers\Html;
use common\models\User;
$role = User::getRole();
?>
<div class="page-header -i navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?=Yii::$app->urlManager->createUrl('site/index')?>" style="color: #ffffff; padding: 5px; display: inline-block;  font-size: 18pt">TTSKN ASV</a>
        </div>
        <div class="hor-menu hidden-sm hidden-xs">
            <ul class="nav navbar-nav">

                <li class="classic-menu-dropdown">
                    <a data-toggle="dropdown" href="javascript:;" class="dropdown-toggle" data-hover="megamenu-dropdown" data-close-others="true">
                        Danh mục <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-left">
                        <li class="classic-menu-dropdown">
                            <?=Html::a('<i class="fa fa-bookmark-o"></i> Cấu hình', Yii::$app->urlManager->createUrl(['cauhinh']))?>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src="<?=Yii::$app->request->baseUrl ?>/backend/themes/qltk2/assets/admin/layout/img/avatar3_small.jpg"/>
                        <span class="username username-hide-on-mobile"><?=Yii::$app->user->isGuest?"":Yii::$app->user->identity->username?> </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <?php if(!Yii::$app->user->isGuest):?>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <?=Html::a('<i class="icon-key"></i> Đăng xuất', Yii::$app->urlManager->createUrl('site/logout'))?>
                            </li>
                        </ul>
                    <?php endif; ?>
                </li>
                
            </ul>
        </div>
    </div>
</div>
