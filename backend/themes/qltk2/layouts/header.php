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
                            <?=Html::a('<i class="fa fa-bookmark-o"></i> Loại danh sách', Yii::$app->urlManager->createUrl(['loaidanhsach']))?>
                        </li>
                        <li class="classic-menu-dropdown">
                            <?=Html::a('<i class="fa fa-bookmark-o"></i> Khóa học', Yii::$app->urlManager->createUrl(['khoa']))?>
                        </li>
                        <li class="classic-menu-dropdown">
                            <?=Html::a('<i class="fa fa-bookmark-o"></i> Lớp học', Yii::$app->urlManager->createUrl(['lop']))?>
                        </li>
                        <li class="classic-menu-dropdown">
                            <?=Html::a('<i class="fa fa-bookmark-o"></i> Bài học', Yii::$app->urlManager->createUrl(['baihoc']))?>
                        </li>
                        <li class="classic-menu-dropdown">
                            <?=Html::a('<i class="fa fa-bookmark-o"></i> Khu vực', Yii::$app->urlManager->createUrl(['khuvuc']))?>
                        </li>
                        <li class="classic-menu-dropdown">
                            <?=Html::a('<i class="fa fa-bookmark-o"></i> Bệnh viện', Yii::$app->urlManager->createUrl(['benhvien']))?>
                        </li>
                        <li class="classic-menu-dropdown">
                            <?=Html::a('<i class="fa fa-bookmark-o"></i> Nhóm máu', Yii::$app->urlManager->createUrl(['nhommau']))?>
                        </li>
                        <li class="classic-menu-dropdown">
                            <?=Html::a('<i class="fa fa-bookmark-o"></i> Xí nghiệp', Yii::$app->urlManager->createUrl(['xinghiep']))?>
                        </li>
                        <li class="classic-menu-dropdown">
                            <?=Html::a('<i class="fa fa-bookmark-o"></i> Nghiệp đoàn', Yii::$app->urlManager->createUrl(['nghiepdoan']))?>
                        </li>
                        <li class="classic-menu-dropdown">
                            <?=Html::a('<i class="fa fa-bookmark-o"></i> Cộng tác viên', Yii::$app->urlManager->createUrl(['congtacvien']))?>
                        </li>
                        <li class="classic-menu-dropdown">
                            <?=Html::a('<i class="fa fa-bookmark-o"></i> Đơn vị cung cấp nguồn', Yii::$app->urlManager->createUrl(['donvicungcapnguon']))?>
                        </li>
                        <li class="classic-menu-dropdown">
                            <?=Html::a('<i class="fa fa-bookmark-o"></i> Vùng làm việc', Yii::$app->urlManager->createUrl(['vunglamviec']))?>
                        </li>
                        <li class="classic-menu-dropdown">
                            <?=Html::a('<i class="fa fa-bookmark-o"></i> Nơi đào tạo sau trúng tuyển', Yii::$app->urlManager->createUrl(['noidaotaosautrungtuyen']))?>
                        </li>
                    </ul>
                </li>
                <li class="classic-menu-dropdown">
                    <?=Html::a('<i class="fa fa-bookmark-o"></i> Tuyển dụng', Yii::$app->urlManager->createUrl(['index']))?>
                </li>
                <li class="classic-menu-dropdown">
                    <?=Html::a('<i class="fa fa-bookmark-o"></i> Đào tạo', Yii::$app->urlManager->createUrl(['index']))?>
                </li>
                <li class="classic-menu-dropdown">
                    <?=Html::a('<i class="fa fa-bookmark-o"></i> Cấu hình', Yii::$app->urlManager->createUrl(['cauhinh']))?>
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
