<?php
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\grid\GridView;
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
         'contentOptions' => ['class' => 'text-center','style'=>'width:35%;'],
        'headerOptions' => ['class' => 'text-center','style'=>'width:35%;']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'kieu',
        'label'=>'Phân cấp',
        'value'=>function($data)
        {
            return ($data->kieu == 'tinhthanh')?'Tỉnh/Thành phố':($data->kieu == 'quanhuyen'?'Quận/Huyện':'Phường/Xã');
        },
        'contentOptions' => ['class' => 'text-center','style'=>'width:30%;'],
        'headerOptions' => ['class' => 'text-center','style'=>'width:30%;'],
        'filterType'=>GridView::FILTER_SELECT2,
        'filter'=> \yii\helpers\ArrayHelper::map([
            ['id' =>'tinhthanh', 'name' => 'Tỉnh/Thành phố'], ['id' => 'quanhuyen', 'name' => 'Quận/Huyện'],['id'=>'phuongxa','name'=>'Phường/Xã']], 'id', 'name'), 
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Chọn...'],
        'format'=>'raw'
    ],
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
            return \yii\bootstrap\Html::a('<i class="fa fa-trash"></i>',Url::to(['delete','id'=>$data->id]), ['class' => 'text-gray','role'=>'modal-remote','id'=>'btn-save','title'=>'Delete', 
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