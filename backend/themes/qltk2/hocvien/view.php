<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Hocvien */
?>
<div class="hocvien-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ma',
            'name',
            'code',
            'tentiengnhat',
            'gioitinh',
            'ngaysinh',
            'tuoi',
            'diachi',
            'dienthoai',
            'dienthoaikhancap',
            'tinhtranghonnhan',
            'cmnd',
            'ngaycap',
            'kinhnghiemcv:ntext',
            'sothich',
            'chieucao',
            'cannang',
            'taythuan',
            'daunguon',
            'thiluc',
            'hinhxam',
            'ngaynhaptruong',
            'ngaykham',
            'ghichuthetrang:ntext',
            'lop_id',
            'benhvien_id',
            'nhommau_id',
            'trinhdohocvan_id',
            'congtacvien_id',
            'loaidanhsach_id',
            'khuvuc_id',
            'noicap',
            'noihoctap',
            'noisinh',
        ],
    ]) ?>

</div>
