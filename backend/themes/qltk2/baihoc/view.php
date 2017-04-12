<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Baihoc */
?>
<div class="baihoc-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'code',
        ],
    ]) ?>

</div>
