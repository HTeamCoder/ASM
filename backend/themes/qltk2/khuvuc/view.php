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
            'parent_id',
            'child_id',
        ],
    ]) ?>

</div>
