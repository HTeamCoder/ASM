<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 ?>
<div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> THÔNG TIN HỌC VIÊN
                    </div>
                </div>
                <div class="portlet-body">
                    <?php $form = \yii\bootstrap\ActiveForm::begin(['options' => ['id' => 'form-hocvien']]); ?>

                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($hocvien, 'ma')->textInput(['maxlength' => true,'autocomplete'=>'off'])->label('Mã học viên') ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($hocvien, 'name')->textInput(['maxlength' => true,'autocomplete'=>'off'])->label('Tên học viên') ?>
                        </div>
                        <div class="col-md-4">
                           <?= $form->field($hocvien, 'tentiengnhat')->textInput(['maxlength' => true,'autocomplete'=>'off']) ?>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <?=\common\models\myFuncs::activeDateField($form, $hocvien, 'ngaysinh','Ngày sinh')?>
                        </div>
                        <div class="col-md-4">
                           <?= $form->field($hocvien, 'gioitinh')->dropDownList([ 'nam' => 'Nam', 'nu' => 'Nữ', ]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($hocvien, 'trinhdohocvan_id')->textInput(['class'=>'trinhdohocvan form-control','autocomplete'=>'off'])->label('TrÌnh độ học vấn') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                             <?= $form->field($hocvien, 'dienthoai')->textInput(['maxlength' => true,'autocomplete'=>'off'])->label('Điện thoại(Di động, cố định)') ?>
                        </div>
                        <div class="col-md-4">
                             <?= $form->field($hocvien, 'cmnd')->textInput(['maxlength' => true,'autocomplete'=>'off']) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($hocvien, 'noisinh')->textInput(['class'=>'noisinh form-control','autocomplete'=>'off'])->label('Nơi sinh') ?>
                        </div>
                    </div>
                    <?php \yii\bootstrap\ActiveForm::end(); ?>
                </div>
</div>
<div class="portlet box blue-hoki">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> THÔNG TIN ĐƠN HÀNG
                    </div>
                </div>
                <div class="portlet-body">
                    <?php $form = \yii\bootstrap\ActiveForm::begin(['options' => ['id' => 'form-donhangchitiet']]); ?>

                     <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover" id="table-donhang">
                            <thead>
                            <tr><th>Đơn hàng</th><th>Ngày thi</th><th>Ngày đỗ</th><th>Ghi chú</th><th class="text-center">Xóa</th></tr>
                            </thead>
                            <tbody>
                            <?php if($hocvien->id != ''):?>
                                <?php foreach ($hocvien->donhangchitiets as $index=>$donhangchitiet): ?>
                                    <tr>
                                            <td>
                                                <?=Html::activeTextInput($donhangchitiet,"[$index]donhang_id",['class' => 'form-control donhang','autocomplete'=>'off','value' => $donhangchitiet->donhang->name]);?>
                                            </td>
                                            <td>
                                                <?=Html::activeTextInput($donhangchitiet,"[$index]ghichu", ['class' => 'form-control ghichu','value' => $donhangchitiet->ghichu]);?>
                                            </td>
                                            <td class="ngaythi"><?= $donhangchitiet->donhang->ngaythi ?></td>
                                            <td class="ngaydo"><?= $donhangchitiet->donhang->ngaydo ?></td>
                                            <td class="action text-center btn-action">
                                                <?=Html::button('<i class="fa fa-trash"></i>',['class' => 'btn btn-sm btn-danger btn-remove', 'value' =>  $index])?>
                                            </td>
                                        </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                 <tr>
                                            <td>
                                                <?=Html::activeTextInput($donhangchitiet,"[0]donhang_id",['class' => 'form-control donhang','autocomplete'=>'off','value' => '']);?>
                                            </td>
                                            <td>
                                                <?=Html::activeTextInput($donhangchitiet,"[0]ghichu", ['class' => 'form-control ghichu','value' => '']);?>
                                            </td>
                                            <td class="ngaythi"></td>
                                            <td class="ngaydo"></td>
                                            <td class="action text-center btn-action">
                                                <?=Html::button('<i class="fa fa-trash"></i>',['class' => 'btn btn-sm btn-danger btn-remove', 'value' =>  0])?>
                                            </td>
                                        </tr>
                            <?php endif; ?>
                                
                            <?=\yii\bootstrap\Html::hiddenInput('soluongdonhang',count($hocvien->donhangchitiets),['id' => 'soluongdonhang'])?>
                            </tbody>
                        </table>
                    </div>
                    <?php \yii\bootstrap\ActiveForm::end(); ?>
                </div>
</div>
<?=\yii\bootstrap\Html::button('<i class="fa fa-print"></i> Lưu lại',['class' => 'btn btn-print-save btn-success'])?>