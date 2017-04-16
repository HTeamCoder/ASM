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
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'anhdaidien',
        'value'=>function($data)
        {
            return \yii\bootstrap\Html::img('anhhocvien/'.$data->anhdaidien,['style'=>'width:50px;height:50px;']);
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
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ngaysinh',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tuoi',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'diachi',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'dienthoai',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'dienthoaikhancap',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tinhtranghonnhan',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'cmnd',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ngaycap',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'kinhnghiemcv',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'sothich',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'chieucao',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'cannang',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'taythuan',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'daunguon',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'thiluc',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'hinhxam',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ngaynhaptruong',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ngaykham',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ghichuthetrang',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'lop_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'benhvien_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nhommau_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'trinhdohocvan_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'congtacvien_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'loaidanhsach_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'khuvuc_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'noicap',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'noihoctap',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'noisinh',
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