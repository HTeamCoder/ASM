<?php
/**
 * Created by PhpStorm.
 * User: hungd
 * Date: 10/29/2016
 * Time: 11:33 AM
 */

namespace backend\controllers;

use backend\models\Hanghoa;
use backend\models\search\HanghoaSearch;
use backend\models\Nhacungcapkhachhang;
use backend\models\Nhapxuatkho;
use backend\models\search\ThongkekhoSearch;
use backend\models\Thongkekho;
use backend\models\Chitietxuatnhapkho;
use backend\models\Bangkehoadon;
use backend\models\Nhomloaihang;
use backend\models\Thuchi;
use yii\db\mssql\PDO;
use yii\helpers\Json;
use yii\web\Response;
use common\models\myFuncs;
use yii\web\Controller;
use kartik\select2\Select2;

class BaocaokhoController extends \yii\web\Controller
{
    public function actionIndex(){
//        var_dump($_POST); die;
        if(isset($_POST['nhomloaihang'])){
        if(isset($_POST['start'])) {
                    $start = myFuncs::convertDateSaveIntoDb($_POST['start']);
                    $end = myFuncs::convertDateSaveIntoDb($_POST['end']);
            if($_POST['nhomloaihang'] == '') {
                $db = \Yii::$app->getDb()->createCommand("CALL vk_tonkho (:start, :end)");
                $db->bindParam(':start', $start, PDO::PARAM_STR);
                $db->bindParam(':end', $end, PDO::PARAM_STR);
            }
            else{
                $db = \Yii::$app->getDb()->createCommand("CALL vk_tonkhotheonhom (:start, :end, :nhomloaihang)");
                $db->bindParam(':start', $start, PDO::PARAM_STR);
                $db->bindParam(':end', $end, PDO::PARAM_STR);
                $db->bindParam(':nhomloaihang', $_POST['nhomloaihang'], PDO::PARAM_STR);
            }
            $datas = $db->queryAll();
            $tongtienton = 0;
            foreach ($datas as $data){
                if($data['toncuoiky']>0)
                $tongtienton = $tongtienton + $data['giatrungbinh']*$data['toncuoiky'];
            }
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_tonkho', ['datas' => $datas,'tongtienton'=>$tongtienton]);
        }
        }
        else {
            $datas = [];
            $tongtienton = 0;
            return $this->render('index',['datas' => $datas,'tongtienton'=>$tongtienton]);
        }
    }
    public function actionCapnhatdonhangchitiet(){
        if(isset($_POST['idhtmlphieu'])){
            $idphieu = explode('-',$_POST['idhtmlphieu'])[1];
            $chitietxuatnhapkho = new Chitietxuatnhapkho();
            $phieuxuatkho = Nhapxuatkho::findOne($idphieu);
            $phieuxuatkho->ngaygiaodich = date("d/m/Y",strtotime($phieuxuatkho->ngaygiaodich));
            $phieuxuatkho->thanhtien = number_format($phieuxuatkho->thanhtien,0,'','.');
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_chitietdonhang',['phieuxuatkho' => $phieuxuatkho,'chitietxuatnhapkho' => $chitietxuatnhapkho]);
        }
    }
    public function actionUpdatedonhang(){

        if (isset($_POST['Chitietxuatnhapkho']))
            {
                array_pop($_POST['Chitietxuatnhapkho']);
                $nhapxuathang = Nhapxuatkho::findOne($_POST['idhoadonban']);
                $linhkien = Chitietxuatnhapkho::find()->where(['muabanhang_id'=>$_POST['idhoadonban']])->all();
                $mang = [];
                $soluonglk = 0;
                foreach($linhkien as $lk)
                {
                    if ($lk->parent_linhkien != NULL)
                    {
                        $mang[] = $lk;
                        $soluonglk = $lk->parentLinhkien->soluong;
                    }
                    
                }
                foreach($linhkien as $lk)
                {
                    if ($lk->parent_linhkien != NULL)
                        $lk->delete();
                }
                Chitietxuatnhapkho::deleteAll(['muabanhang_id' => $_POST['idhoadonban']]);
                $tongtien = 0;
                foreach ($_POST['Chitietxuatnhapkho'] as $index => $item) {
                    $chitietxuatnhapkho = new Chitietxuatnhapkho();
                    $chitietxuatnhapkho->attributes = $_POST['Chitietxuatnhapkho'][$index];
                    $hanghoa = Hanghoa::find()->where(['ma' => trim($chitietxuatnhapkho->hanghoa_id)])->one();
                    if(count($hanghoa) > 0){
                        $chitietxuatnhapkho->muabanhang_id = $_POST['idhoadonban'];
                        $chitietxuatnhapkho->tongtien = intval(str_replace('.','',$chitietxuatnhapkho->dongia)) * $chitietxuatnhapkho->soluong;
                        $chitietxuatnhapkho->dongia = intval(str_replace('.','',$chitietxuatnhapkho->dongia));
                        $chitietxuatnhapkho->thanhtien = $chitietxuatnhapkho->tongtien;
                        $chitietxuatnhapkho->hanghoa_id = $hanghoa->id;
                        $tongtien += $chitietxuatnhapkho->tongtien;
                        if(!$chitietxuatnhapkho->save()){
                            var_dump($chitietxuatnhapkho->getErrors());exit();
                        }
                    }
                    if (isset($mang)&&is_array($mang)&&count($mang)&&$hanghoa->ma == 'lrbmt')
                    {
                        foreach($mang as $linhkien)
                        {

                            $hanghoalinhkien = Hanghoa::findOne($linhkien->hanghoa_id);
                            if (!is_null($hanghoalinhkien))
                            {
                                $lrlinhkien = new Chitietxuatnhapkho();
                                $lrlinhkien->muabanhang_id = $_POST['idhoadonban'];
                                $lrlinhkien->tongtien = ($linhkien->soluong/$soluonglk)*$chitietxuatnhapkho->soluong*intval(str_replace('.','',$linhkien->dongia));
                                $lrlinhkien->thanhtien = $lrlinhkien->tongtien;
                                $lrlinhkien->hanghoa_id = $hanghoalinhkien->id;
                                $lrlinhkien->serialnumber = $linhkien->serialnumber;
                                $lrlinhkien->soluong = ($linhkien->soluong/$soluonglk)*$chitietxuatnhapkho->soluong;
                                $lrlinhkien->dongia = intval(str_replace('.','',$linhkien->dongia));
                                $lrlinhkien->parent_linhkien = $chitietxuatnhapkho->id;
                                if(!$lrlinhkien->save(false)){
                                    var_dump($lrlinhkien->getErrors());
                                    exit;
                                }   
                            }
                        }
                    }
                }
                $thanhtien = $tongtien * (1-$nhapxuathang->chietkhau/100.0);
                $thanhtien = $thanhtien * (1 + ($nhapxuathang->vat / 100));
                $nhapxuathang->updateAttributes(['tongtien' => $tongtien, 'thanhtien' => $thanhtien]);
                if($nhapxuathang->type == 'tralai'){
                    $isnew = count(Thuchi::find()->where(['nhapxuatkho_id'=>$nhapxuathang->id])->all());

                    if($isnew > 0){
                        $chenhlech = 0;
                        $thuchitam = Thuchi::find()->where(['nhapxuatkho_id'=>$nhapxuathang->id])->one();
                        $chenhlech = $nhapxuathang->thanhtien - $thuchitam->sotientra;

                        $thuchitam->sotientra = $nhapxuathang->thanhtien;
                        $thuchitam->tienhoadon += $chenhlech;
                    }else {
                        $thuchitam = new Thuchi();
                        $thuchitam->sotientra = $nhapxuathang->thanhtien;
                        $thuchitam->tienhoadon = $nhapxuathang->thanhtien;
                    }
                    if($nhapxuathang->nhacungcapkhachhang->type == 'nhacungcap'){
                        $thuchitam->type = 'phieuchi';
                        $thuchitam->maphieu = 'PC'.time();
                    }
                    else{
                        $thuchitam->type = 'phieuthu';
                        $thuchitam->maphieu = 'PT'.time();
                    }

                    $thuchitam->ngaylap = date('d/m/y',strtotime($nhapxuathang->ngaygiaodich));
                    $thuchitam->tam = 1;
                    $thuchitam->nhapxuatkho_id = $nhapxuathang->id;
                    $thuchitam->nhacungcap_khachhang_id = $nhapxuathang->nhacungcap_khachhang_id;
                    $thuchitam->save();
                }
            }
        else{
             if(isset($_POST['Nhapxuatkho'])){
                 $nhapxuathang = Nhapxuatkho::findOne($_POST['idhoadonban']);
                 $nhapxuathang->ngaygiaodich = $_POST['Nhapxuatkho']['ngaygiaodich'];
                 $nhapxuathang->thanhtien = intval(str_replace('.','',$_POST['Nhapxuatkho']['thanhtien']));
                 $nhapxuathang->save(false);
                }

        }
    }
    public function actionTonkhoexport(){
        if(isset($_POST['start'])) {
            $start = myFuncs::convertDateSaveIntoDb($_POST['start']);
            $end = myFuncs::convertDateSaveIntoDb($_POST['end']);
            if($_POST['nhomloaihang'] == '') {
                $db = \Yii::$app->getDb()->createCommand("CALL vk_tonkho (:start, :end)");
                $db->bindParam(':start', $start, PDO::PARAM_STR);
                $db->bindParam(':end', $end, PDO::PARAM_STR);
                $nhomloaihang = '';
            }
            else{
                $db = \Yii::$app->getDb()->createCommand("CALL vk_tonkhotheonhom (:start, :end, :nhomloaihang)");
                $db->bindParam(':start', $start, PDO::PARAM_STR);
                $db->bindParam(':end', $end, PDO::PARAM_STR);
                $db->bindParam(':nhomloaihang', $_POST['nhomloaihang'], PDO::PARAM_STR);
                $nhomloaihang = Nhomloaihang::findOne(intval($_POST['nhomloaihang']));
                $nhomloaihang = $nhomloaihang->name;
            }
            $datas = $db->queryAll();
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_exporttonkho', ['datas' => $datas,'nhomloaihang'=>$nhomloaihang,'tungay'=>$_POST['start'],'denngay'=>$_POST['end']]);
        }
    }
    public function actionBangkehoadonbanhang(){
        $bangkehoadon = new bangkehoadon();
        if (isset($_POST['Bangkehoadon']))
        {
            $mangloc = [];
            if (isset($_POST['Bangkehoadon']['nhacungcap_khachhang_id'])&&$_POST['Bangkehoadon']['nhacungcap_khachhang_id'] != '')
                $mangloc['nhacungcap_khachhang_id'] = $_POST['Bangkehoadon']['nhacungcap_khachhang_id'];
            if (isset($_POST['Bangkehoadon']['hanghoa_id'])&&$_POST['Bangkehoadon']['hanghoa_id'] != '')
                 $mangloc['hanghoa_id'] = $_POST['Bangkehoadon']['hanghoa_id'];
            if (isset($_POST['Bangkehoadon']['nhomloaihang_id'])&&$_POST['Bangkehoadon']['nhomloaihang_id'] != '')
                $mangloc['nhomloaihang_id'] = $_POST['Bangkehoadon']['nhomloaihang_id'];
            if (isset($_POST['Bangkehoadon']['parent'])&&$_POST['Bangkehoadon']['parent'] != '')
                $mangloc['parent'] = $_POST['Bangkehoadon']['parent'];
             if (isset($_POST['Bangkehoadon']['idnhanvien'])&&$_POST['Bangkehoadon']['idnhanvien'] != '')
                $mangloc['idnhanvien'] = $_POST['Bangkehoadon']['idnhanvien'];
            if (isset($_POST['Bangkehoadon']['idcongtrinh'])&&$_POST['Bangkehoadon']['idcongtrinh'] != '')
                $mangloc['idcongtrinh'] = $_POST['Bangkehoadon']['idcongtrinh'];
            if (isset($_POST['Bangkehoadon']['idhangmuc'])&&$_POST['Bangkehoadon']['idhangmuc'] != '')
                $mangloc['idhangmuc'] = $_POST['Bangkehoadon']['idhangmuc'];

            if (isset($_POST['start'])&&$_POST['start'] != '')
                $start = date('Y-m-d',strtotime(str_replace('/','-',$_POST['start'])));
            if (isset($_POST['end'])&&$_POST['end'] != '')
                $end = date('Y-m-d',strtotime(str_replace('/','-',$_POST['end'])));
            $mangloc['type'] = 'xuatkho';
            $mangloc['loainhacungcapkhachhang'] = 'khachhang';
            $bangkehoadons = Bangkehoadon::find()->where($mangloc)->andWhere("ngaygiaodich BETWEEN '".$start."' AND '".$end."'")->andWhere(['parent_linhkien'=>NULL])->orderBy(['ngaygiaodich'=>SORT_ASC,'muabanhang_id'=>SORT_ASC])->groupBy('id')->all();
            if (isset($_POST['type'])&&$_POST['type'] == 'khachhang')
            {
                if ($_POST['Bangkehoadon']['nhacungcap_khachhang_id'] == '')
                {
                     echo Json::encode(['error' => true, 'message' => myFuncs::getMessage('Chưa chọn khách hàng','warning','Thông báo lỗi!')]);
                     return;
                }else
                 {
                    $khachhang = Bangkehoadon::findOne(['nhacungcap_khachhang_id'=>$_POST['Bangkehoadon']['nhacungcap_khachhang_id']]);
                    $khachhangfilter = (!is_null($khachhang))?$khachhang->ten:false;
                 }
            }
            else
                $khachhangfilter = false;
            $tungay = date("d/m/Y", strtotime($start));
            $denngay = date("d/m/Y", strtotime($end));
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_bangkehoadonbanhangchitiet',['bangkehoadons'=>$bangkehoadons,'khachhangfilter'=>$khachhangfilter,'thoigian' => "Kết quả thống kê<br/>Từ {$tungay} đến {$denngay}",'tungay'=>$start,'denngay'=>$end]);
        }
        else
            return $this->render('bangkehoadonbanhang', [
                'bangkehoadon' => $bangkehoadon,
            ]);
    }
    public function actionChitiettranhacungcap(){
        $nhacungcapkhachhang = new Nhacungcapkhachhang();

        if (isset($_POST['Nhacungcapkhachhang']))
        {
            $mangloc = [];
            if(isset($_POST['Nhacungcapkhachhang']['name']) && $_POST['Nhacungcapkhachhang']['name'] != ''){$mangloc['nhacungcap_khachhang_id'] = $_POST['Nhacungcapkhachhang']['name'];}
            if (isset($_POST['start'])&&$_POST['start'] != '')
                $start = date('Y-m-d',strtotime(str_replace('/','-',$_POST['start'])));
            if (isset($_POST['end'])&&$_POST['end'] != '')
                $end = date('Y-m-d',strtotime(str_replace('/','-',$_POST['end'])));
//            $mangloc['type'] = 'nhapkho';
            $chitietcongnos = Nhapxuatkho::find()->where($mangloc)->andWhere("ngaygiaodich BETWEEN '".$start."' AND '".$end."'")->andWhere("(type = 'nhapkho' or type = 'nodauky' or type = 'thuthue')")->orderBy('ngaygiaodich ASC')->all();
            $tongphaichi = 0;
            foreach ($chitietcongnos as $chitietcongno){
                $tongphaichi += $chitietcongno->thanhtien;
            }
            $nodauky = 0;
            $nodaus = Nhapxuatkho::find()->where($mangloc)->andWhere("phuongthuc = 'congno' and ngaygiaodich < '".$start."'")->andWhere("(type = 'nhapkho' or type = 'nodauky' or type = 'thuthue')")->orderBy('ngaygiaodich ASC')->all();
            foreach ($nodaus as $nodau){
                $nodauky += $nodau->thanhtien;
            }
            if(isset($_POST['Nhacungcapkhachhang']) && $_POST['Nhacungcapkhachhang']['name'] != ''){
                $idnhacungcap = (int)$_POST['Nhacungcapkhachhang']['name'];
                $nhacungcap = Nhacungcapkhachhang::findOne(['id'=>$idnhacungcap]);
                $ten = $nhacungcap->name;
                $thuchinccs = Thuchi::find()->where(['nhacungcap_khachhang_id'=>$idnhacungcap])->andWhere("phatsinh = 0")->andWhere("ngaylap BETWEEN '".$start."' AND '".$end."'")->all();
                $tongtra = 0;
                foreach ($thuchinccs as $thuchincc){
                    if ($thuchincc->type=='phieuchi')
                    $tongtra += $thuchincc->sotientra;
                }
            }
            else
            {
                $ten = false;
                echo Json::encode(['error' => true, 'message' => myFuncs::getMessage('Chưa chọn nhà cung cấp','warning','Thông báo lỗi!')]);
                return;
            }
            $tungay = date("d/m/Y", strtotime($start));
            $denngay = date("d/m/Y", strtotime($end));
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $nocuoiky = $nodauky + $tongphaichi - $tongtra;
            return $this->renderAjax('_chitiettranguoiban',['chitietcongnos'=>$chitietcongnos,'thuchinccs'=>$thuchinccs,'tongtra'=>$tongtra,'tongphaichi'=>$tongphaichi,'nodauky'=>$nodauky,'nocuoiky'=>$nocuoiky,'ten'=>$ten,'thoigian'=> "Kết quả thống kê <br/> Từ ($tungay) đến ($denngay)", 'tungay'=>$start,'denngay'=>$end]);
        }
        else{
            return $this->render('chitiettranguoiban', [
                'nhacungcapkhachhang' => $nhacungcapkhachhang,
            ]);
        }
    }
    public function actionChitiettrakhachhang(){
        $nhacungcapkhachhang = new Nhacungcapkhachhang();

        if (isset($_POST['Nhacungcapkhachhang']))
        {
            $mangloc = [];
            if(isset($_POST['Nhacungcapkhachhang']['name']) && $_POST['Nhacungcapkhachhang']['name'] != ''){$mangloc['nhacungcap_khachhang_id'] = $_POST['Nhacungcapkhachhang']['name'];}
            if (isset($_POST['start'])&&$_POST['start'] != '')
                $start = date('Y-m-d',strtotime(str_replace('/','-',$_POST['start'])));
            if (isset($_POST['end'])&&$_POST['end'] != '')
                $end = date('Y-m-d',strtotime(str_replace('/','-',$_POST['end'])));
            $chitietcongnos = Nhapxuatkho::find()->where($mangloc)->andWhere("ngaygiaodich BETWEEN '".$start."' AND '".$end."'")->andWhere("(type = 'xuatkho' or type = 'nodauky' or type = 'thuthue')")->orderBy('ngaygiaodich ASC')->all();
            $tongphaichi = 0;
            foreach ($chitietcongnos as $chitietcongno){
                $tongphaichi += $chitietcongno->thanhtien;
            }
            $nodauky = 0;
            $nodaus = Nhapxuatkho::find()->where($mangloc)->andWhere("phuongthuc = 'congno' and ngaygiaodich < '".$start."'")->andWhere("(type = 'xuatkho' or type = 'nodauky' or type = 'thuthue')")->orderBy('ngaygiaodich ASC')->all();
            foreach ($nodaus as $nodau){
                $nodauky += $nodau->thanhtien;
            }
            if(isset($_POST['Nhacungcapkhachhang']) && $_POST['Nhacungcapkhachhang']['name'] != ''){
                $idnhacungcap = (int)$_POST['Nhacungcapkhachhang']['name'];
                $nhacungcap = Nhacungcapkhachhang::findOne(['id'=>$idnhacungcap]);
                $ten = $nhacungcap->name;
                $thuchinccs = Thuchi::find()->where(['nhacungcap_khachhang_id'=>$idnhacungcap])->andWhere("ngaylap BETWEEN '".$start."' AND '".$end."' AND phatsinh = 0")->all();
                $tongtra = 0;
                foreach ($thuchinccs as $thuchincc){
                    $tongtra += $thuchincc->sotientra;
                }

            }
            else
            {
                $ten = false;
                echo Json::encode(['error' => true, 'message' => myFuncs::getMessage('Chưa chọn khách hàng','warning','Thông báo lỗi!')]);
                return;
            }
            $tungay = date("d/m/Y", strtotime($start));
            $denngay = date("d/m/Y", strtotime($end));
            $nocuoiky = $nodauky + $tongphaichi - $tongtra;
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_chitiettrakhachhang',['chitietcongnos'=>$chitietcongnos,'thuchinccs'=>$thuchinccs,'tongtra'=>$tongtra,'tongphaichi'=>$tongphaichi,'nodauky'=>$nodauky,'nocuoiky'=>$nocuoiky,'ten'=>$ten,'thoigian'=> "Kết quả thống kê <br/> Từ ($tungay) đến ($denngay)", 'tungay'=>$start,'denngay'=>$end]);
        }
        else{
            return $this->render('chitiettrakhachhang', [
                'nhacungcapkhachhang' => $nhacungcapkhachhang,
            ]);
        }
    }
    public function actionThongke(){
        if(isset($_POST['tatca'])){

            if($_POST['tatca'] == 'tatca'){
                $start = '2016-10-01';
                $end = date("Y-m-d");
            }else{
                $start = $_POST['start'];
                $end = $_POST['end'];
            }
            $db = \Yii::$app->getDb()->createCommand("CALL vk_thongketongsoluongkho (:start, :end)");
            $db->bindParam(':start' , $start, PDO::PARAM_STR);
            $db->bindParam(':end', $end, PDO::PARAM_STR);
            $data = $db->queryAll();

            $tungay = date("d/m/Y", strtotime($start));
            $denngay = date("d/m/Y", strtotime($end));

            echo Json::encode(['tondauky' => $data[0]['soluongtondauky'], 'nhaphang' => $data[0]['soluongnhapkho'], 'xuatkho' => $data[0]['soluongxuatkho'], 'thoigian' => "Kết quả thống kê<br/>Từ {$tungay} đến {$denngay}"]) ;
        }
    }
    public function actionLichsuhanghoa(){
        $searchModel = new HanghoaSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('lichsuhanghoa', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionChitiethanghoanhapxuat(){
        if(isset($_POST['idhanghoa'])){
            $idhanghoa = explode('-',$_POST['idhanghoa'])[1];
            $chitietnhapxuat = Thongkekho::find()->where(['idhanghoa'=>$idhanghoa])->orderBy('ngaygiaodich')->all();
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_chitietnhapxuat',['chitietnhapxuat'=>$chitietnhapxuat]);
        }
    }
    public function actionChitiethanghoa(){
        if(isset($_POST['idhanghoa'])){
            $idhanghoa = explode('-',$_POST['idhanghoa'])[1];
            $db = (new \yii\db\Query())
                ->select('idhanghoa,tenhang,mahang,sum(soluongtondauky) as dauky,sum(soluongnhapkho) as nhapkho,sum(soluongxuatkho) as xuatkho')
                ->from('vk_thongkekho')
                ->where(['idhanghoa'=>$idhanghoa])
                ->groupBy(['idhanghoa'])
                ->one();
            $soluongton = $db['dauky'] + $db['nhapkho'] - $db['xuatkho'];
            $dbas = \Yii::$app->getDb()->createCommand("SELECT vk_chitietxuatnhapkho.id,soluong,vk_nhapxuatkho.type FROM vk_nhapxuatkho INNER JOIN vk_chitietxuatnhapkho ON vk_nhapxuatkho.id = vk_chitietxuatnhapkho.muabanhang_id WHERE hanghoa_id = $idhanghoa AND (vk_nhapxuatkho.type = 'nhaptondauky' OR vk_nhapxuatkho.type = 'nhapkho')")->queryAll();
            foreach ($dbas as $dba ){
                $soluongton = $soluongton - $dba['soluong'];
                if($soluongton <= 0){
                    $idnhap = $dba['id'];
                    break;
                }
            }
            $dongia = Chitietxuatnhapkho::findOne($idnhap);
//            var_dump($dongia->dongia); die;
            $hanghoa = Hanghoa::findOne($idhanghoa);
//            var_dump($hanghoa); die;
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_chitiethanghoa',['hanghoa'=>$hanghoa,'dongia'=>$dongia]);
        }
    }
    public function actionChitietdongia(){
        if(isset($_POST['idchitiet'])){
            $chitiet = Chitietxuatnhapkho::findOne($_POST['idchitiet']);
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_chitietdongia',['chitiet'=>$chitiet]);
        }
    }
    public function actionCapnhatdongia(){
        $chitiet = new Chitietxuatnhapkho();
        $chitiet = Chitietxuatnhapkho::findOne([$_POST['machitiet']]);
        $chitiet->giabanthapnhat = intval(str_replace('.','',$_POST['Chitietxuatnhapkho']['giabanthapnhat']));
//        var_dump($chitiet);
        if($chitiet->save()){
            echo Json::encode(['error' => false, 'message' => myFuncs::getMessage('Thông báo','success',"Đã sửa!")]);
        }
        else
        {
            echo Json::encode(['error' => true, 'class' => 'chitiet', 'errors' => $chitiet->getErrors(), 'message' => '']);
        }
    }
    public function actionBangkephieunhap(){
        $bangkehoadon = new bangkehoadon();
        if (isset($_POST['Bangkehoadon']))
        {
            $mangloc = [];$nhacungcapfilter = '';
            if (isset($_POST['Bangkehoadon']['nhacungcap_khachhang_id'])&&$_POST['Bangkehoadon']['nhacungcap_khachhang_id'] != '')
            {
                $mangloc['nhacungcap_khachhang_id'] = $_POST['Bangkehoadon']['nhacungcap_khachhang_id'];
                $nhacungcapfilter = Nhacungcapkhachhang::findOne($_POST['Bangkehoadon']['nhacungcap_khachhang_id']);
            }
            if (isset($_POST['Bangkehoadon']['hanghoa_id'])&&$_POST['Bangkehoadon']['hanghoa_id'] != '')
            {
                $mangloc['hanghoa_id'] = $_POST['Bangkehoadon']['hanghoa_id'];
            }
            if (isset($_POST['Bangkehoadon']['nhomloaihang_id'])&&$_POST['Bangkehoadon']['nhomloaihang_id'] != '')
            {
                $mangloc['nhomloaihang_id'] = $_POST['Bangkehoadon']['nhomloaihang_id'];
            }
            if (isset($_POST['Bangkehoadon']['parent'])&&$_POST['Bangkehoadon']['parent'] != '')
            {
                $mangloc['parent'] = $_POST['Bangkehoadon']['parent'];
            }

            if (isset($_POST['start'])&&$_POST['start'] != '')
                $start = date('Y-m-d',strtotime(str_replace('/','-',$_POST['start'])));
            if (isset($_POST['end'])&&$_POST['end'] != '')
                $end = date('Y-m-d',strtotime(str_replace('/','-',$_POST['end'])));
            $mangloc['type'] = 'nhapkho';
            $mangloc['loaiNhacungcapkhachhang'] = 'nhacungcap';
            $bangkehoadons = Bangkehoadon::find()->where($mangloc)->andWhere("ngaygiaodich BETWEEN '".$start."' AND '".$end."'")->orderBy('ngaygiaodich ASC')->all();
            $tungay = date("d/m/Y", strtotime($start));
            $denngay = date("d/m/Y", strtotime($end));
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_bangkephieunhap',['bangkehoadons'=>$bangkehoadons,'thoigian' => "Kết quả thống kê<br/>Từ {$tungay} đến {$denngay}",'tungay'=>$start,'denngay'=>$end,'nhacungcapfilter'=>$nhacungcapfilter]);
        }
        else
            return $this->render('bangkephieunhap', [
                'bangkehoadon' => $bangkehoadon,
            ]);
    }
    public function actionThuchinhacungcap(){
        $thuchi = new Thuchi();
//        var_dump($_POST); die;
        return $this->render('thuchinhacungcap');
    }
    public function actionThongkethuchinhacungcap(){
        var_dump($_POST); die;
    }
    public function actionUpdatetonkho(){
        $nhapkhos = Nhapxuatkho::find()->where(['type'=>'nhapkho'])->orWhere(['type'=>'nhaptondauky'])->all();
        $chitietnhapkhos = Chitietxuatnhapkho::find()->all();
        foreach ($nhapkhos as $nhapkho){
            foreach ($chitietnhapkhos as $chitietnhapkho) {
                if($chitietnhapkho->muabanhang_id == $nhapkho->id){
                    $chitietnhapkho->tonkho = $chitietnhapkho->soluong;
                    $chitietnhapkho->save();
                }
            }
        }
    }
}