<?php

namespace backend\controllers;

use Yii;
use backend\models\Hocvien;
use backend\models\Trinhdohocvan;
use backend\models\Congtacvien;
use backend\models\Khuvuc;
use backend\models\Nhommau;
use backend\models\Donhangchitiet;
use backend\models\Donhang;
use backend\models\Khoa;
use backend\models\Lop;
use backend\models\search\HocvienSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;
use common\models\myFuncs;

/**
 * HocvienController implements the CRUD actions for Hocvien model.
 */
class HocvienController extends Controller
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
     * Lists all Hocvien models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new HocvienSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Hocvien model.
     * @param integer $id
     * @return mixed
     */
    public function actionChitiethocvien()
    {   
         if (isset($_POST['mahocvien'])&&intval(trim($_POST['mahocvien']))!='')
            {
                $hocvien = Hocvien::findOne(intval(trim($_POST['mahocvien'])));
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $this->renderAjax('_chitiethocvien',['hocvien'=>$hocvien]);
            }
    }

    /**
     * Creates a new Hocvien model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionThemhocvien()
    {
        $hocvien = new Hocvien();
        $hocvien->ma = 'HV-'.time();
        return $this->render('create',['hocvien'=>$hocvien,'khoa'=> new Khoa(),'lop'=>new Lop(),'donhangchitiet'=>new Donhangchitiet(),'donhang'=>new Donhang()]);
       
    }
    public function actionCapnhathocvien()
    {
        if (isset($_GET['id'])&&$_GET['id']!='')
        {
            $hocvien = Hocvien::findOne($_GET['id']);
            $hocvien->congtacvien_id = ($hocvien->congtacvien_id)?Congtacvien::findOne($hocvien->congtacvien_id)->name:$hocvien->congtacvien_id;
            $hocvien->trinhdohocvan_id = ($hocvien->trinhdohocvan_id)?Trinhdohocvan::findOne($hocvien->trinhdohocvan_id)->name:$hocvien->trinhdohocvan_id;
            $hocvien->nhommau_id = ($hocvien->nhommau_id)?Nhommau::findOne($hocvien->nhommau_id)->name:$hocvien->nhommau_id;
            $hocvien->phuongxa = ($hocvien->khuvuc_id)?Khuvuc::findOne($hocvien->khuvuc_id)->name:$hocvien->phuongxa;
            $hocvien->quanhuyen = ($hocvien->khuvuc_id)?Khuvuc::findOne($hocvien->khuvuc_id)->parent->name:$hocvien->quanhuyen;
             $hocvien->tinhthanh = ($hocvien->khuvuc_id)?Khuvuc::findOne($hocvien->khuvuc_id)->parent->parent->name:$hocvien->tinhthanh;
             $hocvien->ngaysinh = ($hocvien->ngaysinh)?date('d/m/Y',strtotime($hocvien->ngaysinh)):date('d/m/Y');
            return $this->render('update',['hocvien'=>$hocvien,'khoa'=> new Khoa(),'lop'=>new Lop(),'donhangchitiet'=>new Donhangchitiet(),'donhang'=>new Donhang()]);
        }else
        {
            return $this->goHome();
        }
        
       
    }
    public function actionLuuhocvien()
    {
        if (isset($_POST['Hocvien']))
        {
            
            if (isset($_POST['Hocvien']['id']))
            {
                $hocvien = Hocvien::findOne($_POST['Hocvien']['id']);
            }
            else
                $hocvien = new Hocvien();

            $hocvien->load(Yii::$app->request->post());
            if ($hocvien->validate())
            {
                if ($hocvien->save())
                    echo Json::encode(['error' => false, 'message' => myFuncs::getMessage('Thông báo','success',"Đã lưu học viên!")]);
            }else
            {
                $loi = [];
                foreach($hocvien->getErrors() as $item)
                {
                    $loi[] = $item[0];
                }
                echo Json::encode(['error' => true, 'message' => myFuncs::getMessage('Thông báo lỗi','danger',implode('</br>', $loi))]);
            }
        }
    }
    
    public function actionXoahocvien()
    {
       if (isset($_POST['mahocvien'])&&intval(trim($_POST['mahocvien']))!='')
        {
            $hocvien = Hocvien::findOne(intval(trim($_POST['mahocvien'])));
            if ($hocvien->delete())
                echo Json::encode(['error' => false, 'message' => myFuncs::getMessage('Thông báo lỗi','success','Đã xóa học viên')]);
            else
                echo Json::encode(['error' => true, 'message' => myFuncs::getMessage('Thông báo lỗi','danger','Xóa học viên không thành công')]);
        }
    }

     /**
     * Delete multiple existing Hocvien model.
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
     * Finds the Hocvien model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hocvien the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Hocvien::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionGetinfo(){
        if(isset($_POST['item'])){
            $hocvien = Hocvien::find()->where('(ma = :d or name = :d)',[':d' => $_POST['item']])->one();
            $hocvien->ngaysinh = date('d/m/Y',strtotime($hocvien->ngaysinh));
            echo Json::encode($hocvien);
        }
    }
}
