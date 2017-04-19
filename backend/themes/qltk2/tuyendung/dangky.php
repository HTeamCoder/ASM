<?php 
$this->title = "Đăng ký tuyển dụng | TTS ASV";
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
 ?>
<div class="thongbao"></div>
<input type="hidden" id="idhocvien" value="<?= $hocvien->id ?>">
<input type="hidden" id="urlanhdaidien" value="<?= Yii::$app->request->baseUrl?>/backend/themes/qltk2/assets/global/img/no-photo.png">
<div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> THÔNG TIN HỌC VIÊN
                    </div>
                </div>
                <div class="portlet-body">
                    <?php $form = \yii\bootstrap\ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'form-hocvien']]); ?>
                        
                            <div class="hocvien-form">

                                <?= (!$hocvien->isNewRecord)?\yii\bootstrap\Html::hiddenInput('Hocvien[id]',$hocvien->id):''?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group text-center">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                        <?php if($hocvien->isNewRecord): ?>
                                                            <img src="<?= Yii::$app->request->baseUrl?>/backend/themes/qltk2/assets/global/img/no-photo.png" alt="" class="anhdaidien"/>
                                                        <?php else: ?>
                                                            <?=\yii\bootstrap\Html::img('anhhocvien/'.$hocvien->anhdaidien)?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail " style="max-width: 200px; max-height: 150px;">
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
                                    </div>
                                    <div class="col-md-9">
                                        <div class="col-md-3">
                                            <?= $form->field($hocvien, 'ma')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Mã học viên'])->label('Mã học viên') ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?= $form->field($hocvien, 'name')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Tên học viên'])->label('Tên học viên') ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?= $form->field($hocvien, 'tentiengnhat')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Tên tiếng Nhật']) ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?=\common\models\myFuncs::activeDateField($form, $hocvien, 'ngaysinh','Ngày sinh')?>
                                        </div> 
                                        <div class="col-md-3">
                                            <?= $form->field($hocvien, 'gioitinh')->dropDownList([ 'nam' => 'Nam', 'nu' => 'Nữ', ]) ?>
                                        </div>


                                        <div class="col-md-3">
                                            <?= $form->field($hocvien, 'trinhdohocvan_id')->textInput(['class'=>'trinhdohocvan form-control','autocomplete'=>'off','placeholder'=>'Trình độ học vấn'])->label('TrÌnh độ học vấn') ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?= $form->field($hocvien, 'noihoctap')->textInput(['class'=>'noihoctap form-control','autocomplete'=>'off','placeholder'=>'Nơi học tập'])->label('Nơi học tập') ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?= $form->field($hocvien, 'tinhtranghonnhan')->dropDownList([ 'docthan' => 'Độc thân', 'dakethon' => 'Đã kết hôn']) ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?= $form->field($hocvien, 'diachi')->textInput(['placeholder'=>'Địa chỉ nơi ở'])->label('Địa chỉ nơi ở'); ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?= $form->field($hocvien, 'phuongxa')->textInput(['class'=>'khuvucxa form-control','autocomplete'=>'off','placeholder'=>'Phường/Xã'])->label('Phường/Xã'); ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?= $form->field($hocvien, 'quanhuyen')->textInput(['class'=>'khuvuchuyen form-control','autocomplete'=>'off','placeholder'=>'Quận/Huyện'])->label('Quận/Huyện'); ?>
                                        </div>
                                        <div class="col-md-3">
                                            <?= $form->field($hocvien, 'tinhthanh')->textInput(['class'=>'khuvuctinh form-control','autocomplete'=>'off','placeholder'=>'Tỉnh/Thành'])->label('Tỉnh/Thành'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <?= $form->field($hocvien, 'noisinh')->textInput(['class'=>'noisinh form-control','autocomplete'=>'off','placeholder'=>'Nơi sinh'])->label('Nơi sinh') ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($hocvien, 'dienthoai')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Số điện thoại cá'])->label('Điện thoại(Di động, cố định)') ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($hocvien, 'dienthoaikhancap')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Số điện thoại liên hệ gia đình'])->label('Số điện thoại liên hệ gia đình') ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($hocvien, 'congtacvien_id')->textInput(['class'=>'congtacvien form-control','autocomplete'=>'off','placeholder'=>'Cộng tác viên'])->label('Cộng tác viên') ?>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <?= $form->field($hocvien, 'cmnd')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Số CMND']) ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?=\common\models\myFuncs::activeDateField($form, $hocvien, 'ngaycap','Ngày cấp')?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($hocvien, 'noicap')->textInput(['class'=>'noicap form-control','autocomplete'=>'off','placeholder'=>'Nơi cấp'])->label('Nơi cấp') ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($hocvien, 'daunguon')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Đầu nguồn']) ?>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $form->field($hocvien, 'kinhnghiemcv')->textarea(['rows' => 3]) ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($hocvien, 'sothich')->textarea(['rows' => 3]) ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <?= $form->field($hocvien, 'benhvien_id')->textInput(['class'=>'benhvien form-control','autocomplete'=>'off','placeholder'=>'Bệnh viện khám bệnh'])->label('Bệnh viện khám bệnh') ?>
                                    </div>
                                    <div class="col-md-3">
                                       <?= $form->field($hocvien, 'taythuan')->dropDownList([ 'phai' => 'Phải', 'trai' => 'Trái', ]) ?>
                                    </div>
                                    <div class="col-md-3">
                                         <?= $form->field($hocvien, 'thiluc')->textInput(['autocomplete'=>'off','type' => 'number','min'=>0,'max'=>10]) ?>
                                    </div>
                                    <div class="col-md-3">
                                       <?= $form->field($hocvien, 'hinhxam')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Hình xăm']) ?>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <?=\common\models\myFuncs::activeDateField($form, $hocvien, 'ngaykham','Ngày khám bệnh')?>
                                    </div>

                                    <div class="col-md-3">
                                        <?= $form->field($hocvien, 'chieucao')->textInput(['maxlength' => true,'autocomplete'=>'off','type'=>'number','min'=>1,'placeholder'=>'Chiều cao'])->label('Chiều cao (cm)') ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($hocvien, 'cannang')->textInput(['maxlength' => true,'autocomplete'=>'off','type'=>'number','min'=>1,'placeholder'=>'Cân nặng'])->label('Cân nặng (kg)') ?>
                                    </div>
                                    <div class="col-md-3">
                                        <?= $form->field($hocvien, 'nhommau_id')->textInput(['class'=>'nhommau form-control','autocomplete'=>'off','placeholder'=>'Nhóm máu'])->label('Nhóm máu') ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?= $form->field($hocvien, 'ghichuthetrang')->textarea(['rows' => 1]) ?>
                                    </div>
                                </div>

                                
                            </div>
                    <?php \yii\bootstrap\ActiveForm::end(); ?>
                </div>
</div>
<?=\yii\bootstrap\Html::button('<i class="fa fa-save"></i> Lưu và đăng ký học viên mới',['class' => 'btn btn-dangky btn-success','data-type'=>'new'])?>
<?=\yii\bootstrap\Html::button('<i class="fa fa-save"></i> Lưu và quay lại danh sách học viên',['class' => 'btn btn-dangky btn-success','data-type'=>'old'])?>
<?= Html::a('<i class="fa fa-arrow-left"></i> Hủy và quay lại danh sách',Url::toRoute(['tuyendung/dangky']),
                    ['title'=> 'Đăng ký tuyển dụng','class'=>'btn btn-warning','data-pjax'=>0])?>
<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/scripts/bootstrap3-typeahead.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/scripts/jsview/dangky.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>