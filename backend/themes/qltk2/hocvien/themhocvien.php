<?php
/**
 * Created by PhpStorm.
 * User: Bui Tung
 * Date: 4/14/2017
 * Time: 10:06 AM
 */?>

<div class="portlet light bg-inverse">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-equalizer font-red-sunglo"></i>
			<span class="caption-subject font-red-sunglo bold uppercase">Thông tin học viên</span>
			<span class="caption-helper">Thông tin...</span>
		</div>
		<div class="tools">
			<a href="" class="collapse">
			</a>
			<a href="#portlet-config" data-toggle="modal" class="config">
			</a>
			<a href="" class="reload">
			</a>
			<a href="" class="remove">
			</a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
			<?php $form = \yii\bootstrap\ActiveForm::begin(['options' => ['id' => 'form-hocvien','class'=>'horizontal-form']]); ?>
			<div class="form-body">
				<h3 class="form-section">Thông tin cá nhân</h3>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Họ và tên</label>
							<input type="text" id="firstName" class="form-control" placeholder="Họ và tên">

						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Tên tiếng Nhật</label>
							<input type="text" id="lastName" class="form-control" placeholder="Tên tiếng Nhật">

						</div>
					</div>
					<!--/span-->
				</div>
				<!--/row-->
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Giới tính</label>
							<select class="form-control">
								<option value="">Nam</option>
								<option value="">Nữ</option>
							</select>
							<span class="help-block">
															Chọn giới tính </span>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">
						<div class="form-group">

							<?=\common\models\myFuncs::activeDateField($form, $hocvien, 'ngaysinh','Ngày')?>
						</div>
					</div>
					<!--/span-->
				</div>
				<!--/row-->
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Category</label>
							<select class="select2_category form-control" data-placeholder="Choose a Category" tabindex="1">
								<option value="Category 1">Category 1</option>
								<option value="Category 2">Category 2</option>
								<option value="Category 3">Category 5</option>
								<option value="Category 4">Category 4</option>
							</select>
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Membership</label>
							<div class="radio-list">
								<label class="radio-inline">
									<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked> Option 1 </label>
								<label class="radio-inline">
									<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> Option 2 </label>
							</div>
						</div>
					</div>
					<!--/span-->
				</div>
				<!--/row-->
				<h3 class="form-section">Địa chỉ</h3>
				<div class="row">
					<div class="col-md-12 ">
						<div class="form-group">
							<label>Street</label>
							<input type="text" class="form-control">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>City</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">
						<div class="form-group">
							<label>State</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<!--/span-->
				</div>
				<!--/row-->
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Post Code</label>
							<input type="text" class="form-control">
						</div>
					</div>
					<!--/span-->
					<div class="col-md-6">
						<div class="form-group">
							<label>Country</label>
							<select class="form-control">
							</select>
						</div>
					</div>
					<!--/span-->
				</div>
			</div>
			<div class="form-actions left">
				<button type="button" class="btn default">Cancel</button>
				<button type="submit" class="btn blue"><i class="fa fa-check"></i> Save</button>
			</div>
		<?php \yii\bootstrap\ActiveForm::end() ?>
		<!-- END FORM-->
	</div>
</div>