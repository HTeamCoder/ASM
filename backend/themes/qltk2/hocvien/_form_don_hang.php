<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
 ?>
<div class="donhang-form">
    <div class="row">
         <div class="col-md-12">
            <div class="table-scrollable">
                <table class="table table-striped table-bordered table-hover" id="table-donhang">
                    <thead>
                    <tr><th>Đơn hàng</th><th>Ghi chú</th><th class="text-center">Xóa</th></tr>
                    </thead>
                    <tbody>
                    <?php if($hocvien->id == ''):?>
                        <?php foreach ($hocvien->donhangchitiets as $index=>$donhangchitiet): ?>
                            <tr>
                                    <td>
                                        <?=Html::activeTextInput($donhangchitiet,"[$index]donhang_id",['class' => 'form-control donhang','autocomplete'=>'off','value' => $donhangchitiet->donhang->name]);?>
                                    </td>
                                    <td>
                                        <?=Html::activeTextInput($donhangchitiet,"[$index]ghichu", ['class' => 'form-control ghichu','value' => $donhangchitiet->ghichu]);?>
                                    </td>
                                    <td class="action text-center btn-action">
                                        <?=Html::button('<i class="fa fa-trash"></i>',['class' => 'btn btn-sm btn-danger btn-remove', 'value' =>  $index])?>
                                    </td>
                                </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                        
                    <?=\yii\bootstrap\Html::hiddenInput('soluongdonhang',count($hocvien->donhangchitiets),['id' => 'soluongdonhang'])?>
                    </tbody>
                </table>
            </div>
         </div>
    </div>
   <?=\yii\bootstrap\Html::button('<i class="fa fa-plus"></i> Thêm đơn hàng',['class' => 'btn btn-themdonhang btn-success'])?>
    
</div>
