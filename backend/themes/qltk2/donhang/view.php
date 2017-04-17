<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Donhang */
?>
<div class="donhang-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'code',
            'thoigiantaptrung',
            'ngaythi',
            'diachilienhe:ntext',
            'noilamviec',
            'ghichu:ntext',
            'ngaydo',
            'vunglamviec_id',
            'nghiepdoan_id',
            'xinghiep_id',
            'noidaotaosautrungtuyen_id',
            'donvicungcapnguon_id',
        ],
    ]) ?>

</div>
