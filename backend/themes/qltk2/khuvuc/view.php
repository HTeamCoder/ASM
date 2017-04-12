<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Khuvuc */
?>
<div class="khuvuc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'code',
            [
                'attribute'=>'parent_id',
                'label'=>'Khu vực trực thuộc',
                'value'=> ($model->kieu == 'tinhthanh')?'':(($model->kieu == 'quanhuyen')?'Tỉnh/Thành phố '.$model->parent->name:'Quận/Huyện '.$model->parent->name)
            ]
        ],
    ]) ?>

</div>
