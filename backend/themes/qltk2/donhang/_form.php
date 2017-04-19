<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\Donhang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="donhang-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
        <div class="col-md-4">
             <?= $form->field($model, 'name')->textInput(['maxlength' => true,'class'=>'donhang form-control','autocomplete'=>'off']) ?>
        </div>
        <div class="col-md-4">
             <?=\common\models\myFuncs::activeDateField($form, $model, 'ngaythi','Ngày thi')?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'vunglamviec_id')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(backend\models\Vunglamviec::find()->select('id, name')->all(),'id','name'),
                'language' => 'vi',
                'options' => ['placeholder' => 'Chọn vùng làm việc ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Vùng làm việc');
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
             <?=
            $form->field($model, 'nghiepdoan_id')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(backend\models\Nghiepdoan::find()->select('id, name')->all(),'id','name'),
                'language' => 'vi',
                'options' => ['placeholder' => 'Chọn nghiệp đoàn ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Nghiệp đoàn');
            ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'xinghiep_id')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(backend\models\Xinghiep::find()->select('id, name')->all(),'id','name'),
                'language' => 'vi',
                'options' => ['placeholder' => 'Chọn xí nghiệp ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Xí nghiệp');
            ?>
        </div>
        <div class="col-md-4">
           <?=
            $form->field($model, 'donvicungcapnguon_id')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(backend\models\Donvicungcapnguon::find()->select('id, name')->all(),'id','name'),
                'language' => 'vi',
                'options' => ['placeholder' => 'Chọn đơn vị cung cấp nguồn ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Đơn vị cung cấp nguồn');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?=\common\models\myFuncs::activeDateField($form, $model, 'ngayxuatcanh','Ngày xuất cảnh')?>
        </div>
        <div class="col-md-4">
            <?=\common\models\myFuncs::activeDateField($form, $model, 'ngayvevietnam','Ngày về Việt Nam')?>
        </div>
        <div class="col-md-4">
            <?=\common\models\myFuncs::activeDateField($form, $model, 'ngaychotcv','Ngày chốt CV')?>
        </div>
    </div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/scripts/bootstrap3-typeahead.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/scripts/jsview/indexdonhang.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>