<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Xinghiep */
?>
<div class="xinghiep-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'code',
            'tengiamdoc',
            'diachi:ntext',
        ],
    ]) ?>

</div>
