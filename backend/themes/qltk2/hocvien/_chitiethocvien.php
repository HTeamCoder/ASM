<?php if(!is_null($hocvien)): ?>
	<div class="row">
		<div class="col-lg-3 table-responsive edusec-pf-border no-padding edusecArLangCss" style="margin-bottom:15px">
			<div class="col-md-12 text-center img-box-chitiethocvien">
			  <?=\yii\bootstrap\Html::img('anhhocvien/'.$hocvien->anhdaidien,['class'=>'img-circle img-responsive','style'=>'width:250px;height:250px;'])?>
			</div>
			<table class="table table-striped">
				<tbody><tr>
					<th>Mã học viên</th>
					<td><?= ($hocvien->ma)?$hocvien->ma:'' ?></td>
				</tr>
				<tr>
					<th>Họ Tên</th>
					<td><?= ($hocvien->name)?$hocvien->name:'' ?></td>
				</tr>
				<tr>
					<th>Tên tiếng nhật</th>
					<td><?= ($hocvien->tentiengnhat)?$hocvien->tentiengnhat:'' ?></td>
				</tr>
				<tr>
					<th>Ngày sinh</th>
					<td><?= ($hocvien->ngaysinh)?date('d/m/Y',strtotime($hocvien->ngaysinh)):'' ?></td>
				</tr>
				<tr>
					<th>Điện thoại</th>
					<td><?= ($hocvien->dienthoai)?$hocvien->dienthoai:'' ?></td>
				</tr>

				<tr>
					<th>Giới tính</th>
					<td>
						<?= ($hocvien->gioitinh)?$hocvien->gioitinh:'' ?>
					</td>
				</tr>
			</tbody></table>
			<a class="btn btn-primary btn-sm text-center" href="<?=Yii::$app->urlManager->createUrl(['hocvien/capnhathocvien','id'=>$hocvien->id]) ?>"><i class="fa fa-edit"></i> Chỉnh sửa</a>
			<a class="btn btn-danger btn-sm text-center btn-remove-hocvien" id="hocvien-<?= $hocvien->id ?>" href="<?=Yii::$app->urlManager->createUrl(['hocvien/xoahocvien','id'=>$hocvien->id]) ?>"><i class="fa fa-trash"></i> Xóa</a>
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

				    <div class="row">
				        <div class="col-md-3 profile-label">
				            Chiều cao
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->chieucao)?$hocvien->chieucao:'' ?></strong>
				        </div>
						<div class="col-md-3 profile-label">
							Cân nặng
						</div>
						<div class="col-md-3 profile-text">
							<strong><?= ($hocvien->cannang)?$hocvien->cannang:'' ?></strong>
						</div>
				    </div>
				    <div class="row">
						<div class="col-md-3 profile-label">
							Thị lực
						</div>
						<div class="col-md-3 profile-text">
							<strong><?= ($hocvien->thiluc)?$hocvien->thiluc.'/10':'' ?></strong>
						</div>
				        <div class="col-md-3 profile-label">
				            Nhóm máu
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->nhommau_id)?$hocvien->nhommau->name:'' ?></strong>
				        </div>
				    </div>
				     <div class="row">
						<div class="col-md-3 profile-label">
				            Tay thuận
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->taythuan)?($hocvien->taythuan=='phai'?'Tay phải':'Tay trái'):'' ?></strong>
				        </div>
						 <div class="col-md-3 profile-label">
							 Hình xăm
						 </div>
						 <div class="col-md-3 profile-text">
							 <strong><?= ($hocvien->hinhxam)?($hocvien->hinhxam=='phai'?'Tay phải':'Tay trái'):'' ?></strong>
						 </div>
				    </div>
				    <div class="row">
						<div class="col-md-3 profile-label">
							Bệnh viện
						</div>
						<div class="col-md-3 profile-text">
							<strong><?= ($hocvien->benhvien_id)?$hocvien->benhvien->name:'' ?></strong>
						</div>
				        <div class="col-md-3 profile-label">
				            Ngày khám
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->ngaykham)?date('d/m/Y',strtotime($hocvien->ngaykham)):'' ?></strong>
				        </div>
				    </div>
					<div class="row">

				        <div class="col-md-3 profile-label">
				        	Ghi chú thể trạng
				        </div>
				        <div class="col-md-9 profile-text">
				            <strong><?= ($hocvien->ghichuthetrang)?$hocvien->ghichuthetrang:'' ?></strong>
				        </div>
				    </div>
				    <div class="row">
						<div class="col-md-3 profile-label">
				            Trình độ học vấn
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->trinhdohocvan_id)?$hocvien->trinhdohocvan->name:'' ?></strong>
				        </div>
				        <div class="col-md-3 profile-label">
				            Tình trạng hôn nhân
				        </div>
				        <div class="col-md-3 profile-text">
				        	<strong><?= ($hocvien->tinhtranghonnhan)?($hocvien->tinhtranghonnhan=='docthan'?'Độc thân':'Đã kết hôn'):'' ?></strong>
				        </div>
				    </div>
					<div class="row">
						<div class="col-md-3 profile-label">
				            Địa chỉ thường trú
				        </div>
				        <div class="col-md-9 profile-text">
				            <strong><?= ($hocvien->khuvuc_id)?(($hocvien->diachi)?$hocvien->diachi.' - ':'').$hocvien->khuvuc->name.' - '.$hocvien->khuvuc->parent->name.' - '.$hocvien->khuvuc->parent->parent->name:'' ?></strong>
				        </div>
				    </div>
				    <div class="row">
						<div class="col-md-3 profile-label">
				            Điện thoại(Cố định/Di động)
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->dienthoai)?$hocvien->dienthoai:'' ?></strong>
				        </div>
				        <div class="col-md-3 profile-label">
				            Điện thoại gia đình
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->dienthoaikhancap)?$hocvien->dienthoaikhancap:'' ?></strong>
				        </div>
				    </div>
				    <div class="row">
						<div class="col-md-3 profile-label">
				           Cộng tác viên
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->congtacvien_id)?$hocvien->congtacvien->name:'' ?></strong>
				        </div>
				        <div class="col-md-3 profile-label">
				            Chứng minh nhân dân
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->cmnd)?$hocvien->cmnd:'' ?></strong>
				        </div>
				    </div>
				    <div class="row">
						<div class="col-md-3 profile-label">
				           Ngày cấp
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->ngaycap)?date('d/m/Y'.strtotime($hocvien->ngaycap)):'' ?></strong>
				        </div>
				        <div class="col-md-3 profile-label">
				            Nơi cấp
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->noicap)?$hocvien->noicap:'' ?></strong>
				        </div>
				    </div>
				    <div class="row">
						<div class="col-md-3 profile-label">
				           Nơi sinh
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->noisinh)?$hocvien->khuvuc->name:'' ?></strong>
				        </div>
				        <div class="col-md-3 profile-label">
				            Nơi học tập
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->noihoctap)?$hocvien->khuvuc->name:'' ?></strong>
				        </div>
				    </div>
				    <div class="row">
						<div class="col-md-3 profile-label">
				           Kinh nghiệm cv
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->kinhnghiemcv)?$hocvien->kinhnghiemcv:'' ?></strong>
				        </div>
				        <div class="col-md-3 profile-label">
				            Sở thích
				        </div>
				        <div class="col-md-3 profile-text">
				            <strong><?= ($hocvien->noihoctap)?$hocvien->khuvuc->name:'' ?></strong>
				        </div>
				    </div>
				    
				</div>
				<div class="tab-pane" id="hoctap">
					<div class="row">
					  <div class="col-xs-12">
						<h4 class="page-header">	
						<i class="fa fa-user"></i> Thông tin học tập
						</h4>
					  </div><!-- /.col -->
					</div>
				
				</div>
				<div class="tab-pane" id="donhang">
					<div class="row">
					  <div class="col-xs-12">
						<h4 class="page-header">	
						<i class="fa fa-graduation-cap"></i> Thông tin đơn hàng
						</h4>
					  </div><!-- /.col -->
					</div>
					
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>