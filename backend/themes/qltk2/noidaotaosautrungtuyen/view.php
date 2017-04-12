<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Noidaotaosautrungtuyen */
?>
<div class="noidaotaosautrungtuyen-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'code',
        ],
    ]) ?>

</div>
