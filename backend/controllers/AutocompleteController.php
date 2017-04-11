<?php
/**
 * Created by PhpStorm.
 * User: HungLuongHien
 * Date: 6/3/2016
 * Time: 10:56 AM
 */

namespace backend\controllers;

use backend\models\Chitietxuatnhapkho;
use backend\models\Donvitinh;
use backend\models\Hanghoa;
use backend\models\Nhacungcapkhachhang;
use backend\models\Nhomloaihang;
use backend\models\Thongketonkhohientai;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\HttpException;

class AutocompleteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['gethangfromserial','getkhachhang','getncc','gethanghoa','getnhomloaihang','getgiaonhanhang','getnhacungcapkhachhang' , 'getdaily', 'getvessel', 'getport', 'gethangvanchuyen', 'getpart', 'getunitpakage', 'getnotifyparty', 'getstatusbl', 'getdvt'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    public function actionGetdvt(){
        $name = \Yii::$app->request->get('query');
        $part = Donvitinh::find()->where('name LIKE :name', [':name' => "%{$name}%"])->all();
        echo Json::encode($part);
    }

    public function actionGetnhomloaihang(){
        $name = \Yii::$app->request->get('query');
        $part = Nhomloaihang::find()->where('name LIKE :name or code LIKE :name', [':name' => "%{$name}%"])->all();
        echo Json::encode($part);
    }

    public function actionGethanghoa(){
        $name = \Yii::$app->request->get('query');
        $part = Thongketonkhohientai::find()->select(['ma', 'name','tonkho'])->where('ma LIKE :name or name LIKE :name', [':name' => "%{$name}%"])->limit(100)->all();
        echo Json::encode($part);
    }
    public function actionGethangfromserial(){
        $name = \Yii::$app->request->get('query');
        $part = Chitietxuatnhapkho::find()->where('serialnumber LIKE :name ', [':name' => "%{$name}%"])->limit(\Yii::$app->request->get('page_limit'))->all();
        echo Json::encode($part);
    }

    public function actionGetncc(){
        if(isset($_GET['query'])){
            $name = \Yii::$app->request->get('query');
            $part = Nhacungcapkhachhang::find()->select(['diachi','dienthoai','name'])->where('(name LIKE :name or dienthoai LIKE :name) and type = :ncc', [':name' => "%{$name}%", ':ncc' => 'nhacungcap'])->all();

        }else if(isset($_POST['name'])){
            $name = $_POST['name'];
            $part = Nhacungcapkhachhang::find()->select(['diachi','dienthoai','name'])->where('(name LIKE :name or code LIKE :name) and type = :ncc', [':name' => "%{$name}%", ':ncc' => 'nhacungcap'])->one();
        }
        else
            throw  new HttpException(500, 'Lỗi');
        echo Json::encode($part);
    }
    public function actionGetkhachhang(){
        $name = \Yii::$app->request->get('query');
        $part = Nhacungcapkhachhang::find()->where('(dienthoai LIKE :name or name LIKE :name) and type = "khachhang"', [':name' => "%{$name}%"])->limit(\Yii::$app->request->get('page_limit'))->all();
        echo Json::encode($part);
    }
    public function actionGetnhacungcapkhachhang(){
        $name = \Yii::$app->request->get('query');
        $part = Nhacungcapkhachhang::find()->where('(dienthoai LIKE :name or name LIKE :name)', [':name' => "%{$name}%"])->limit(\Yii::$app->request->get('page_limit'))->all();
        echo Json::encode($part);
    }
}