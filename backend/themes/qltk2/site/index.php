<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\grid\DataColumn;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tổng quan - TTSKN ASV');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-madison">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?= (isset($hocvien_count))?$hocvien_count:0; ?>
							</div>
							<div class="desc">
								 Học viên
							</div>
						</div>
						<a class="more" href="javascript:;">
						Chi tiết <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?= (isset($donhangs)&&count($donhangs))?count($donhangs):0 ?>
							</div>
							<div class="desc">
								 Đơn hàng
							</div>
						</div>
						<a class="more" href="javascript:;">
						Chi tiết<i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">
								 549
							</div>
							<div class="desc">
								 Xuất cảnh
							</div>
						</div>
						<a class="more" href="javascript:;">
						Chi tiết <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number">
								 600
							</div>
							<div class="desc">
								 Học viên đỗ
							</div>
						</div>
						<a class="more" href="javascript:;">
						Chi tiết <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			</div>
 <div class="row">
 	<div class="col-md-6 col-sm-6">
					<!-- BEGIN PORTLET-->
					<div class="portlet light">
						<div class="portlet-title tabbable-line">
							<div class="caption">
								<i class="icon-globe font-green-sharp"></i>
								<span class="caption-subject font-green-sharp bold uppercase">Đơn hàng gần đây</span>
							</div>
						</div>
						<div class="portlet-body">
							<!--BEGIN TABS-->
							<div class="scroller" style="height: 339px;" data-always-visible="1" data-rail-visible="0">
										<ul class="feeds">
											<?php if (isset($donhangs)&&count($donhangs)): ?>
												<?php foreach($donhangs as $donhang): ?>
													<li>
														<div class="col1">
															<div class="cont">
																<div class="cont-col1">
																	<div class="label label-sm label-success">
																		<i class="fa fa-bell-o"></i>
																	</div>
																</div>
																<div class="cont-col2">
																	<div class="desc">
																		 <?= $donhang->name ?>
																	</div>
																</div>
															</div>
														</div>
														<!-- <div class="col2">
															<div class="date">
																 Just now
															</div>
														</div> -->
													</li>
												<?php endforeach; ?>
											<?php endif; ?>
										</ul>
									</div>
							<!--END TABS-->
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
 	<div class="col-md-6 col-sm-6">
        <!-- BEGIN PORTLET-->
        <div class="portlet light calendar ">
            <div class="portlet-title ">
                <div class="caption">
                    <i class="icon-calendar font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">Lịch thi đơn hàng</span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="calendar">
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
 </div>

<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css'); ?>
<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/fullcalendar/fullcalendar.min.css'); ?>
<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/jqvmap/jqvmap/jqvmap.css'); ?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap-daterangepicker/moment.min.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/fullcalendar/fullcalendar.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/fullcalendar/lang/vi.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/jquery.sparkline.min.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/scripts/jsview/indexsite.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap/js/bootstrap.min.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
