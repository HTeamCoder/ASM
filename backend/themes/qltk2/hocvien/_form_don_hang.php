<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 ?>
<div class="donhang-form">

  
    
    <div class="row">
        <div class="col-md-6">
             <?= $form->field($donhang, 'donhang_id')->textInput(['maxlength' => true,'class'=>'form-control donhang','autocomplete'=>'off'])->label('Đơn hàng') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($donhang, 'ghichu')->textInput(['maxlength' => true]) ?>
        </div
    </div>

    
</div>
