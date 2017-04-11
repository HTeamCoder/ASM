<?php
/**
 * Created by PhpStorm.
 * User: HungLuongHien
 * Date: 6/23/2016
 * Time: 1:54 PM
 */
use yii\helpers\Html;
?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu" data-slide-speed="200" data-auto-scroll="true">
                <li>
                    <a href="index.html">
                       <?=Html::a('Tổng quan', Yii::$app->urlManager->createUrl(['site/index']))?>
                    </span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        Danh mục <span class="arrow">
                    </span>
                    </a>
                    <ul class="sub-menu">
                        <li><?=Html::a('<i class="fa fa-bookmark-o"></i> Hàng hóa', Yii::$app->urlManager->createUrl('hanghoa'))?></li>
                        <li><?= Html::a('<i class="fa fa-bookmark-o"></i> Đơn vị tính', Yii::$app->urlManager->createUrl('donvitinh')) ?></li>
                        <li><?= Html::a('<i class="fa fa-bookmark-o"></i> Khách hàng', Yii::$app->urlManager->createUrl('khachhang')) ?></li>
                        <li><?= Html::a('<i class="fa fa-bookmark-o"></i> Nhà cung cấp', Yii::$app->urlManager->createUrl('nhacungcap')) ?></li>
                        <li><?= Html::a('<i class="fa fa-bookmark-o"></i> Xuất xứ', Yii::$app->urlManager->createUrl('xuatxu')) ?></li>
                        <li><?= Html::a('<i class="fa fa-bookmark-o"></i> Nhóm loại hàng', Yii::$app->urlManager->createUrl('nhomloaihang')) ?></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        Nhập - xuất hàng <span class="arrow">
                    </span>
                    </a>
                    <ul class="sub-menu">
                        <li><?= Html::a('<i class="fa fa-bookmark-o"></i> Nhập tồn đầu kỳ', Yii::$app->urlManager->createUrl(['nhapxuathang/nhaptondauky'])) ?></li>
                        <li><?= Html::a('<i class="fa fa-bookmark-o"></i> Bán hàng', Yii::$app->urlManager->createUrl(['nhapxuathang/banhang'])) ?></li>
                        <li><?= Html::a('<i class="fa fa-bookmark-o"></i> Nhập theo hóa đơn', Yii::$app->urlManager->createUrl(['nhapxuathang/nhaptheohoadon'])) ?></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        Thống kê <span class="arrow">
                    </span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <?= Html::a('<i class="fa fa-bookmark-o"></i> Phiếu nhập/xuất', Yii::$app->urlManager->createUrl(['nhapxuathang/index'])) ?>
                        </li>
                        <li>
                            <?= Html::a('<i class="fa fa-bookmark-o"></i> Lịch sử hàng hóa', Yii::$app->urlManager->createUrl(['baocaokho/lichsuhanghoa'])) ?>
                        </li>
                         <li>
                            <?= Html::a('<i class="fa fa-bookmark-o"></i> Bảng kê hóa đơn bán hàng', Yii::$app->urlManager->createUrl(['baocaokho/bangkehoadonbanhang'])) ?>
                        </li>
                        <li>
                            <?= Html::a('<i class="fa fa-bookmark-o"></i> Bảng kê phiếu nhập', Yii::$app->urlManager->createUrl(['baocaokho/bangkephieunhap'])) ?>
                        </li>
                        <li>
                            <?= Html::a('<i class="fa fa-bookmark-o"></i> Công nợ nhà cung cấp', Yii::$app->urlManager->createUrl(['baocaokho/chitiettranhacungcap'])) ?>
                        </li>
                        <li>
                            <?= Html::a('<i class="fa fa-bookmark-o"></i> Công nợ khách hàng', Yii::$app->urlManager->createUrl(['baocaokho/chitiettrakhachhang'])) ?>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        Báo cáo kho <span class="arrow">
                    </span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <?= Html::a('<i class="fa fa-bookmark-o"></i> Tồn kho tổng hợp', Yii::$app->urlManager->createUrl(['baocaokho/index'])) ?>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        Công nợ - Thu chi <span class="arrow">
                    </span>
                    </a>
                    <ul class="sub-menu">
                         <li>
                            <?= Html::a('<i class="fa fa-bookmark-o"></i> Công Nợ Hóa Đơn', Yii::$app->urlManager->createUrl(['nhapxuathang/congno'])) ?>
                        </li>
                        <li>
                            <?= Html::a('<i class="fa fa-bookmark-o"></i> Công Nợ Nhà Cung Cấp', Yii::$app->urlManager->createUrl(['nhapxuathang/congnonhacungcap'])) ?>
                        </li>
                        <li>
                            <?= Html::a('<i class="fa fa-bookmark-o"></i> Công Nợ Khách Hàng', Yii::$app->urlManager->createUrl(['nhapxuathang/congnokhachhang'])) ?>
                        </li>
                        <li>
                            <?= Html::a('<i class="fa fa-bookmark-o"></i> Thu Chi Nhà Cung  Cấp', Yii::$app->urlManager->createUrl(['nhapxuathang/thuchinhacungcap'])) ?>
                        </li>
                        <li>
                            <?= Html::a('<i class="fa fa-bookmark-o"></i> Thu Chi Khách Hàng', Yii::$app->urlManager->createUrl(['nhapxuathang/thuchikhachhang'])) ?>
                        </li>
                    </ul>
                </li>
                  <li class="classic-menu-dropdown">
                    <?=Html::a('Cấu hình', Yii::$app->urlManager->createUrl(['cauhinh']))?>
                </li>
            </ul>
        </div>
        <!-- END HORIZONTAL RESPONSIVE MENU -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <h3 class="page-title">
                <?=$this->title?>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?=Yii::$app->urlManager->createUrl('site/index')?>">Tổng quan</a>
                        <?php if(count($this->breadCrumbs) > 0):?>
                            <i class="fa fa-angle-right"></i>
                        <?php endif; ?>
                    </li>
                    <?php foreach ($this->breadCrumbs as $index => $breadCrumb) {
                        $link = \yii\helpers\Html::a($breadCrumb['name'],$breadCrumb['url']);
                        if($index < count($this->breadCrumbs) - 1)
                            $next = '<i class="fa fa-angle-right"></i>';
                        else
                            $next = "";
                        echo "<li>{$link} {$next}</li>";
                    } ?>
                </ul>
            </div>
            <!-- END PAGE HEADER-->
            <div id="print-block"></div>
            <?= $content ?>
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
