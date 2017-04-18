<?php
use yii\helpers\Url;
use yii\helpers\Html;
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '3%',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '3%',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'anhdaidien',
        'value'=>function($data)
        {
            return \yii\bootstrap\Html::img('anhhocvien/'.$data->anhdaidien,['class'=>'img-circle','style'=>'width:50px;height:50px;']);
        },
        'format'=>'html',
         'contentOptions' => ['class' => 'text-center','style'=>'width:3%;'],
        'headerOptions' => ['class' => 'text-center','style'=>'width:3%;'],
        'label'=>'Ảnh hồ sơ'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ma',
         'contentOptions' => ['class' => 'text-center','style'=>'width:10%;'],
        'headerOptions' => ['class' => 'text-center','style'=>'width:10%;']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
         'contentOptions' => ['class' => 'text-left','style'=>'width:15%;'],
        'headerOptions' => ['class' => 'text-left','style'=>'width:15%;']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngaysinh',
        'value'=>function($data){
            return date('d/m/Y',strtotime($data->ngaysinh));
        },
        'contentOptions' => ['class' => 'text-left','style'=>'width:8%;'],
        'headerOptions' => ['class' => 'text-left','style'=>'width:8%;'],
        'label'=>'Ngày sinh',
        'filter'=>false
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'gioitinh',
        'value'=>function($data)
        {
            return ($data->gioitinh == 'nu')?'Nữ':'Nam';
        },
        'filter'=>Html::activeDropDownList($searchModel,'gioitinh',\yii\helpers\ArrayHelper::map([
            ['id' =>'nu', 'name' => 'Nữ'], ['id' => 'nam', 'name' => 'Nam'],
        ],'id','name'),['prompt' => 'Tất cả','class' => 'form-control']),
        'contentOptions' => ['class' => 'text-center','style'=>'width:8%;'],
        'headerOptions' => ['class' => 'text-center','style'=>'width:8%;'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'dienthoai',
        'contentOptions' => ['class' => 'text-center','style'=>'width:8%;'],
        'headerOptions' => ['class' => 'text-center','style'=>'width:8%;'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cmnd',
        'contentOptions' => ['class' => 'text-center','style'=>'width:8%;'],
        'headerOptions' => ['class' => 'text-center','style'=>'width:8%;'],
    ],

];   