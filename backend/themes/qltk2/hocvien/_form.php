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
            <?= $form->field($model, 'name')->textInput(['maxlength' => true,'autocomplete'=>'off'])->label('Tên học viên') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'tentiengnhat')->textInput(['maxlength' => true,'autocomplete'=>'off']) ?>
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
            <?= $form->field($model, 'trinhdohocvan_id')->textInput(['class'=>'trinhdohocvan form-control','autocomplete'=>'off'])->label('TrÌnh độ học vấn') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'noihoctap')->textInput(['class'=>'noihoctap form-control','autocomplete'=>'off'])->label('Nơi học tập') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'tinhtranghonnhan')->dropDownList([ 'docthan' => 'Độc thân', 'dakethon' => 'Đã kết hôn']) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'diachi')->textInput()->label('Địa chỉ nơi ở'); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phuongxa')->textInput(['class'=>'khuvucxa form-control','autocomplete'=>'off'])->label('Phường/Xã'); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'quanhuyen')->textInput(['class'=>'khuvuchuyen form-control','autocomplete'=>'off'])->label('Quận/Huyện'); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'tinhthanh')->textInput(['class'=>'khuvuctinh form-control','autocomplete'=>'off'])->label('Tỉnh/Thành'); ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'noisinh')->textInput(['class'=>'noisinh form-control','autocomplete'=>'off'])->label('Nơi sinh') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'dienthoai')->textInput(['maxlength' => true,'autocomplete'=>'off'])->label('Điện thoại(Di động, cố định)') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'dienthoaikhancap')->textInput(['maxlength' => true,'autocomplete'=>'off'])->label('Số điện thoại liên hệ gia đình') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'congtacvien_id')->textInput(['class'=>'congtacvien form-control','autocomplete'=>'off'])->label('Cộng tác viên') ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'cmnd')->textInput(['maxlength' => true,'autocomplete'=>'off']) ?>
        </div>
        <div class="col-md-3">
            <?=\common\models\myFuncs::activeDateField($form, $model, 'ngaycap','Ngày cấp')?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'noicap')->textInput(['class'=>'noicap form-control','autocomplete'=>'off'])->label('Nơi cấp') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'daunguon')->textInput(['maxlength' => true,'autocomplete'=>'off']) ?>
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
            <?= $form->field($model, 'benhvien_id')->textInput(['class'=>'benhvien form-control','autocomplete'=>'off'])->label('Bệnh viện khám bệnh') ?>
        </div>
        <div class="col-md-3">
           <?= $form->field($model, 'taythuan')->dropDownList([ 'phai' => 'Phải', 'trai' => 'Trái', ]) ?>
        </div>
        <div class="col-md-3">
             <?= $form->field($model, 'thiluc')->textInput(['autocomplete'=>'off','type' => 'number','min'=>0,'max'=>10]) ?>
        </div>
        <div class="col-md-3">
           <?= $form->field($model, 'hinhxam')->textInput(['maxlength' => true,'autocomplete'=>'off']) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-3">
            <?=\common\models\myFuncs::activeDateField($form, $model, 'ngaykham','Ngày khám bệnh')?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'chieucao')->textInput(['maxlength' => true,'autocomplete'=>'off','type'=>'number','min'=>1])->label('Chiều cao (cm)') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'cannang')->textInput(['maxlength' => true,'autocomplete'=>'off','type'=>'number','min'=>1])->label('Cân nặng (kg)') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'nhommau_id')->textInput(['class'=>'nhommau form-control','autocomplete'=>'off'])->label('Nhóm máu') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'ghichuthetrang')->textarea(['rows' => 1]) ?>
        </div>
    </div>


    
</div>
