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
use backend\models\search\TuyendungSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;
use common\models\myFuncs;

/**
 * HocvienController implements the CRUD actions for Hocvien model.tessss
 */
class TuyendungController extends Controller
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
        $searchModel = new TuyendungSearch();
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
    public function actionDangky()
    {   
        if (isset($_GET['id'])&&$_GET['id']!='')
        {
            $hocvien = Hocvien::findOne(intval(trim($_GET['id'])));
            $hocvien->congtacvien_id = ($hocvien->congtacvien_id)?Congtacvien::findOne($hocvien->congtacvien_id)->name:$hocvien->congtacvien_id;
            $hocvien->trinhdohocvan_id = ($hocvien->trinhdohocvan_id)?Trinhdohocvan::findOne($hocvien->trinhdohocvan_id)->name:$hocvien->trinhdohocvan_id;
            $hocvien->nhommau_id = ($hocvien->nhommau_id)?Nhommau::findOne($hocvien->nhommau_id)->name:$hocvien->nhommau_id;
            $hocvien->phuongxa = ($hocvien->khuvuc_id)?Khuvuc::findOne($hocvien->khuvuc_id)->name:$hocvien->phuongxa;
            $hocvien->quanhuyen = ($hocvien->khuvuc_id)?Khuvuc::findOne($hocvien->khuvuc_id)->parent->name:$hocvien->quanhuyen;
             $hocvien->tinhthanh = ($hocvien->khuvuc_id)?Khuvuc::findOne($hocvien->khuvuc_id)->parent->parent->name:$hocvien->tinhthanh;
             $hocvien->noisinh = ($hocvien->noisinh)?Khuvuc::findOne($hocvien->noisinh)->name:'';
             $hocvien->noihoctap = ($hocvien->noihoctap)?Khuvuc::findOne($hocvien->noihoctap)->name:'';
             $hocvien->noicap = ($hocvien->noicap)?Khuvuc::findOne($hocvien->noicap)->name:'';
             $hocvien->ngaysinh = ($hocvien->ngaysinh)?date('d/m/Y',strtotime($hocvien->ngaysinh)):date('d/m/Y');
             $hocvien->ngaycap = ($hocvien->ngaycap)?date('d/m/Y',strtotime($hocvien->ngaycap)):date('d/m/Y');
        }else
        {
            $hocvien = new Hocvien();
            $hocvien->ma = 'HV-'.time();
        }
         return $this->render('dangky', [
            'hocvien' => $hocvien
        ]);
    }

    /**
     * Creates a new Hocvien model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionLuudangky()
    {
        if (isset($_POST['Hocvien']))
        {
            $hocvien = Hocvien::findOne(['ma'=>$_POST['Hocvien']['ma']]);
            if (!is_null($hocvien))
            {
                $hocvien->load(Yii::$app->request->post());
            }
            else
            {
                $hocvien = new Hocvien();
                $hocvien->load(Yii::$app->request->post());
            }
            
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

}
