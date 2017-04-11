<?php
/**
 * Created by PhpStorm.
 * User: hungd
 * Date: 10/4/2016
 * Time: 2:41 PM
 */

namespace backend\controllers;


use backend\models\Chitietmuaban;
use backend\models\Muabanhang;
use common\models\myFuncs;
use yii\base\Controller;
use backend\models\search\HanghoaSearch;
use Yii;
use yii\helpers\Json;

class NhaphangController extends Controller
{
    public function actionIndex(){
        $muaHang = new Muabanhang();

        if(Yii::$app->request->post()){
            $muaHang->load(Yii::$app->request->post());
            if($muaHang->validate()){
                $chitietMuaHang = [];
                if(isset($_POST['Chitietmuaban'])){
                    $errorChitietmuahang = [];
                    foreach ($_POST['Chitietmuaban'] as $index => $item) {
                        if(isset($item['quydoidonvitinh_id'])){
                            $chitietMuaHang[$index] = new Chitietmuaban();
                            $chitietMuaHang[$index]->attributes = $item;
                            $hanghoa = $_POST['Hanghoa'][$index];
                            $donvitinh = $chitietMuaHang[$index]->quydoidonvitinh_id;
                            if($hanghoa === "" && $donvitinh !== "")
                                $errorChitietmuahang[$index] = ['id' => 'hanghoa-'.$index, 'message' => 'Chưa chọn hàng'];
                            else if($hanghoa!=="" && $donvitinh === "")
                                $errorChitietmuahang[$index] = ['id' => 'quydoidonvitinh-'.$index, 'message' => 'Chưa chọn đơn vị tính'];
                        }
                    }
                    if(count($errorChitietmuahang) > 0)
                        echo Json::encode(['type' => 'errorChonHang', 'message' => $errorChitietmuahang]);
                    else if(count($chitietMuaHang) === 0)
                        echo Json::encode(['type' => 'errorChuanhaphang', 'message' => myFuncs::getMessage('Lỗi','danger', "Vui lòng chọn ít nhất một mặt hàng!")]);
                    else{
                        $muaHang->type = 'mua';
                        $muaHang->nhanviengiaodich = Yii::$app->user->getId();
                        $muaHang->save();
                        echo Json::encode(['type' => 'success', 'message' => myFuncs::getMessage('Thông báo', 'success', 'Đã nhập hàng thành công!')]);
                    }
                }else
                    echo Json::encode(['type' => 'errorChuanhaphang', 'message' => myFuncs::getMessage('Lỗi','danger', "Vui lòng chọn ít nhất một mặt hàng!")]);

            }else
                echo Json::encode(['type' => 'error', 'message' => $muaHang->getFirstErrors()]);
        }else{
            $chitietMuaHang = new Chitietmuaban();

            return $this->render('index', ['muaHang' => $muaHang, 'chitietmuahang' => $chitietMuaHang]);
        }
    }
}