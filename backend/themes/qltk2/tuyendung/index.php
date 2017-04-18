<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\HocvienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Danh sách tuyển dụng';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="hocvien-index">
    <div class="thongbao"></div>
    <?=  Html::a('<i class="glyphicon glyphicon-plus"></i> Đăng ký tuyển dụng',Url::toRoute(['tuyendung/dangky']),['title'=> 'Đăng ký tuyển dụng','class'=>'btn btn-success pull-right mg-bot-10']) ?>
   <?php \yii\widgets\Pjax::begin(['id' => 'grid-phieunhapxuat', 'enablePushState' =>false]); ?>
        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function ($model, $key, $index, $grid){
                return ['class' => 'row-hocvien', 'id' => 'hocvien-'.$model->idhocvien];
            },  
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'anhdaidien',
                    'value' => function($data){
                         return \yii\bootstrap\Html::img('anhhocvien/'.$data->anhdaidien,['class'=>'img-circle','style'=>'width:50px;height:50px;']);
                    },
                    'format' => 'html',
                    'filter'=>false
                ],
                [
                    'attribute' => 'mahocvien',
                    'value' => function($data){
                        return (isset($data->mahocvien))?$data->mahocvien:'';
                    },
                ],
                [
                    'attribute' => 'tenhocvien',
                    'value' => function($data){
                        return ($data->tenhocvien)?$data->tenhocvien:'';
                    }
                ],
                [
                    'attribute' => 'tendonhang',
                    'value' => function($data){
                        return ($data->tendonhang)?$data->tendonhang:'';
                    },
                ],
                [
                    'attribute' => 'ngaythi',
                    'value' => function($data){
                        return ($data->ngaythi)?date('d/m/Y',strtotime($data->ngaythi)):'';
                    },
                ],
                [
                    'attribute' => 'ngaydo',
                    'value' => function($data){
                        return ($data->ngaydo)?date('d/m/Y',strtotime($data->ngaydo)):'';
                    },
                ],

            ],
        ]); ?>
        <?php \yii\widgets\Pjax::end(); ?>
</div>
<?php Modal::begin([
    'header' => '<h4 style="margin:0;" id="modal-title">Hồ sơ học viên</h4>',
    "id"=>"chitiethocvien",
    "footer"=>'<button type="button" class="btn btn-close" data-dismiss="modal">Đóng</button>',
    'size'=>'modal-lg'
])?>
<div class="box-chitiethocvien"></div>
<?php Modal::end(); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/scripts/jsview/indexhocvien.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>