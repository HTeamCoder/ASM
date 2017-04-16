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

$this->title = 'Học viên';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="hocvien-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm mới học viên',Url::toRoute(['hocvien/themhocvien']),
                    ['title'=> 'Thêm mới học viên','class'=>'btn btn-success'])
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,    
            'rowOptions' => function ($model, $key, $index, $grid){
                return ['class' => 'row-hocvien', 'id' => 'hocvien-'.$model->id];
            },      
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Danh sách học viên',
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Are you sure?',
                                    'data-confirm-message'=>'Are you sure want to delete this item'
                                ]),
                        ]).                        
                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/scripts/jsview/indexhocvien.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>