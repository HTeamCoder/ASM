<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Hocvien */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hocvien-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ma')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tentiengnhat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gioitinh')->dropDownList([ 'nam' => 'Nam', 'nu' => 'Nu', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'ngaysinh')->textInput() ?>

    <?= $form->field($model, 'tuoi')->textInput() ?>

    <?= $form->field($model, 'diachi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dienthoai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dienthoaikhancap')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tinhtranghonnhan')->dropDownList([ 'docthan' => 'Docthan', 'dakethon' => 'Dakethon', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'cmnd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ngaycap')->textInput() ?>

    <?= $form->field($model, 'kinhnghiemcv')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sothich')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'chieucao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cannang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'taythuan')->dropDownList([ 'phai' => 'Phai', 'trai' => 'Trai', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'daunguon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thiluc')->textInput() ?>

    <?= $form->field($model, 'hinhxam')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ngaynhaptruong')->textInput() ?>

    <?= $form->field($model, 'ngaykham')->textInput() ?>

    <?= $form->field($model, 'ghichuthetrang')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'lop_id')->textInput() ?>

    <?= $form->field($model, 'benhvien_id')->textInput() ?>

    <?= $form->field($model, 'nhommau_id')->textInput() ?>

    <?= $form->field($model, 'trinhdohocvan_id')->textInput() ?>

    <?= $form->field($model, 'congtacvien_id')->textInput() ?>

    <?= $form->field($model, 'loaidanhsach_id')->textInput() ?>

    <?= $form->field($model, 'khuvuc_id')->textInput() ?>

    <?= $form->field($model, 'noicap')->textInput() ?>

    <?= $form->field($model, 'noihoctap')->textInput() ?>

    <?= $form->field($model, 'noisinh')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
