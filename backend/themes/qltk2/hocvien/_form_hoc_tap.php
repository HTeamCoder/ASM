<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 ?>
<div class="hoctap-form">


    
    <div class="row">
        <div class="col-md-4">
             <?= $form->field($khoa, 'name')->textInput(['maxlength' => true,'class'=>'form-control khoahoc','autocomplete'=>'off']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($lop, 'name')->textInput(['maxlength' => true,'class'=>'form-control lophoc','autocomplete'=>'off']) ?>
        </div>
        <div class="col-md-4">
           <?=\common\models\myFuncs::activeDateField($form, $hocvien, 'ngaynhaptruong','Ngày nhập trường')?>
        </div>
    </div>

    
</div>
