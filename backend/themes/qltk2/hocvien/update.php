<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Cập nhật học viên '.$hocvien->name;
 ?>
   <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'form-hocvien']])?>
   <!-- BEGIN Portlet PORTLET-->
   	<div class="thongbao"></div>
          	<div class="row">
          		<div class="col-md-12">
          			  <div class="portlet box blue-hoki">
			                <div class="portlet-title">
			                    <div class="caption">
			                        <i class="fa fa-gift"></i> THÔNG TIN HỌC VIÊN
			                    </div>
			                </div>
			                <div class="portlet-body">
			                    <!-- BEGIN FORM-->
								<div class="row">
									<div class="col-lg-3 table-responsive edusec-pf-border no-padding edusecArLangCss" style="margin-bottom:15px">
									<!-- SIDEBAR USERPIC -->
						             

						                    <div class="form-group text-center">
						                        <div class="fileinput fileinput-new" data-provides="fileinput">
						                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
						                                <?php if($hocvien->isNewRecord): ?>
						                                    <img src="<?= Yii::$app->request->baseUrl?>/backend/themes/qltk2/assets/global/img/no-photo.png" alt=""/>
						                                <?php else: ?>
						                                    <?=\yii\bootstrap\Html::img('anhhocvien/'.$hocvien->anhdaidien)?>
						                                <?php endif; ?>
						                            </div>
						                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
						                            </div>
						                            <div>
						                                <span class="btn btn-success btn-file">
															<span class="fileinput-new">
																Chọn hình ảnh </span>
															<span class="fileinput-exists">
														Thay đổi </span>
						                                    <?=Html::activeFileInput($hocvien, 'anhdaidien');?>
														</span>
						                                <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">
						                                    Xóa </a>
						                            </div>
						                        </div>
						                    </div>
						        
						                <!-- END SIDEBAR USERPIC -->
						        
									</div>
									<div class="col-lg-9 profile-data">
										<ul class="nav nav-tabs responsive hidden-xs hidden-sm" id="profileTab">
											<li class="active" id="personal-tab"><a href="#personal" data-toggle="tab"><i class="fa fa-street-view"></i> Cá nhân</a></li>
											<li id="hoctap-tab"><a href="#hoctap" data-toggle="tab"><i class="fa fa-user"></i> Học tập</a></li>
											<li id="donhang-tab"><a href="#donhang" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Đơn hàng</a></li>
										</ul>
									 	<div id="content" class="tab-content responsive hidden-xs hidden-sm">
											<div class="tab-pane active" id="personal">
												<div class="row">
												  <div class="col-xs-12">
													<h4 class="page-header">	
													<i class="fa fa-street-view"></i> Thông tin cá nhân	
													</h4>
												  </div><!-- /.col -->
												</div>
												
												<?= $this->render('_form',['model'=>$hocvien,'form'=>$form]); ?>
											</div>
											<div class="tab-pane" id="hoctap">
												<div class="row">
												  <div class="col-xs-12">
													<h4 class="page-header">	
													<i class="fa fa-user"></i> Thông tin học tập
													</h4>
												  </div><!-- /.col -->
												</div>
												<?= $this->render('_form_hoc_tap',['hocvien'=>$hocvien,'khoa'=>$khoa,'lop'=>$lop,'form'=>$form]); ?>
											</div>
											<div class="tab-pane" id="donhang">
												<div class="row">
												  <div class="col-xs-12">
													<h4 class="page-header">	
													<i class="fa fa-graduation-cap"></i> Thông tin đơn hàng
													</h4>
												  </div><!-- /.col -->
												</div>
												<?= $this->render('_form_don_hang',['donhang'=>$donhangchitiet,'form'=>$form]); ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
          		</div>
          	</div>
			<?php $form = ActiveForm::end()?>
				<div class="col-md-12 text-right">
					<?=\yii\bootstrap\Html::button('<i class="fa fa-save"></i> '.($hocvien->id == ''?'Lưu lại':'Cập nhật và quay lại danh sách'),['class' => 'btn btn-save btn-success'])?>
				</div>

<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/scripts/bootstrap3-typeahead.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/scripts/jsview/hocvien.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>