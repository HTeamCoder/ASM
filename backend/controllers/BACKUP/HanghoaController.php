<?php

namespace backend\controllers;

use backend\models\Chitietkho;
use backend\models\Chitietmuaban;
use backend\models\Hanghoadvt;
use backend\models\Kho;
use backend\models\Khohanghoa;
use backend\models\Muabanhang;
use backend\models\Quydoidonvitinh;
use common\models\myFuncs;
use Yii;
use backend\models\Hanghoa;
use backend\models\search\HanghoaSearch;
use yii\bootstrap\ActiveForm;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;
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
                    'title'=> "Hanghoa #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
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
        $quyDoiDVT = [0 => new Quydoidonvitinh()];

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new Hanghoa",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'quyDoiDVT' => $quyDoiDVT
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit", 'id' => 'btn-save'])
        
                ];         
            }else if($model->load($request->post())){
                $dvtValidate = true;

                if(isset($_POST['Quydoidonvitinh'])){
                    $quyDoiDVT = [];
                    $dvtModels = $_POST['Quydoidonvitinh'];
                    foreach ($dvtModels as $index => $dvtModel) {
                        $quyDoiDVT[$index] = new Quydoidonvitinh();
                        $quyDoiDVT[$index]->attributes = $dvtModel;
                        if(!$quyDoiDVT[$index]->validate(['donvitinh_id', 'trongso']))
                            $dvtValidate = false;
                    }
                }
                else{
                    $quyDoiDVT = [];
                    $dvtValidate = false;
                }

                if($model->validate() && $dvtValidate){
                    $model->save();
                    return [
                            'forceReload'=>'#crud-datatable-pjax',
                            'title'=> "Create new Hanghoa",
                            'content'=>'<span class="text-success">Create Hanghoa success</span>',
                            'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
                }
                else{
                    return [
                        'title'=> "Create new Hanghoa",
                        'content'=>$this->renderAjax('create', [
                            'model' => $model,
                            'quyDoiDVT' => $quyDoiDVT,
                        ]),
                        'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::button('Lưu lại',['class'=>'btn btn-primary','type'=>"submit", 'id' => 'btn-save'])

                    ];
                }

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
                    'quyDoiDVT' => $quyDoiDVT
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
                    'title'=> "Update Hanghoa #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Hanghoa #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update Hanghoa #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
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

    public function actionGetdvt(){
        if(isset($_POST['hanghoa'])){
            $dvt = Hanghoadvt::find()->select(['iddonvitinh', 'tendvt'])->where(['codehang' => $_POST['hanghoa']])->all();
            $hangHoaChons = [];
            foreach ($_POST['Hanghoa'] as $idHang) {
                if($idHang!=="")
                    if(!array_key_exists($idHang, $hangHoaChons))
                        $hangHoaChons[$idHang] = Hanghoa::find()->select(['id','name'])->where(['id' => $idHang])->one();
            }
            echo Json::encode([
                'donvitinh' => $dvt,
                'dsHangDaChon' => $this->renderAjax('../nhaphang/_dshangdachon', ['hanghoas' => $hangHoaChons])
            ]);
        }else
            throw new HttpException(500, 'Không có thông tin hàng hóa');
    }

    public function actionNhaptondauky(){
        if(isset($_POST['Hanghoa'])){
            $hoadonmua = new Muabanhang();
            $hoadonmua->type = 'mua';
            $hoadonmua->ngaygiaodich = date("d/m/Y");
            $hoadonmua->maphieu = strval(time());
            $hoadonmua->kieuthanhtoan = 'thanhtoanngay';
            $hoadonmua->hinhthucthanhtoan = 'tienmat';
            $hoadonmua->nhapdauky = 1;
            if(!$hoadonmua->save())
                var_dump($hoadonmua->getErrors());
            else{
                $soluongdaluu = 0;
                $tongtien = 0;
                foreach ($_POST['Hanghoa'] as $index => $item) {
                    /**
                     * Lấy thông tin hàng hóa từng dòng
                     */
                    $mahang = $item['ma'];
                    $tenhang = $item['name'];
                    $nhomhang = $item['nhomloaihang_id'];
                    $hanghoa = Hanghoa::find()->where(['ma' => $mahang])->one();
                    /** Nếu thông tin hàng chưa có thì lưu mới, ngược lại cập nhật thông tin */
                    if(count($hanghoa) == 0)
                        $hanghoa = new Hanghoa();
                    $hanghoa->ma = $mahang;
                    $hanghoa->name = $tenhang;
                    $hanghoa->nhomloaihang_id = $nhomhang;
                    $hanghoa->save();

                     /** Lưu đơn vị tính quy đổi */
                    foreach ($_POST['donvitinh'][$index]['name'] as $indexDVT => $value) {
                        $hanghoadonvitinh = Hanghoadvt::find()->where(['codedvt' => myFuncs::createCode($value), 'idhanghoa' => $hanghoa->id])->one();
                        if(count($hanghoadonvitinh) == 0){
                            $quydoidonvitinh = new Quydoidonvitinh();
                            $quydoidonvitinh->donvitinh_id = $value;
                            $quydoidonvitinh->hanghoa_id = $hanghoa->id;
                        }
                        else{
                            $quydoidonvitinh = Quydoidonvitinh::findOne($hanghoadonvitinh->idquydoidonvitinh);
                            $quydoidonvitinh->donvitinh_id = $quydoidonvitinh->donvitinh->name;
                        }
                        $quydoidonvitinh->trongso = $_POST['donvitinh'][$index]['trongso'][$indexDVT];
                        $quydoidonvitinh->giamua = $_POST['donvitinh'][$index]['gianhap'][$indexDVT];
                        $quydoidonvitinh->giaban = $_POST['donvitinh'][$index]['giaban'][$indexDVT];

                        if(!$quydoidonvitinh->save())
                            var_dump($quydoidonvitinh->getErrors());

                        /** Với mỗi đvt có số lượng > 0 thì nhập vào kho và chi tiết mua hàng */
                        if(($soluong = $_POST['donvitinh'][$index]['soluong'][$indexDVT]) > 0){
                            $chitietMuaban = new Chitietmuaban();
                            $chitietMuaban->muabanhang_id = $hoadonmua->id;
                            $chitietMuaban->quydoidonvitinh_id = $quydoidonvitinh->id;
                            $chitietMuaban->soluong = $soluong;
                            $chitietMuaban->dongia = $quydoidonvitinh->giamua;
                            $chitietMuaban->thanhtien = $chitietMuaban->tongtien = $chitietMuaban->dongia * $chitietMuaban->soluong;
                            if($chitietMuaban->save()){
                                $soluongdaluu++;
                                $tongtien+= $chitietMuaban->tongtien;
                            }
                            else
                                var_dump($chitietMuaban->getErrors());


                            /** Lưu kho với mỗi loại đơn vị tính */

                            $chitietkho = Chitietkho::find()->where(['idquydoidvt' => $quydoidonvitinh->id])->one();
                            if(count($chitietkho) == 0){
                                $khohang = new Khohanghoa();
                                $khohang->quydoidonvitinh_id = $quydoidonvitinh->id;
                                $khohang->kho_id = 1;
                                $khohang->soluong = $soluong;
                                $khohang->save();
                            }else
                                Khohanghoa::updateAllCounters(['soluong' => $soluong],'id = :id', [':id' => $chitietkho->idkhohang]);
                        }
                     }

                }
                if($soluongdaluu == 0)
                    $hoadonmua->delete();
                echo Json::encode(myFuncs::getMessage('Thông báo','success', 'Đã lưu xong thông tin nhập tồn đầu kỳ'));
            }
            exit;

        }else{
            $hanghoa = new Hanghoa();
            return $this->render('nhaptondauky', ['hanghoa' => $hanghoa]);
        }
    }

    public function actionGetformtondauky(){
        if(isset($_POST['slhang']) && isset($_POST['soluongkhoitao'])){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_formtondauky', ['hanghoa' => new Hanghoa(), 'quydoidvt' => new Quydoidonvitinh(),
                'form' => ActiveForm::begin(), 'index' => $_POST['slhang'], 'soluongkhoitao' => $_POST['soluongkhoitao']]
            );
        }
    }

    public function actionGethangtheoma(){
        if(isset($_POST['mahang'])){
            /** @var  $hanghoa Hanghoa */
            $hanghoa = Hanghoa::find()->where(['ma' => trim($_POST['mahang'])])->one();

            if(count($hanghoa) > 0){
                $donvitinhquydoi = Hanghoadvt::find()->where(['idhanghoa' => $hanghoa->id])->all();
                echo Json::encode(['name' => $hanghoa->name, 'nhomhang' => $hanghoa->nhomloaihang->name, 'donvitinhs' => $donvitinhquydoi]);
            }
            else
                echo Json::encode(['name' => '', 'nhomhang' => '', 'donvitinhs' => []]);
        }

    }
}
