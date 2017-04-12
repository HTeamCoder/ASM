<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Khoa */
?>
<div class="khoa-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'code',
            'ngaybatdau',
            'ngayketthuc',
        ],
    ]) ?>

</div>
