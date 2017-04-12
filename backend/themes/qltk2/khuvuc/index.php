<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\KhuvucSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Khu vực');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="khuvuc-index">
    <div class="row">
        <div class="col-md-4">
            <div class="portlet red-pink box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i> Phân cấp khu vực
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                        <a href="javascript:;" class="reload" id="reload-tree">
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="tree_khuvuc" class="tree-demo"></div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div id="ajaxCrudDatatable">
                <?=GridView::widget([
                    'id'=>'crud-datatable',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'pjax'=>true,
                     'pjaxSettings' => [
                        'options' => [
                            'enablePushState' => false,
                        ],
                    ],
                    'columns' => require(__DIR__.'/_columns.php'),
                    'toolbar'=> [
                        ['content'=>
                            Html::a('<i class="glyphicon glyphicon-plus"></i> Thêm mới khu vực', ['create'],
                            ['role'=>'modal-remote','title'=> 'Thêm mới khu vực','class'=>'btn btn-default'])
                        ],
                    ],          
                    'striped' => true,
                    'condensed' => true,
                    'responsive' => true,          
                    'panel' => [
                        'type' => 'primary', 
                        'heading' => '<i class="glyphicon glyphicon-list"></i> Danh sách khu vực',
                        'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Xóa tất cả',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Bạn có chắc chắn không ?',
                                    'data-confirm-message'=>'Bạn chắc chắn muốn xóa dữ liệu này không ?'
                                ]),
                        ]).                        
                                '<div class="clearfix"></div>',
                    ]
                ])?>
            </div>
        </div>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<?php $this->registerCssFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/jstree/dist/themes/default/style.min.css'); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/plugins/jstree/dist/jstree.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/backend/themes/qltk2/assets/global/scripts/jsview/khuvuc.js',[ 'depends' => ['backend\assets\Qltk2Asset'], 'position' => \yii\web\View::POS_END ]); ?>