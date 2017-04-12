<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Donvicungcapnguon */
?>
<div class="donvicungcapnguon-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'code',
        ],
    ]) ?>

</div>
