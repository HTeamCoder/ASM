<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Hocvien */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hocvien-form">

    <?= (!$model->isNewRecord)?\yii\bootstrap\Html::hiddenInput('Hocvien[id]',$model->id):''?>
    <div class="row">
        <div class="col-md-3">
             <?= $form->field($model, 'ma')->textInput(['maxlength' => true,'autocomplete'=>'off'])->label('Mã học viên') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Tên học viên'])->label('Tên học viên') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'tentiengnhat')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Tên tiếng Nhật']) ?>
        </div>
        <div class="col-md-3">
            <?=\common\models\myFuncs::activeDateField($form, $model, 'ngaysinh','Ngày sinh')?>
        </div>  
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'gioitinh')->dropDownList([ 'nam' => 'Nam', 'nu' => 'Nữ', ]) ?>
        </div>


        <div class="col-md-3">
            <?= $form->field($model, 'trinhdohocvan_id')->textInput(['class'=>'trinhdohocvan form-control','autocomplete'=>'off','placeholder'=>'Trình độ học vấn'])->label('TrÌnh độ học vấn') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'noihoctap')->textInput(['class'=>'noihoctap form-control','autocomplete'=>'off','placeholder'=>'Nơi học tập'])->label('Nơi học tập') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'tinhtranghonnhan')->dropDownList([ 'docthan' => 'Độc thân', 'dakethon' => 'Đã kết hôn']) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'diachi')->textInput(['placeholder'=>'Địa chỉ nơi ở'])->label('Địa chỉ nơi ở'); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phuongxa')->textInput(['class'=>'khuvucxa form-control','autocomplete'=>'off','placeholder'=>'Phường/Xã'])->label('Phường/Xã'); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'quanhuyen')->textInput(['class'=>'khuvuchuyen form-control','autocomplete'=>'off','placeholder'=>'Quận/Huyện'])->label('Quận/Huyện'); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'tinhthanh')->textInput(['class'=>'khuvuctinh form-control','autocomplete'=>'off','placeholder'=>'Tỉnh/Thành'])->label('Tỉnh/Thành'); ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'noisinh')->textInput(['class'=>'noisinh form-control','autocomplete'=>'off','placeholder'=>'Nơi sinh'])->label('Nơi sinh') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'dienthoai')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Số điện thoại cá'])->label('Điện thoại(Di động, cố định)') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'dienthoaikhancap')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Số điện thoại liên hệ gia đình'])->label('Số điện thoại liên hệ gia đình') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'congtacvien_id')->textInput(['class'=>'congtacvien form-control','autocomplete'=>'off','placeholder'=>'Cộng tác viên'])->label('Cộng tác viên') ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'cmnd')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Số CMND']) ?>
        </div>
        <div class="col-md-3">
            <?=\common\models\myFuncs::activeDateField($form, $model, 'ngaycap','Ngày cấp')?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'noicap')->textInput(['class'=>'noicap form-control','autocomplete'=>'off','placeholder'=>'Nơi cấp'])->label('Nơi cấp') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'daunguon')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Đầu nguồn']) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'kinhnghiemcv')->textarea(['rows' => 3]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'sothich')->textarea(['rows' => 3]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'benhvien_id')->textInput(['class'=>'benhvien form-control','autocomplete'=>'off','placeholder'=>'Bệnh viện khám bệnh'])->label('Bệnh viện khám bệnh') ?>
        </div>
        <div class="col-md-3">
           <?= $form->field($model, 'taythuan')->dropDownList([ 'phai' => 'Phải', 'trai' => 'Trái', ]) ?>
        </div>
        <div class="col-md-3">
             <?= $form->field($model, 'thiluc')->textInput(['autocomplete'=>'off','type' => 'number','min'=>0,'max'=>10]) ?>
        </div>
        <div class="col-md-3">
           <?= $form->field($model, 'hinhxam')->textInput(['maxlength' => true,'autocomplete'=>'off','placeholder'=>'Hình xăm']) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-3">
            <?=\common\models\myFuncs::activeDateField($form, $model, 'ngaykham','Ngày khám bệnh')?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'chieucao')->textInput(['maxlength' => true,'autocomplete'=>'off','type'=>'number','min'=>1,'placeholder'=>'Chiều cao'])->label('Chiều cao (cm)') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'cannang')->textInput(['maxlength' => true,'autocomplete'=>'off','type'=>'number','min'=>1,'placeholder'=>'Cân nặng'])->label('Cân nặng (kg)') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'nhommau_id')->textInput(['class'=>'nhommau form-control','autocomplete'=>'off','placeholder'=>'Nhóm máu'])->label('Nhóm máu') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'ghichuthetrang')->textarea(['rows' => 1]) ?>
        </div>
    </div>


    
</div>
