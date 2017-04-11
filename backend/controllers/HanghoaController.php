<?php

namespace backend\controllers;

use backend\models\Chitietxuatnhapkho;
use common\models\myFuncs;
use Yii;
use backend\models\Hanghoa;
use backend\models\search\HanghoaSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * HanghoaController implements the CRUD actions for Hanghoa model.
 */
class HanghoaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Hanghoa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HanghoaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Hanghoa model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> "Hàng hóa #".$id,
                'content'=>$this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::a('Cập nhật',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
            ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Hanghoa model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Hanghoa();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mặt hàng mới",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mặt hàng mới",
                    'content'=>'<span class="text-success">Một mặt hàng đã được thêm vào danh mục</span>',
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('Tạo thêm',['create'],['class'=>'btn btn-primary','role'=>'modal-remote']),
                        'error'=>true

                ];
            }else{
                return [
                    'title'=> "Thêm mặt hàng mới",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"]),
                    'error'=>$model->getErrors()

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Updates an existing Hanghoa model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Sửa thông tin hàng hóa {$model->id}",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Hàng hóa #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                return [
                    'title'=> "Sửa thông tin hàng hóa {$model->id}",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng lại',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Hanghoa model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

    /**
     * Delete multiple existing Hanghoa model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the Hanghoa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hanghoa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Hanghoa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetinfo(){
        if(isset($_POST['mahang'])){
            if(isset($_POST['idHTMLMaHang'])){
                $idHTMLMaHang = $_POST['idHTMLMaHang'];
                $index = explode('-',$idHTMLMaHang)[1]; // ..-1-...
            }
            else
                $index = -1;
            /** @var  $hanghoa  Hanghoa*/
            $hanghoa = Hanghoa::find()->where(['ma' => $_POST['mahang']])->one();
            if(count($hanghoa) > 0)
                echo Json::encode(['donvitinh' => $hanghoa->donvitinh->name, 'nhomloaihang' => $hanghoa->nhomloaihang->name,'hanghoa' => $hanghoa, 'slhanghoa' => 1]);
            else{
                echo Json::encode([
                    'donvitinh' => Html::activeTextInput(new Hanghoa(),"[$index]donvitinh_id",['class' => 'form-control']),
                    'nhomloaihang' => Html::activeTextInput(new Hanghoa(), "[$index]nhomloaihang_id",['class' => 'form-control']),
                    'slhanghoa' => 0,
                    'index' => $index
                ]);
            }
        }
    }

    public function actionGetrowinfo(){
        $db = \Yii::$app->getDb()->createCommand("SELECT vk_gianhaptrungbinh(:id,:thoigian) AS giavon");
        if(isset($_POST['mahang'])){
            $hanghoa = Hanghoa::find()->where(['ma'=>$_POST['mahang']])->one();
            /** @var $hanghoa Hanghoa */
            $db->bindValue(":id",$hanghoa->id);
            $db->bindValue(":thoigian",(isset($_POST['thoigian'])&&$_POST['thoigian']!='')?myFuncs::convertDateSaveIntoDb($_POST['thoigian']):date('Y-m-d'));
            $data = $db->queryAll();
            $hanghoa->donvitinh_id = $hanghoa->donvitinh->name;
            $hanghoa->nhomloaihang_id = number_format($data[0]['giavon'],0,'','.');
        }else{
            /** @var  $chitietphieunhap Chitietxuatnhapkho */
            $chitietphieunhap = Chitietxuatnhapkho::find()->where(['serialnumber' => $_POST['serial']])->one();
            if(count($chitietphieunhap) > 0){
                $hanghoa = $chitietphieunhap->hanghoa;
                $hanghoa->donvitinh_id = $hanghoa->donvitinh->name;
                $db->bindValue(":id",$hanghoa->id);
                $db->bindValue(":thoigian",(isset($_POST['thoigian'])&&$_POST['thoigian']!='')?myFuncs::convertDateSaveIntoDb($_POST['thoigian']):date('Y-m-d'));
                $data = $db->queryAll();
                $hanghoa->nhomloaihang_id = number_format($data[0]['giavon'],0,'','.');
            }
        }

        echo Json::encode($hanghoa);
    }

    public function actionTimkiemdathang(){
        $soluongmathang = $_POST['soluongmathang'];

        if($_POST['kieutimkiem'] == 'serial'){
            /** @var $chitietnhapkho Chitietxuatnhapkho */
            $chitietnhapkho = Chitietxuatnhapkho::find()->where(['serialnumber' => trim($_POST['giatri'])])->one();
            if(count($chitietnhapkho) > 0)
                echo Json::encode(['timthay' => true, 'row' => $this->renderAjax('../nhapxuathang/_rowdathang',['hanghoa' => $chitietnhapkho->hanghoa, 'soluongmathang' => $soluongmathang, 'chitietxuatnhapkho' => new Chitietxuatnhapkho()])]);
            else
                echo Json::encode(['timthay' => false, 'message' => myFuncs::getMessage('Không thể tìm thấy','warning','Không thể tìm thấy hàng hóa có serial tương ứng')]);
        }else{
            $hanghoa = Hanghoa::find()->where(['ma' => $_POST['giatri']])->one();
            if(count($hanghoa) > 0)
                echo Json::encode(['timthay' => true, 'row' => $this->renderAjax('../nhapxuathang/_rowdathang',['hanghoa' => $hanghoa, 'soluongmathang' => $soluongmathang, 'chitietxuatnhapkho' => new Chitietxuatnhapkho()])]);
            else
                echo Json::encode(['timthay' => false, 'message' => myFuncs::getMessage('Không thể tìm thấy','warning','Không thể tìm thấy hàng hóa có mã hàng tương ứng')]);
        }
    }
}
