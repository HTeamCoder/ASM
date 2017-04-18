<?php
/**
 * Created by PhpStorm.
 * User: HungLuongHien
 * Date: 6/3/2016
 * Time: 10:56 AM
 */

namespace backend\controllers;

use backend\models\Khuvuc;
use backend\models\Nhommau;
use backend\models\Khoa;
use backend\models\Donhang;
use backend\models\Vunglamviec;
use backend\models\Nghiepdoan;
use backend\models\Xinghiep;
use backend\models\Donvicungcapnguon;
use backend\models\Lop;
use backend\models\Hocvien;
use backend\models\Benhvien;
use backend\models\Trinhdohocvan;
use backend\models\Congtacvien;
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
                        'actions' => ['getkhuvucxa','getkhuvuchuyen','getkhuvuctinh','getbenhvien','getcongtacvien','getnoisinh','getnoihoctap' , 'gettrinhdohocvan', 'getnoicap', 'getnhommau','getkhoahoc','getlophoc','getdonhang','getvunglamviec','getxinghiep','getnghiepdoan','getdonvicungcapnguon','gethocvien'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    public function actionGetkhuvucxa(){
        $name = \Yii::$app->request->get('query');
        $part = Khuvuc::find()->where('name LIKE :name', [':name' => "%{$name}%"])->andWhere(['kieu'=>'phuongxa'])->all();
        echo Json::encode($part);
    }
    public function actionGetkhuvuchuyen(){
        $name = \Yii::$app->request->get('query');
        $part = Khuvuc::find()->where('name LIKE :name', [':name' => "%{$name}%"])->andWhere(['kieu'=>'quanhuyen'])->all();
        echo Json::encode($part);
    }

    public function actionGetkhuvuctinh(){
        $name = \Yii::$app->request->get('query');
        $part = Khuvuc::find()->where('name LIKE :name', [':name' => "%{$name}%"])->andWhere(['kieu'=>'tinhthanh'])->all();
        echo Json::encode($part);
    }


    public function actionGetnhommau(){
        $name = \Yii::$app->request->get('query');
        $part = Nhommau::find()->where('name LIKE :name or code LIKE :name', [':name' => "%{$name}%"])->all();
        echo Json::encode($part);
    }

    public function actionGetbenhvien(){
        $name = \Yii::$app->request->get('query');
        $part = Benhvien::find()->where('name LIKE :name or code LIKE :name', [':name' => "%{$name}%"])->all();
        echo Json::encode($part);
    }
    
    public function actionGettrinhdohocvan(){
        $name = \Yii::$app->request->get('query');
        $part = Trinhdohocvan::find()->where('name LIKE :name or code LIKE :name', [':name' => "%{$name}%"])->all();
        echo Json::encode($part);
    }

    public function actionGetcongtacvien(){
        $name = \Yii::$app->request->get('query');
        $part = Congtacvien::find()->where('name LIKE :name or code LIKE :name', [':name' => "%{$name}%"])->all();
        echo Json::encode($part);
    }

    public function actionGetnoicap(){
        $name = \Yii::$app->request->get('query');
        $part = Khuvuc::find()->where('name LIKE :name', [':name' => "%{$name}%"])->andWhere(['kieu'=>'tinhthanh'])->all();
        echo Json::encode($part);
    }
    public function actionGetnoihoctap(){
        $name = \Yii::$app->request->get('query');
        $part = Khuvuc::find()->where('name LIKE :name', [':name' => "%{$name}%"])->andWhere(['kieu'=>'tinhthanh'])->all();
        echo Json::encode($part);
    }
    public function actionGetnoisinh(){
        $name = \Yii::$app->request->get('query');
        $part = Khuvuc::find()->where('name LIKE :name', [':name' => "%{$name}%"])->andWhere(['kieu'=>'tinhthanh'])->all();
        echo Json::encode($part);
    }
    public function actionGetkhoahoc(){
        $name = \Yii::$app->request->get('query');
        $part = Khoa::find()->where('name LIKE :name', [':name' => "%{$name}%"])->all();
        echo Json::encode($part);
    }
    public function actionGetlophoc(){
        $name = \Yii::$app->request->get('query');
        $part = Lop::find()->where('name LIKE :name', [':name' => "%{$name}%"])->all();
        echo Json::encode($part);
    }
    public function actionGetdonhang(){
        $name = \Yii::$app->request->get('query');
        $part = Donhang::find()->where('name LIKE :name', [':name' => "%{$name}%"])->all();
        echo Json::encode($part);
    }
    public function actionGetvunglamviec(){
        $name = \Yii::$app->request->get('query');
        $part = Vunglamviec::find()->where('name LIKE :name', [':name' => "%{$name}%"])->all();
        echo Json::encode($part);
    }
    public function actionGetnghiepdoan(){
        $name = \Yii::$app->request->get('query');
        $part = Nghiepdoan::find()->where('name LIKE :name', [':name' => "%{$name}%"])->all();
        echo Json::encode($part);
    }
    public function actionGetxinghiep(){
        $name = \Yii::$app->request->get('query');
        $part = Xinghiep::find()->where('name LIKE :name', [':name' => "%{$name}%"])->all();
        echo Json::encode($part);
    }
    public function actionGetdonvicungcapnguon(){
        $name = \Yii::$app->request->get('query');
        $part = Donvicungcapnguon::find()->where('name LIKE :name', [':name' => "%{$name}%"])->all();
        echo Json::encode($part);
    }
    public function actionGethocvien(){
        $name = \Yii::$app->request->get('query');
        $part = Hocvien::find()->where('(ma LIKE :name or name LIKE :name)', [':name' => "%{$name}%"])->limit(\Yii::$app->request->get('page_limit'))->all();
        echo Json::encode($part);
    }
}