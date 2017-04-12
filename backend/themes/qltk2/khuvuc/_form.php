<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Khuvuc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="khuvuc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kieu')->dropDownList(['tinhthanh' => 'Tỉnh/Thành phố', 'quanhuyen' => 'Quận/Huyện', 'phuongxa' => 'Phường/Xã'])->label('Phân cấp') ?>
    
   <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
        'data' =>\yii\helpers\ArrayHelper::map(\common\models\myFuncs::dsNhom($khuvuc = new \backend\models\Khuvuc(),NULL),'id','name'),
        'language' => 'vi',
           'options' => ['placeholder' => 'Không trực thuộc khu vực nào ...'],
           'pluginOptions' => [
               'allowClear' => true
           ],
        ])->label('Khu vực trực thuộc'); ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
