<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Chuyennganh */
?>
<div class="chuyennganh-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tenchuyennganh',
            'code',
        ],
    ]) ?>

</div>
