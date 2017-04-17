<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '3%',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '3%',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'code',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'ngaythi',
        
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'diachilienhe',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'noilamviec',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ghichu',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ngaydo',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'vunglamviec_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nghiepdoan_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'xinghiep_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'noidaotaosautrungtuyen_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'donvicungcapnguon_id',
    // ],
    [
        'value' => function($data){
            return \yii\bootstrap\Html::a('<i class="fa fa-eye"></i>',Url::to(['view','id'=>$data->id]), ['class' => 'text-gray','role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip']);
        },
        'label' => 'Xem',
        'format' => 'raw',
        'contentOptions' => ['class' => 'text-center','style'=>'width:3%;'],
        'headerOptions' => ['class' => 'text-center','style'=>'width:3%;']
    ],
    [
        'value' => function($data){
            return \yii\bootstrap\Html::a('<i class="fa fa-edit"></i>',Url::to(['update','id'=>$data->id]), ['class' => 'text-gray','role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip']);
        },
        'label' => 'Sửa',
        'format' => 'raw',
        'contentOptions' => ['class' => 'text-center','style'=>'width:3%;'],
        'headerOptions' => ['class' => 'text-center','style'=>'width:3%;']
    ],
    [
        'value' => function($data){
            return \yii\bootstrap\Html::a('<i class="fa fa-trash"></i>',Url::to(['delete','id'=>$data->id]), ['class' => 'text-gray','role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                           'data-confirm-title'=>'Bạn có chắc chắn không ?',
                            'data-confirm-message'=>'Bạn có chắc chắn muốn xóa không ?']);
        },
        'label' => 'Xóa',
        'format' => 'raw',
        'contentOptions' => ['class' => 'text-center','style'=>'width:3%;'],
        'headerOptions' => ['class' => 'text-center','style'=>'width:3%;']
    ]

];   