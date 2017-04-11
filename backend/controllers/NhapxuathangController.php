<?php
/**
 * Created by PhpStorm.
 * User: hungd
 * Date: 10/29/2016
 * Time: 1:48 AM
 */

namespace backend\controllers;
use backend\models\Chitietxuatnhapkho;
use backend\models\Congnonhacungcap;
use backend\models\Hanghoa;
use backend\models\Nhacungcapkhachhang;
use backend\models\Nhanvienthicong;
use backend\models\Nhapxuatkho;
use backend\models\Thuchi;
use backend\models\search\NhapxuatkhoSearch;
use common\models\myFuncs;
use kcfinder\type_img;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yii\data\Pagination;
class NhapxuathangController extends Controller
{
    public function actionNhaptondauky(){
        if(isset($_GET['id'])){
            $nhapxuatkho = Nhapxuatkho::findOne($_GET['id']);
            $nhapxuatkho->ngaygiaodich  = date("d/m/Y", strtotime($nhapxuatkho->ngaygiaodich));
        }else{
            $sophieutrongthang = (Nhapxuatkho::find()->where(['type'=>'nhaptondauky'])->count());
            $nhapxuatkho = new Nhapxuatkho();
            $nhapxuatkho->setScenario('nhapmoi');
            $maphieulap = Nhapxuatkho::find()->select('maphieu')->where(['type'=>'nhaptondauky'])->orderBy(['id' => SORT_DESC])->limit(1)->one();
            if ($sophieutrongthang <= intval(explode('.', $maphieulap->maphieu)[1]))
                $sophieutrongthang = intval(explode('.', $maphieulap->maphieu)[1])+1;
            $nhapxuatkho->maphieu = "DK.00".($sophieutrongthang);
            $nhapxuatkho->ngaygiaodich = date("d/m/Y");
        }
        $chitietnhapxuat = new Chitietxuatnhapkho();
        return $this->render('nhaptondauky',
            [
                'nhapxuatkho' => $nhapxuatkho,
                'chitietxuatnhapkho' => $chitietnhapxuat,
                'hanghoa' => new Hanghoa(),
            ]
        );

    }

    public function actionGetrownhaptondauky(){
        if(isset($_POST['indexhang'])){
            $chitietnhapxuatkho = new Chitietxuatnhapkho();
            $hanghoa = new Hanghoa();
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_rowhangnhaptondauky', ['index' => $_POST['indexhang'], 'chitietnhapxuatkho' => $chitietnhapxuatkho, 'hanghoa' => $hanghoa]);
        }
    }

    public function actionSavetondauky(){

        if($_POST['idnhapxuatkho'] !="")
            $nhapxuatkho = Nhapxuatkho::findOne($_POST['idnhapxuatkho']);
        else{
            $nhapxuatkho = new Nhapxuatkho();
            $nhapxuatkho->setScenario('nhapmoi');
        }


        $nhapxuatkho->load(\Yii::$app->request->post());
        $nhapxuatkho->type = 'nhaptondauky';
        if($nhapxuatkho->validate()){
            if(!isset($_POST['Chitietxuatnhapkho']))
                echo Json::encode(['error' => true, 'class' => 'chitietxuatnhapkho', 'errors' => [], 'message' => myFuncs::getMessage('Chưa chọn mặt hàng nào để nhập vào kho','warning','Thông báo lỗi!')]);
            else{
                $loi = [];
                if (isset($_POST['Chitietxuatnhapkho'])){
                    if (count($_POST['Chitietxuatnhapkho'])==1)
                    {
                        if (isset($_POST['Chitietxuatnhapkho'][0]['hanghoa_id'])) {
                            if ($_POST['Chitietxuatnhapkho'][0]['hanghoa_id'] == '')
                                $loi[] = 'Chưa có mặt hàng nào được nhập';
                            if (isset($_POST['Chitietxuatnhapkho'][0]['dongia']))
                                $_POST['Chitietxuatnhapkho'][0]['dongia'] = intval(str_replace('.','',$_POST['Chitietxuatnhapkho'][0]['dongia']));
                        }
                        if (isset($_POST['Chitietxuatnhapkho'][1]['hanghoa_id'])||!isset($_POST['Chitietxuatnhapkho'][1]['dongia'])||!isset($_POST['Chitietxuatnhapkho'][1]['soluong']))
                            $loi[] = 'Không có dữ liệu về mặt hàng này';
                    }else if (count($_POST['Chitietxuatnhapkho']) > 1)
                    {
                        array_pop($_POST['Chitietxuatnhapkho']);
                        foreach($_POST['Chitietxuatnhapkho'] as $key=>$val){
                            if (isset($val['hanghoa_id'])){
                                if ($val['hanghoa_id'] == '')
                                    $loi[] = 'Chưa nhập đầy đủ mã hàng';
                                if($_POST['Chitietxuatnhapkho'][$key]['dongia'] == "")
                                    $loi[] = "Chưa nhập đầy đủ đơn giá các mặt hàng";
                                if($_POST['Chitietxuatnhapkho'][$key]['soluong'] == '')
                                    $loi[] = "Chưa nhập đầy đủ số lượng các mặt hàng";
                                if(count($loi) > 0)
                                    break;
                            }
                            if (isset($_POST['Chitietxuatnhapkho'][$key]['dongia']))
                                $_POST['Chitietxuatnhapkho'][$key]['dongia'] = intval(str_replace('.','',$_POST['Chitietxuatnhapkho'][$key]['dongia']));
                        }

                    }
                    if(count($loi) > 0)
                        echo Json::encode(['error' => true, 'class' => 'chitietxuatnhapkho', 'errors' => [], 'message' => myFuncs::getMessage('Lỗi','danger',implode('<br/>',$loi))]);
                    else{
                        $nhapxuatkho->save();

                        if($nhapxuatkho->id != "")
                            \Yii::$app->session->setFlash('thongbao',myFuncs::getMessage('Thông báo','success', 'Đã cập nhật lại phiếu '.$nhapxuatkho->maphieu));
                        $sophieutrongthang = (Nhapxuatkho::find()->where(['type'=>'nhaptondauky'])->count());
                        $maphieulap = Nhapxuatkho::find()->select('maphieu')->where(['type'=>'nhaptondauky'])->orderBy(['id' => SORT_DESC])->limit(1)->one();
                        if ($sophieutrongthang <= intval(explode('.', $maphieulap->maphieu)[1]))
                            $sophieutrongthang = intval(explode('.', $maphieulap->maphieu)[1])+1;
                        echo Json::encode(['error' => false, 'message' => myFuncs::getMessage('Thông báo','success',"Đã lưu phiếu!"), 'maphieumoi' => "DK.00".($sophieutrongthang), 'update' => $nhapxuatkho->id != ""]);
                    }
                }else{
                    echo Json::encode(['error' => true, 'class' => 'nhapxuatkho', 'errors' => $nhapxuatkho->getErrors(), 'message' => '']);
                }
            }
        }
    }

    public function actionThuthue(){
        if(isset($_GET['id'])){
            $thuthue = Nhapxuatkho::findOne($_GET['id']);
            $thuthue->ngaygiaodich = date("d/m/y",strtotime($thuthue->ngaygiaodich));
            $thuthue->thanhtien = number_format($thuthue->thanhtien,0,'','.');
            $khachhang = $thuthue->nhacungcapkhachhang;
        }else{
            $khachhang = new Nhacungcapkhachhang();
            $sophieu = count(Nhapxuatkho::find()->where(['type'=>'thuthue'])->all());
            $thuthue = new Nhapxuatkho();
            $thuthue->setScenario('nhapmoi');
            $maphieulaps = Nhapxuatkho::find()->where(['type'=>'thuthue'])->all();
            foreach($maphieulaps as $maphieulap)
            {
                if ($sophieu <= intval(explode('.', $maphieulap->maphieu)[1]))
                    $sophieu = intval(explode('.', $maphieulap->maphieu)[1])+1;
            }
            $thuthue->maphieu = "TT.00".($sophieu);
        }
        $danhsachthues = Nhapxuatkho::find()->where(['type'=>'thuthue'])->orderBy(['id'=>SORT_DESC])->all();
        return $this->render('thuthue',['thuthue' => $thuthue,'khachhang'=>$khachhang,'danhsachthues'=>$danhsachthues]);
    }

    public function actionNodauky(){
        if(isset($_GET['id'])){
            $thuthue = Nhapxuatkho::findOne($_GET['id']);
            $thuthue->ngaygiaodich = date("d/m/y",strtotime($thuthue->ngaygiaodich));
            $thuthue->thanhtien = number_format($thuthue->thanhtien,0,'','.');
            $khachhang = $thuthue->nhacungcapkhachhang;
        }else{
            $khachhang = new Nhacungcapkhachhang();
            $sophieu = count(Nhapxuatkho::find()->where(['type'=>'nodauky'])->all());
            $thuthue = new Nhapxuatkho();
            $thuthue->setScenario('nhapmoi');
            $maphieulaps = Nhapxuatkho::find()->where(['type'=>'nodauky'])->all();
            foreach($maphieulaps as $maphieulap)
            {
                if ($sophieu <= intval(explode('.', $maphieulap->maphieu)[1]))
                    $sophieu = intval(explode('.', $maphieulap->maphieu)[1])+1;
            }
            $thuthue->maphieu = "NDK.00".($sophieu);
        }
        $danhsachthues = Nhapxuatkho::find()->where(['type'=>'nodauky'])->orderBy(['id'=>SORT_DESC])->all();
        return $this->render('nodauky',['thuthue' => $thuthue,'khachhang'=>$khachhang,'danhsachthues'=>$danhsachthues]);
    }

    public function actionIndex(){
        $searchModel = new NhapxuatkhoSearch();
        if(isset($_GET['type'])){
            if($_GET['type'] == 'nhapkho'){
                $searchModel->type = 'nhapkho';
            }
            else if ($_GET['type'] == 'xuatkho'){
                $searchModel->type = 'xuatkho';
            }else if ($_GET['type'] == 'tralai')
            {
                $searchModel->type = 'tralai';
            }else
            {
                 $searchModel->type = 'nhaptondauky';
            }
        }
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionThongkecongno()
    {
        if(isset($_POST['tatca'])){

            if($_POST['tatca'] == 'tatca'){
                $start = '2016-10-01';
                $end = date("Y-m-d");
            }else{
                $start = $_POST['start'];
                $end = $_POST['end'];
            }

            $tungay = date("d/m/Y", strtotime($start));
            $denngay = date("d/m/Y", strtotime($end));

            echo Json::encode(['thoigian' => "Kết quả thống kê<br/>Từ {$tungay} đến {$denngay}"]) ;
        }
    }
    public function actionThuchichitiet()
    {
        if (isset($_POST['Thuchi']))
        {
            $mangloc = [];
            if(isset($_POST['Thuchi']['nhacungcap_khachhang_id']) && $_POST['Thuchi']['nhacungcap_khachhang_id'] != ''){$mangloc['nhacungcap_khachhang_id'] = $_POST['Thuchi']['nhacungcap_khachhang_id'];}
            if (isset($_POST['start'])&&$_POST['start'] != '')
                $start = date('Y-m-d',strtotime(str_replace('/','-',$_POST['start'])));
            if (isset($_POST['end'])&&$_POST['end'] != '')
                $end = date('Y-m-d',strtotime(str_replace('/','-',$_POST['end'])));
            $ncckh = ($_POST['type'] == 'nhapkho')?'nhà cung cấp':'khách hàng';
            $chitietcongnos = Nhapxuatkho::find()->where($mangloc)->andWhere("ngaygiaodich BETWEEN '".$start."' AND '".$end."'")->andWhere("(type = '".$_POST['type']."' or type = 'nodauky' or type = 'thuthue')")->orderBy('ngaygiaodich ASC')->all();
            $tongphaichi = 0;
            foreach ($chitietcongnos as $chitietcongno){
                $tongphaichi += $chitietcongno->tongtien;
            }
            $nodauky = 0;
            $nodaus = Nhapxuatkho::find()->where($mangloc)->andWhere("phuongthuc = 'congno' and ngaygiaodich < '".$start."'")->andWhere("(type = 'nhapkho' or type = 'nodauky' or type = 'thuthue')")->orderBy('ngaygiaodich ASC')->all();
            foreach ($nodaus as $nodau){
                $nodauky += $nodau->thanhtien;
            }
            if(isset($_POST['Thuchi']) && $_POST['Thuchi']['nhacungcap_khachhang_id'] != ''){
                $idnhacungcapkhachhang = (int)$_POST['Thuchi']['nhacungcap_khachhang_id'];
                $nhacungcapkhachhang = Nhacungcapkhachhang::findOne(['id'=>$idnhacungcapkhachhang]);
                $ten = $nhacungcapkhachhang->name;
                $thuchincckhs = Thuchi::find()->where(['nhacungcap_khachhang_id'=>$idnhacungcapkhachhang])->andWhere("ngaylap BETWEEN '".$start."' AND '".$end."' and phatsinh = 0")->all();
                $tongtra = 0;
                foreach ($thuchincckhs as $thuchincc){
                    $tongtra += $thuchincc->sotientra;
                }
            }
            else
            {
                $thuchincckhs = Thuchi::find()->where(['type'=>($_POST['type'] == 'xuatkho')?'phieuthu':'phieuchi'])->andWhere("ngaylap BETWEEN '".$start."' AND '".$end."' and phatsinh = 0")->orderBy(['nhapxuatkho_id'=>SORT_ASC,'nhacungcap_khachhang_id' => SORT_ASC])->all();
                $tongtra = 0;
                foreach ($thuchincckhs as $thuchincc){
                    $tongtra += $thuchincc->sotientra;
                }
                $ten = '';
            }
            $tungay = date("d/m/Y", strtotime($start));
            $denngay = date("d/m/Y", strtotime($end));
            $nocuoiky = $nodauky + $tongphaichi - $tongtra;
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_chitietthuchinhacungcapkhachhang',['chitietcongnos'=>$chitietcongnos,'thuchincckhs'=>$thuchincckhs,'tongtra'=>$tongtra,'tongphaichi'=>$tongphaichi,'nodauky'=>$nodauky,'nocuoiky'=>$nocuoiky,'ten'=>$ten,'thoigian'=> "Kết quả thống kê <br/> Từ ($tungay) đến ($denngay)", 'tungay'=>$start,'denngay'=>$end,'type'=>$_POST['type']]);
        }
    }
    public function actionThuchinhacungcap(){
       $nhacungcapkhachhang = new Thuchi();
        return $this->render('thuchinhacungcap', [
            'nhacungcapkhachhang' => $nhacungcapkhachhang,
        ]);
    }
    public function actionThuchikhachhang(){
        $nhacungcapkhachhang = new Thuchi();
        return $this->render('thuchikhachhang', [
            'nhacungcapkhachhang' => $nhacungcapkhachhang,
        ]);
    }
    public function actionThongkethuchi(){
        if(isset($_POST['tatca'])){

            if($_POST['tatca'] == 'tatca'){
                $start = '2016-10-01';
                $end = date("Y-m-d");
            }else{
                $start = date('Y-m-d',strtotime(str_replace('/','-',$_POST['start'])));
                $end = date('Y-m-d',strtotime(str_replace('/','-',$_POST['end'])));
            }
            if (isset($_POST['idnhacungcapkhachhang']) && $_POST['idnhacungcapkhachhang'] != 0)
            {

                $dbtongchi = \Yii::$app->getDb()->createCommand("SELECT SUM(sotientra) AS tongthuchi FROM vk_thuchi WHERE type = 'phieuchi' AND nhacungcap_khachhang_id = '{$_POST['idnhacungcapkhachhang']}' AND ngaylap BETWEEN '{$start}' AND '{$end}'");
                $dbtongthu = \Yii::$app->getDb()->createCommand("SELECT SUM(sotientra) AS tongthuchi FROM vk_thuchi WHERE type = 'phieuthu' AND nhacungcap_khachhang_id = '{$_POST['idnhacungcapkhachhang']}' AND ngaylap BETWEEN '{$start}' AND '{$end}'");
            }
            else
            {
           
                $dbtongchi = \Yii::$app->getDb()->createCommand("SELECT SUM(sotientra) AS tongthuchi FROM vk_thuchi WHERE type = 'phieuchi' AND phatsinh = 0 AND ngaylap BETWEEN '{$start}' AND '{$end}'");
                $dbtongthu = \Yii::$app->getDb()->createCommand("SELECT SUM(sotientra) AS tongthuchi FROM vk_thuchi WHERE type = 'phieuthu' AND phatsinh = 0 AND ngaylap BETWEEN '{$start}' AND '{$end}'");
            }
            $tongthu = $dbtongthu->queryAll();
            $tongchi = $dbtongchi->queryAll();
            $tungay = date("d/m/Y", strtotime($start));
            $denngay = date("d/m/Y", strtotime($end));

            echo Json::encode(['tongthu' => number_format($tongthu[0]['tongthuchi'],0,'','.'), 'tongchi' => number_format($tongchi[0]['tongthuchi'],0,'','.'),'thoigian' => "Kết quả thống kê<br/>Từ {$tungay} đến {$denngay}"]) ;
        }
    }
    public function actionCongno(){
        $searchModel = new NhapxuatkhoSearch();
        $dataProvider = $searchModel->search_congno(\Yii::$app->request->queryParams);
        return $this->render('congno', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCongnonhacungcap(){
        $idnhacungcap = (isset($_POST['Congnonhacungcap']['nhacungcap_khachhang_id']))?($_POST['Congnonhacungcap']['nhacungcap_khachhang_id']):0;
        if ($idnhacungcap != 0)
            $danhsachs = Congnonhacungcap::find()->where(['type'=>'nhacungcap','nhacungcap_khachhang_id'=>$idnhacungcap]);
        else
            $danhsachs = Congnonhacungcap::find()->where(['type'=>'nhacungcap'])->orderBy('name');
        $tienno = 0;
        $tientratruoc = 0;
        foreach ($danhsachs->all() as $danhsach){
            $tienno += $danhsach->tienno;
        }
        $tratruocs = Thuchi::find()->where(['type'=>'phieuchi'])->andWhere(['>','tienhoadon',0])->andWhere(['tam'=>0])->all();
        foreach ($tratruocs as $tratruoc){
            $tientratruoc += $tratruoc->tienhoadon;
        }

        $nhacungcap_model = new Congnonhacungcap();
        $tientralai = 0;
        $tralais = Thuchi::find()->where(['type'=>'phieuchi'])->andWhere(['>','tienhoadon',0])->andWhere(['tam'=>1])->all();
        foreach ($tralais as $tralai){
            $tientralai += $tralai->tienhoadon;
        }
        $tongnonhacungcap = $tienno-$tientratruoc-$tientralai;
        if (isset($_POST['Congnonhacungcap']['nhacungcap_khachhang_id']))
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_chitietcongnonhacungcap',['danhsachs'=>$danhsachs->all(),'tongnonhacungcap'=>$tongnonhacungcap,'idnhacungcap'=>$idnhacungcap]);
        }
        else
        {
            $query = $danhsachs;
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(),'defaultPageSize'=>10]);
            $danhsachs = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            return $this->render('congnonhacungcap',['danhsachs'=>$danhsachs,'tongnonhacungcap'=>$tongnonhacungcap,'tientralai'=>$tientralai,'nhacungcap_model'=>$nhacungcap_model,'pages'=>$pages]);
        }
    }

    public function actionCongnokhachhang(){
        $idnhacungcap = (isset($_POST['Congnonhacungcap']['nhacungcap_khachhang_id']))?($_POST['Congnonhacungcap']['nhacungcap_khachhang_id']):0;
        if ($idnhacungcap != 0)
            $danhsachs = Congnonhacungcap::find()->where(['type'=>'khachhang','nhacungcap_khachhang_id'=>$idnhacungcap]);
        else
            $danhsachs = Congnonhacungcap::find()->where(['type'=>'khachhang'])->orderBy('name');
        $tienno = 0;
        $tientratruoc = 0;
        foreach ($danhsachs->all() as $danhsach){
            $tienno += $danhsach->tienno;
        }
        $tratruocs = Thuchi::find()->where(['type'=>'phieuthu'])->andWhere(['>','tienhoadon',0])->andWhere(['tam'=>0])->all();
        foreach ($tratruocs as $tratruoc){
            $tientratruoc += $tratruoc->tienhoadon;
        }

        $tientralai = 0;
        $tralais = Thuchi::find()->where(['type'=>'phieuthu'])->andWhere(['>','tienhoadon',0])->andWhere(['tam'=>1])->all();
        foreach ($tralais as $tralai){
            $tientralai += $tralai->tienhoadon;
        }
        $tongnokhachhang = $tienno-$tientratruoc-$tientralai;
        $khachhang_model = new Congnonhacungcap();
        if (isset($_POST['Congnonhacungcap']['nhacungcap_khachhang_id']))
        {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_chitietcongnokhachhang',['danhsachs'=>$danhsachs->all(),'tongnokhachhang'=>$tongnokhachhang,'idnhacungcap'=>$idnhacungcap]);
        }
        else
        {
            $query = $danhsachs;
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(),'defaultPageSize'=>10]);
            $danhsachs = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
            return $this->render('congnokhachhang',['danhsachs'=>$danhsachs,'tongnokhachhang'=>$tongnokhachhang,'tientralai'=>$tientralai,'khachhang_model'=>$khachhang_model,'pages' => $pages]);
        }
    }

    public function actionChitiettra(){
        if(isset($_POST['idhtmlphieu'])){
            $idphieu = explode('-',$_POST['idhtmlphieu'])[1];
            $phieuthuchi = Nhapxuatkho::findOne($idphieu);
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_chitiettra',['phieuthuchi'=>$phieuthuchi]);
        }
    }

    public function actionChitiettrahoadon(){
        if(isset($_POST['idhtmlphieu'])){
            $idphieu = explode('-',$_POST['idhtmlphieu'])[1];
            $phieuthuchi = Nhapxuatkho::findOne($idphieu);
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_chitiettrahoadon',['phieuthuchi'=>$phieuthuchi]);
        }
    }
    public function actionChitiet(){
        if(isset($_POST['idhtmlphieu'])){
            $idphieu = explode('-',$_POST['idhtmlphieu'])[1];
            $phieuNhapXuat = Nhapxuatkho::findOne($idphieu);
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_chitiet',['phieuNhapXuat' => $phieuNhapXuat]);
        }
    }
    public function actionChitietlapphieu(){
        if(isset($_POST['idhtmlphieu'])){
            $idphieu = explode('-',$_POST['idhtmlphieu'])[1];
            $phieuNhapXuat = Nhapxuatkho::findOne($idphieu);
            $phieuNhapXuat->conlai_nonumber = $phieuNhapXuat->thanhtien;
            $phieuNhapXuat->thanhtien_nonumber = $phieuNhapXuat->thanhtien;
            $phieuNhapXuat->conlai = number_format((intval($phieuNhapXuat->thanhtien) - intval($phieuNhapXuat->datra)),0,'','.');
            $phieuNhapXuat->thanhtien = number_format($phieuNhapXuat->thanhtien,0,'','.');
            $phieuNhapXuat->ngaygiaodich = date('d/m/Y',strtotime($phieuNhapXuat->ngaygiaodich));
            if($phieuNhapXuat->type == 'tralai'){
                $nhacckhachhang = Nhacungcapkhachhang::findOne($phieuNhapXuat->nhacungcap_khachhang_id);
                $mpc = $nhacckhachhang->type == 'nhacungcap' ? 'PT' : 'PC';
            }else {
                $mpc = ($phieuNhapXuat->type == 'nhapkho') ? 'PC' : 'PT';
            }
            $thuchi = new Thuchi();
            $thuchi->ngaylap = date('d/m/Y');
            $thuchi->maphieu = $mpc.".".time();
            $thuchi->type = ($mpc == 'PT')?'phieuthu':'phieuchi';
            $nhacungcapkhachhang = Nhacungcapkhachhang::findOne($phieuNhapXuat->nhacungcap_khachhang_id);
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_chitietlapphieu',['nhapxuatkho' => $phieuNhapXuat,'thuchi'=>$thuchi,'nhacungcapkhachhang'=>$nhacungcapkhachhang]);
        }
    }
    public function actionChitietlapphieunhacungcap(){
        if(isset($_POST['idhtmlnhacc'])){
            $idnhacc = explode('-',$_POST['idhtmlnhacc'])[1];
            $nhacungcap= Nhacungcapkhachhang::findOne($idnhacc);
            $phieuxuats = Nhapxuatkho::find()->where(['nhacungcap_khachhang_id'=>$idnhacc])->andWhere(['phuongthuc'=>'congno'])->all();
            $thuchi = new Thuchi();
            $thuchi->ngaylap = date('d/m/Y');
            if($phieuxuats[0]['type'] == 'nhapkho') {
                $thuchi->maphieu = 'PC' . "." . time();
            }else{
                $thuchi->maphieu = 'PT' . "." . time();
            }
            $tientratruocs = Thuchi::find()->where(['nhacungcap_khachhang_id'=>$idnhacc])->andWhere(['>','tienhoadon',0])->all();
            $tientruoc = 0;
            foreach ($tientratruocs as $tientratruoc){
                $tientruoc += $tientratruoc->tienhoadon;
            }
            $tongno = Congnonhacungcap::find()->where(['nhacungcap_khachhang_id'=>$idnhacc])->one();
            $tongno->tongnophaitra = number_format(($tongno->tienno-$tientruoc), 0,',','.');
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_chitietlapphieunhacungcap',['nhapxuatkho' => $phieuxuats,'thuchi'=>$thuchi,'nhacungcap'=>$nhacungcap,'tongno'=>$tongno]);
        }
    }
    public function actionLapphieu()
    {
        $nhapxuatkho = Nhapxuatkho::findOne($_POST['manxhang']);
        $phuongthuc = $nhapxuatkho->phuongthuc;
        $datra = $nhapxuatkho->datra + intval(str_replace('.','',\Yii::$app->request->post('Nhapxuatkho')['datra']));
        $sotientra = intval(str_replace('.','',\Yii::$app->request->post('Nhapxuatkho')['datra']));
        $tienno = $nhapxuatkho->thanhtien - $datra;
        $thanhtien = $nhapxuatkho->thanhtien;
        if ($nhapxuatkho->load(\Yii::$app->request->post()))
        {
            $nhapxuatkho->datra = $datra;
            $nhapxuatkho->phuongthuc = ($tienno == 0)?'dathanhtoan':$phuongthuc;
            if ($nhapxuatkho->save())
            {
                $thuchi = new Thuchi();
                $thuchi->load(\Yii::$app->request->post());
                $thuchi->nhapxuatkho_id = $nhapxuatkho->id;
                $thuchi->nhacungcap_khachhang_id = $nhapxuatkho->nhacungcap_khachhang_id;
                $thuchi->sotientra = $sotientra;
                $nhacckhachhang = Nhacungcapkhachhang::findOne($nhapxuatkho->nhacungcap_khachhang_id);
                if($nhapxuatkho->type == 'tralai'){
                    if($nhacckhachhang->type == 'nhacungcap'){
                        $thuchi->type = 'phieuthu';
                    }
                    else{
                        $thuchi->type = 'phieuchi';
                    }
                }else {
                    $thuchi->type = ($nhapxuatkho->type == 'nhapkho') ? 'phieuchi' : 'phieuthu';
                }
                if ($thuchi->save())
                {
                    $noiDungIn = '';
                    if($_POST['type'] == 'saveandprint')
                        $noiDungIn = (new Nhapxuatkho())->getPrintContent_thuchi($thuchi->id);
                    echo Json::encode(['error' => false, 'message' => myFuncs::getMessage('Thông báo','success',"Đã lưu phiếu!"),'noiDungIn' => $this->renderAjax('_phieuxuatkho', ['noidungin' => $noiDungIn]),'datra'=>number_format($nhapxuatkho->datra,0,'','.'),'thanhtien'=>number_format($nhapxuatkho->thanhtien,0,'','.'),'conno'=>number_format(intval($nhapxuatkho->thanhtien) - intval($nhapxuatkho->datra),0,'','.')]);
                }
            }else
            {
                echo Json::encode(['error' => true, 'class' => 'nhapxuatkho', 'errors' => $nhapxuatkho->getErrors(), 'message' => '']);
            }
        }
    }
    public function actionLapphieunhacungcap(){
        $thuchi = new Thuchi();
        $thuchi->load(\Yii::$app->request->post());
        $thuchi->nhacungcap_khachhang_id = $_POST['manhacc'];
        $thuchi->tienhoadon = intval(str_replace('.','',$_POST['Thuchi']['sotientra']));
        $thuchi->sotientra = intval(str_replace('.','',$_POST['Thuchi']['sotientra']));
        if(explode('.',$_POST['Thuchi']['maphieu'])[0] == 'PC') {
            $thuchi->type = 'phieuchi';
        }else{
            $thuchi->type = "phieuthu";
        }
        if($thuchi->save()){
            $noiDungIn = '';
            if ($_POST['type'] == 'saveandprint')
                $noiDungIn = (new Nhapxuatkho())->getPrintContent_thuchi($thuchi->id);
            echo Json::encode(['error' => false,'noiDungIn' => $this->renderAjax('_phieuxuatkho', ['noidungin' => $noiDungIn]),'message' => myFuncs::getMessage('Thông báo','success',"Đã lưu phiếu!")]);
        }
        else
        {
            echo Json::encode(['error' => true, 'class' => 'thuchi', 'errors' => $thuchi->getErrors(), 'message' => '']);
        }
    }
    public function actionDel(){

        if(isset($_POST['idphieu'])){
            $nhapxuatkho = Nhapxuatkho::findOne($_POST['idphieu']);
            if($nhapxuatkho->type == 'tralai'){
                Thuchi::findOne(['nhapxuatkho_id'=>$nhapxuatkho->id])->delete();
            }
            Nhapxuatkho::findOne($_POST['idphieu'])->delete();
            echo Json::encode(myFuncs::getMessage('Thông báo','success','Đã xóa xong!'));
        }
    }
    public function actionXoathue(){

        if(isset($_POST['idphieu'])){
            Nhapxuatkho::findOne($_POST['idphieu'])->delete();
            $sophieutrongthang = count(Nhapxuatkho::find()->where(['type'=>'thuthue'])->all());
            $maphieulaps = Nhapxuatkho::find()->where(['type'=>'thuthue'])->all();
            foreach($maphieulaps as $maphieulap)
            {
                if ($sophieutrongthang <= intval(explode('.', $maphieulap->maphieu)[1]))
                    $sophieutrongthang = intval(explode('.', $maphieulap->maphieu)[1])+1;
            }
            $danhsachthues = Nhapxuatkho::find()->where(['type'=>'thuthue'])->orderBy(['id'=>SORT_DESC])->all();
            $table = "<table class=\"table table-striped table-bordered table-hover\" id=\"sample_1\">
                            <thead>
                            <th>Mã phiếu </th>
                            <th>Tên </th>
                            <th>Ngày tạo </th>
                            <th>Tiền thuế </th>
                            <th>Trạng thái </th>
                            <th>Chức năng </th>
                            </thead>
                            <tbody>";
            $tr = "";

            foreach ($danhsachthues as $danhsachthue){
                $danhsachthue->phuongthuc == 'congno'?$congno = "Chưa thanh toán":$congno = "Đã thanh toán";
                $danhsachthue->thanhtien = number_format($danhsachthue->thanhtien,0,'','.');
                $tr .= "<tr><td>{$danhsachthue->maphieu}</td>
                            <td> {$danhsachthue->nhacungcapkhachhang->name} </td>
                            <td> {$danhsachthue->ngaygiaodich} </td>
                            <td style='text-align: right'>{$danhsachthue->thanhtien}</td>
                            <td>
                                {$congno}
                            </td>
                            <td style='text-align: center'>
                                <a href='index.php?r=nhapxuathang/thuthue?id={$danhsachthue->id}' class = 'btn-success fa fa-edit' style = 'margin-right: 10px;' ></a>
                                <a href='index.php?r=nhapxuathang/thuthue' class = 'btn-danger fa fa-trash-o btn-del' id = '{$danhsachthue->id}' ></a>
                            </td></tr>";
            }
            $table = $table.$tr."</tbody></table>";
            echo Json::encode(['message'=>myFuncs::getMessage('Thông báo','success','Đã xóa xong!'),'maphieumoi' => "TT.00".($sophieutrongthang),'table'=>$table]);
        }
    }

    public function actionXoanodauky(){

        if(isset($_POST['idphieu'])){
            Nhapxuatkho::findOne($_POST['idphieu'])->delete();
            $sophieutrongthang = count(Nhapxuatkho::find()->where(['type'=>'nodauky'])->all());
            $maphieulaps = Nhapxuatkho::find()->where(['type'=>'nodauky'])->all();
            foreach($maphieulaps as $maphieulap)
            {
                if ($sophieutrongthang <= intval(explode('.', $maphieulap->maphieu)[1]))
                    $sophieutrongthang = intval(explode('.', $maphieulap->maphieu)[1])+1;
            }
            $danhsachthues = Nhapxuatkho::find()->where(['type'=>'nodauky'])->orderBy(['id'=>SORT_DESC])->all();
            $table = "<table class=\"table table-striped table-bordered table-hover\" id=\"sample_1\">
                            <thead>
                            <th>Mã phiếu </th>
                            <th>Tên </th>
                            <th>Ngày tạo </th>
                            <th>Tiền nợ </th>
                            <th>Trạng thái </th>
                            <th>Chức năng </th>
                            </thead>
                            <tbody>";
            $tr = "";

            foreach ($danhsachthues as $danhsachthue){
                $danhsachthue->phuongthuc == 'congno'?$congno = "Chưa thanh toán":$congno = "Đã thanh toán";
                $danhsachthue->thanhtien = number_format($danhsachthue->thanhtien,0,'','.');
                $tr .= "<tr><td>{$danhsachthue->maphieu}</td>
                            <td> {$danhsachthue->nhacungcapkhachhang->name} </td>
                            <td> {$danhsachthue->ngaygiaodich} </td>
                            <td style='text-align: right'>{$danhsachthue->thanhtien}</td>
                            <td>
                                {$congno}
                            </td>
                            <td style='text-align: center'>
                                <a href='index.php?r=nhapxuathang/nodauky?id={$danhsachthue->id}' class = 'btn-success fa fa-edit' style = 'margin-right: 10px;' ></a>
                                <a href='index.php?r=nhapxuathang/nodauky' class = 'btn-danger fa fa-trash-o btn-del' id = '{$danhsachthue->id}' ></a>
                            </td></tr>";
            }
            $table = $table.$tr."</tbody></table>";
            echo Json::encode(['message'=>myFuncs::getMessage('Thông báo','success','Đã xóa xong!'),'maphieumoi' => "TT.00".($sophieutrongthang),'table'=>$table]);
        }
    }

    public function actionUpdate($idphieu){

        $phieu = Nhapxuatkho::findOne($idphieu);
        if($phieu->type == 'nhaptondauky')
            $this->redirect(\Yii::$app->urlManager->createUrl(['nhapxuathang/nhaptondauky','id' => $idphieu]));
        else if ($phieu->type == 'nhapkho')
            $this->redirect(\Yii::$app->urlManager->createUrl(['nhapxuathang/nhaptheohoadon','id' => $idphieu]));
        else if ($phieu->type == 'xuatkho'&&!is_null($phieu->congtrinh_id))
            $this->redirect(\Yii::$app->urlManager->createUrl(['nhapxuathang/xuattheocongtrinh','id' => $idphieu]));
        else if ($phieu->type == 'xuatkho'&&is_null($phieu->congtrinh_id))
            $this->redirect(\Yii::$app->urlManager->createUrl(['nhapxuathang/banhang','id' => $idphieu]));
        else if ($phieu->type == 'tralai'&&$phieu->nhacungcapkhachhang->type=='khachhang')
            $this->redirect(\Yii::$app->urlManager->createUrl(['nhapxuathang/trahang','id' => $idphieu]));
        else if ($phieu->type == 'tralai'&&$phieu->nhacungcapkhachhang->type=='nhacungcap')
            $this->redirect(\Yii::$app->urlManager->createUrl(['nhapxuathang/trahangnhacungcap','id' => $idphieu]));

    }

    public function actionBanhang(){
        $mang = [];
        if(isset($_GET['id'])){
            $phieuxuatkho = Nhapxuatkho::findOne($_GET['id']);
            $khachhang = $phieuxuatkho->nhacungcapkhachhang;
            $phieuxuatkho->ngaygiaodich  = date("d/m/Y", strtotime($phieuxuatkho->ngaygiaodich));
            foreach($phieuxuatkho->chitietthicongs as $nhanvienthicong)
            {
                $mang[] = $nhanvienthicong->nhanvienthicong_id;
            }
        }else{
            $sophieutrongthang = (Nhapxuatkho::find()->select('id')->where(['type'=>'xuatkho'])->count());
            $khachhang = new Nhacungcapkhachhang();
            $phieuxuatkho = new Nhapxuatkho();
            $phieuxuatkho->setScenario('nhapmoi');
            $maphieulap = Nhapxuatkho::find()->select('maphieu')->where(['type'=>'xuatkho'])->orderBy(['id' => SORT_DESC])->limit(1)->one();
            if ($sophieutrongthang <= intval(explode('.', $maphieulap->maphieu)[1]))
                $sophieutrongthang = intval(explode('.', $maphieulap->maphieu)[1])+1;
            $phieuxuatkho->maphieu = "XK.00".($sophieutrongthang);
            $phieuxuatkho->ngaygiaodich = date("d/m/Y");
        }
        $chitietxuatnhapkho = new Chitietxuatnhapkho();
        return $this->render('banhang',
            [
                'khachhang' => $khachhang,
                'phieuxuatkho' => $phieuxuatkho,
                'chitietxuatnhapkho' => $chitietxuatnhapkho,
                'hanghoa'=> new Hanghoa(),
                'nhanvienthicong'=> new Nhanvienthicong(),
                'mang'=>$mang,
            ]
        );
    }

    public function actionXuattheocongtrinh(){
        $mang = [];
        if(isset($_GET['id'])){
            $phieuxuatkho = Nhapxuatkho::findOne($_GET['id']);
            $khachhang = $phieuxuatkho->nhacungcapkhachhang;
            $phieuxuatkho->ngaygiaodich  = date("d/m/Y", strtotime($phieuxuatkho->ngaygiaodich));
            foreach($phieuxuatkho->chitietthicongs as $nhanvienthicong)
            {
                $mang[] = $nhanvienthicong->nhanvienthicong_id;
            }
        }else{
            $sophieutrongthang = (Nhapxuatkho::find()->where(['type'=>'xuatkho'])->count());
            $khachhang = new Nhacungcapkhachhang();
            $phieuxuatkho = new Nhapxuatkho();
            $phieuxuatkho->setScenario('nhapmoi');
            $maphieulap = Nhapxuatkho::find()->select('maphieu')->where(['type'=>'xuatkho'])->orderBy(['id' => SORT_DESC])->limit(1)->one();
            if ($sophieutrongthang <= intval(explode('.', $maphieulap->maphieu)[1]))
                $sophieutrongthang = intval(explode('.', $maphieulap->maphieu)[1])+1;
            $phieuxuatkho->maphieu = "XKCT.00".($sophieutrongthang);
            $phieuxuatkho->ngaygiaodich = date("d/m/Y");
        }
        $chitietxuatnhapkho = new Chitietxuatnhapkho();
        return $this->render('xuathangtheocongtrinh',
            [
                'khachhang' => $khachhang,
                'phieuxuatkho' => $phieuxuatkho,
                'chitietxuatnhapkho' => $chitietxuatnhapkho,
                'hanghoa'=> new Hanghoa(),
                'nhanvienthicong'=> new Nhanvienthicong(),
                'mang'=>$mang,
            ]
        );
    }

    public function actionTrahang()
    {

        if(isset($_GET['id'])){
            $phieuxuatkho = Nhapxuatkho::findOne($_GET['id']);
            $khachhang = $phieuxuatkho->nhacungcapkhachhang;
            $phieuxuatkho->ngaygiaodich  = date("d/m/Y", strtotime($phieuxuatkho->ngaygiaodich));
        }else{
            $sophieutrongthang = (Nhapxuatkho::find()->where(['type'=>'tralai'])->count());
            $khachhang = new Nhacungcapkhachhang();
            $phieuxuatkho = new Nhapxuatkho();
            $phieuxuatkho->setScenario('nhapmoi');
            $maphieulap = Nhapxuatkho::find()->select('maphieu')->where(['type'=>'tralai'])->orderBy(['id' => SORT_DESC])->limit(1)->one();
            if ($sophieutrongthang <= intval(explode('.', $maphieulap->maphieu)[1]))
                $sophieutrongthang = intval(explode('.', $maphieulap->maphieu)[1])+1;
            $phieuxuatkho->maphieu = "TL.00".($sophieutrongthang);
            $phieuxuatkho->ngaygiaodich = date("d/m/Y");
        }
        $chitietxuatnhapkho = new Chitietxuatnhapkho();
        return $this->render('trahang',
            [
                'khachhang' => $khachhang,
                'phieuxuatkho' => $phieuxuatkho,
                'chitietxuatnhapkho' => $chitietxuatnhapkho,
            ]
        );
    }

    public function actionTrahangnhacungcap()
    {

        if(isset($_GET['id'])){
            $phieuxuatkho = Nhapxuatkho::findOne($_GET['id']);
            $khachhang = $phieuxuatkho->nhacungcapkhachhang;
            $phieuxuatkho->ngaygiaodich  = date("d/m/Y", strtotime($phieuxuatkho->ngaygiaodich));
        }else{
            $sophieutrongthang = (Nhapxuatkho::find()->where(['type'=>'tralai'])->count());
            $khachhang = new Nhacungcapkhachhang();
            $phieuxuatkho = new Nhapxuatkho();
            $phieuxuatkho->setScenario('nhapmoi');
            $maphieulap = Nhapxuatkho::find()->select('maphieu')->where(['type'=>'tralai'])->orderBy(['id' => SORT_DESC])->limit(1)->one();
            if ($sophieutrongthang <= intval(explode('.', $maphieulap->maphieu)[1]))
                $sophieutrongthang = intval(explode('.', $maphieulap->maphieu)[1])+1;
            $phieuxuatkho->maphieu = "TL.00".($sophieutrongthang);
            $phieuxuatkho->ngaygiaodich = date("d/m/Y");
        }
        $chitietxuatnhapkho = new Chitietxuatnhapkho();
        return $this->render('trahangnhacungcap',
            [
                'khachhang' => $khachhang,
                'phieuxuatkho' => $phieuxuatkho,
                'chitietxuatnhapkho' => $chitietxuatnhapkho,
            ]
        );
    }

    public function actionNhaptheohoadon(){
        if(isset($_GET['id'])){
            $nhapxuatkho = Nhapxuatkho::findOne($_GET['id']);
            $nhacungcap = $nhapxuatkho->nhacungcapkhachhang;
            $nhapxuatkho->ngaygiaodich  = date("d/m/Y", strtotime($nhapxuatkho->ngaygiaodich));
        }else{
            $sophieutrongthang = (Nhapxuatkho::find()->where(['type'=>'nhapkho'])->count());
            $nhacungcap = new Nhacungcapkhachhang();
            $nhapxuatkho = new Nhapxuatkho();
            $nhapxuatkho->setScenario('nhapmoi');
            $maphieulap = Nhapxuatkho::find()->select('maphieu')->where(['type'=>'nhapkho'])->orderBy(['id' => SORT_DESC])->limit(1)->one();
            if ($sophieutrongthang <= intval(explode('.', $maphieulap->maphieu)[1]))
                $sophieutrongthang = intval(explode('.', $maphieulap->maphieu)[1])+1;
            $nhapxuatkho->maphieu = "NK.00".$sophieutrongthang;
            $nhapxuatkho->ngaygiaodich = date("d/m/Y");
        }
        $chitietnhapxuat = new Chitietxuatnhapkho();
        return $this->render('nhaptheohoadon',
            [
                'nhapxuatkho' => $nhapxuatkho,
                'chitietxuatnhapkho' => $chitietnhapxuat,
                'hanghoa' => new Hanghoa(),
                'nhacungcap'=>$nhacungcap
            ]
        );
    }

    public function actionSavetheohoadon(){
        $nhacungcap = new Nhacungcapkhachhang();
        $nhacungcap->load(\Yii::$app->request->post());
        $nhacungcapcu = Nhacungcapkhachhang::find()->where(['name'=>$nhacungcap->name,'dienthoai'=>$nhacungcap->dienthoai])->one();
        if(count($nhacungcapcu) > 0){
            $nhacungcapcu->load(\Yii::$app->request->post());
        }
        else{
            $nhacungcapcu = new Nhacungcapkhachhang();
            $nhacungcapcu->load(\Yii::$app->request->post());
        }

        $loi = [];
        if (isset($_POST['Nhacungcapkhachhang']['name']))
        {
            if ($_POST['Nhacungcapkhachhang']['name'] == '')
                $loi[] = 'Tên nhà cung cấp không được để trống';
        }
        if (isset($_POST['Chitietxuatnhapkho'])){
            if (count($_POST['Chitietxuatnhapkho'])==1)
            {
                if (isset($_POST['Chitietxuatnhapkho'][0]['hanghoa_id'])) {
                    if ($_POST['Chitietxuatnhapkho'][0]['hanghoa_id'] == '')
                        $loi[] = 'Chưa có mặt hàng nào được nhập';
                    if (isset($_POST['Chitietxuatnhapkho'][0]['dongia']))
                        $_POST['Chitietxuatnhapkho'][0]['dongia'] = intval(str_replace('.','',$_POST['Chitietxuatnhapkho'][0]['dongia']));
                }
                if (isset($_POST['Chitietxuatnhapkho'][1]['hanghoa_id'])||!isset($_POST['Chitietxuatnhapkho'][1]['dongia'])||!isset($_POST['Chitietxuatnhapkho'][1]['soluong']))
                    $loi[] = 'Không có dữ liệu về mặt hàng này';
            }else if (count($_POST['Chitietxuatnhapkho']) > 1)
            {
                array_pop($_POST['Chitietxuatnhapkho']);
                foreach($_POST['Chitietxuatnhapkho'] as $key=>$val){
                    if (isset($val['hanghoa_id'])){
                        if ($val['hanghoa_id'] == '')
                            $loi[] = 'Chưa nhập đầy đủ mã hàng';
                        if($_POST['Chitietxuatnhapkho'][$key]['dongia'] == "")
                            $loi[] = "Chưa nhập đầy đủ đơn giá các mặt hàng";
                        if($_POST['Chitietxuatnhapkho'][$key]['soluong'] == '')
                            $loi[] = "Chưa nhập đầy đủ số lượng các mặt hàng";
                        if(count($loi) > 0)
                            break;
                    }
                    if (isset($_POST['Chitietxuatnhapkho'][$key]['dongia']))
                        $_POST['Chitietxuatnhapkho'][$key]['dongia'] = intval(str_replace('.','',$_POST['Chitietxuatnhapkho'][$key]['dongia']));
                }

            }
            if (count($loi)>0)
            {
                echo Json::encode(['error' => true, 'class' => 'chitietxuatnhapkho', 'errors' => [], 'message' => myFuncs::getMessage('Lỗi','danger',implode('<br/>',$loi))]);
            }else{

                $nhacungcapcu->type = 'nhacungcap';
                $nhacungcapcu->save();
                if($_POST['idnhapxuatkho'] !="")
                    $nhapxuatkho = Nhapxuatkho::findOne($_POST['idnhapxuatkho']);
                else{
                    $nhapxuatkho = new Nhapxuatkho();
                    $nhapxuatkho->setScenario('nhapmoi');
                }
                $nhapxuatkho->load(\Yii::$app->request->post());
                $nhapxuatkho->type = 'nhapkho';
                $nhapxuatkho->dienthoai = $nhacungcapcu->dienthoai;
                $nhapxuatkho->diachi = $nhacungcapcu->diachi;
                $nhapxuatkho->nhanviengiaodich = \Yii::$app->user->getId();
                $nhapxuatkho->nhacungcap_khachhang_id = $nhacungcapcu->id;
                $nhapxuatkho->phuongthuc = 'congno';
                $nhapxuatkho->save();

                $noiDungIn = '';
                if($_POST['type'] == 'saveandprint')
                    $noiDungIn = (new Nhapxuatkho())->getPrintContent_phieunhap($nhapxuatkho->id,0);
                $sophieutrongthang = (Nhapxuatkho::find()->where(['type'=>'nhapkho'])->count());
                $maphieulap = Nhapxuatkho::find()->select('maphieu')->where(['type'=>'nhapkho'])->orderBy(['id' => SORT_DESC])->limit(1)->one();
                if ($sophieutrongthang <= intval(explode('.', $maphieulap->maphieu)[1]))
                    $sophieutrongthang = intval(explode('.', $maphieulap->maphieu)[1])+1;
                echo Json::encode(['error' => false,'idphieucu'=>$nhapxuatkho->id,'message' => myFuncs::getMessage('Thông báo','success', 'Đã lưu xong'), 'noiDungIn' => $this->renderAjax('_phieuxuatkho', ['noidungin' => $noiDungIn]),'maphieumoi' => "NK.00".$sophieutrongthang,'ngaygiaodichmoi'=>date('d/m/Y',time())]);
            }
        }
    }

    public function actionXuatkho(){
        $khachhang = new Nhacungcapkhachhang();
        $khachhang->load(\Yii::$app->request->post());
        $khachhangcu = Nhacungcapkhachhang::find()->where(['dienthoai' => $khachhang->dienthoai,'name'=>$khachhang->name])->one();
        if(count($khachhangcu) > 0){
            $khachhangcu->load(\Yii::$app->request->post());
        }
        else{
            $khachhangcu = new Nhacungcapkhachhang();
            $khachhangcu->load(\Yii::$app->request->post());
        }
        $loi = [];
        if (isset($_POST['Nhacungcapkhachhang']['name']))
        {
            if ($_POST['Nhacungcapkhachhang']['name'] == '')
                $loi[] = 'Tên khách hàng không được để trống';
        }
        if (isset($_POST['Nhapxuatkho']['congtrinh_id']))
        {
            if ($_POST['Nhapxuatkho']['congtrinh_id'] == '')
                $loi[] = 'Công trình không được để trống';
            if (intval(str_replace('.','',$_POST['Nhapxuatkho']['tongtien'])) <= 0)
                $loi[] = 'Thành tiền hạng mục phải lớn hơn 0';
        }
        if (isset($_POST['Chitietxuatnhapkho'])){
            if (count($_POST['Chitietxuatnhapkho'])==1)
            {
                if (isset($_POST['Chitietxuatnhapkho'][0]['hanghoa_id'])) {
                    if ($_POST['Chitietxuatnhapkho'][0]['hanghoa_id'] == '')
                        $loi[] = 'Chưa có mặt hàng nào được nhập';
                    if (isset($_POST['Chitietxuatnhapkho'][0]['dongia']))
                        $_POST['Chitietxuatnhapkho'][0]['dongia'] = intval(str_replace('.','',$_POST['Chitietxuatnhapkho'][0]['dongia']));
                }
                if (isset($_POST['Chitietxuatnhapkho'][1]['hanghoa_id'])||!isset($_POST['Chitietxuatnhapkho'][1]['dongia'])||!isset($_POST['Chitietxuatnhapkho'][1]['soluong']))
                    $loi[] = 'Không có dữ liệu về mặt hàng này';
            }else if (count($_POST['Chitietxuatnhapkho']) > 1)
            {
                array_pop($_POST['Chitietxuatnhapkho']);
                foreach($_POST['Chitietxuatnhapkho'] as $key=>$val){
                    if (isset($val['hanghoa_id'])){
                        if ($val['hanghoa_id'] == '')
                            $loi[] = 'Chưa nhập đầy đủ mã hàng';
                        if(isset($_POST['Chitietxuatnhapkho'][$key]['dongia']))
                        {
                            if ($_POST['Chitietxuatnhapkho'][$key]['dongia'] == "")
                                $loi[] = "Chưa nhập đầy đủ đơn giá các mặt hàng";
                        }
                        if($_POST['Chitietxuatnhapkho'][$key]['soluong'] == '')
                            $loi[] = "Chưa nhập đầy đủ số lượng các mặt hàng";
                        if(count($loi) > 0)
                            break;
                    }
                    if (isset($_POST['Chitietxuatnhapkho'][$key]['dongia']))
                        $_POST['Chitietxuatnhapkho'][$key]['dongia'] = intval(str_replace('.','',$_POST['Chitietxuatnhapkho'][$key]['dongia']));
                }

            }
            if (count($loi)>0)
            {
                echo Json::encode(['error' => true, 'class' => 'chitietxuatnhapkho', 'errors' => [], 'message' => myFuncs::getMessage('Lỗi','danger',implode('<br/>',$loi))]);
            }else{

                $khachhangcu->save();
                if($_POST['idhoadonban'] != ""){
                    $phieuxuatkho = Nhapxuatkho::findOne($_POST['idhoadonban']);
                }
                else{
                    $phieuxuatkho = new Nhapxuatkho();
                    $phieuxuatkho->setScenario('nhapmoi');
                }
                $phieuxuatkho->load(\Yii::$app->request->post());
                $phieuxuatkho->type = 'xuatkho';
                $phieuxuatkho->dienthoai = $khachhangcu->dienthoai;
                $phieuxuatkho->diachi = $khachhangcu->diachi;
                $phieuxuatkho->nhanviengiaodich = \Yii::$app->user->getId();
                $phieuxuatkho->nhacungcap_khachhang_id = $khachhangcu->id;
                $phieuxuatkho->phuongthuc = 'congno';
                $phieuxuatkho->save();
                $noiDungIn = '';
                if($_POST['type'] == 'saveandprint')
                    $noiDungIn = (new Nhapxuatkho())->getPrintContent($phieuxuatkho->id,0);
                $sophieutrongthang = (Nhapxuatkho::find()->where(['type'=>'xuatkho'])->count());
                $maphieulap = Nhapxuatkho::find()->select('maphieu')->where(['type'=>'xuatkho'])->orderBy(['id' => SORT_DESC])->limit(1)->one();
                if ($sophieutrongthang <= intval(explode('.', $maphieulap->maphieu)[1]))
                    $sophieutrongthang = intval(explode('.', $maphieulap->maphieu)[1])+1;
                echo Json::encode(['error' => false,'idphieucu'=>$phieuxuatkho->id,'message' => myFuncs::getMessage('Thông báo','success', 'Đã lưu xong'), 'noiDungIn' => $this->renderAjax('_phieuxuatkho', ['noidungin' => $noiDungIn]),'maphieumoi' => "XK.00".($sophieutrongthang),'ngaygiaodichmoi'=>date('d/m/Y',time())]);
            }
        }

    }

    public function actionLuuthue(){
        $khachhang = new Nhacungcapkhachhang();
        $khachhang->load(\Yii::$app->request->post());
        $khachhangcu = Nhacungcapkhachhang::find()->where(['dienthoai' => $khachhang->dienthoai,'name'=>$khachhang->name])->one();
        if(count($khachhangcu) > 0){
            $khachhangcu->load(\Yii::$app->request->post());
        }
        else{
            $khachhangcu = new Nhacungcapkhachhang();
            $khachhangcu->load(\Yii::$app->request->post());
        }
        $loi = [];
        if (isset($_POST['Nhacungcapkhachhang']['name']))
        {
            if ($_POST['Nhacungcapkhachhang']['name'] == '')
                $loi[] = 'Tên khách hàng không được để trống';
        }
            if (count($loi) > 0) {
                echo Json::encode(['error' => true, 'class' => 'chitietxuatnhapkho', 'errors' => [], 'message' => myFuncs::getMessage('Lỗi', 'danger', implode('<br/>', $loi))]);
            } else {

                $khachhangcu->save();
                if ($_POST['idhoadonban'] != "") {
                    $phieuxuatkho = Nhapxuatkho::findOne($_POST['idhoadonban']);
                } else {
                    $phieuxuatkho = new Nhapxuatkho();
                    $phieuxuatkho->setScenario('nhapmoi');
                }
                $phieuxuatkho->load(\Yii::$app->request->post());
                $phieuxuatkho->type = 'thuthue';
                $phieuxuatkho->dienthoai = $khachhangcu->dienthoai;
                $phieuxuatkho->diachi = $khachhangcu->diachi;
                $phieuxuatkho->nhanviengiaodich = \Yii::$app->user->getId();
                $phieuxuatkho->nhacungcap_khachhang_id = $khachhangcu->id;
                $phieuxuatkho->phuongthuc = 'congno';
                $phieuxuatkho->thanhtien = str_replace('.','',$_POST['Nhapxuatkho']['thanhtien']);

                    $phieuxuatkho->save();
                $sophieutrongthang = count(Nhapxuatkho::find()->where(['type'=>'thuthue'])->all());
                $maphieulaps = Nhapxuatkho::find()->where(['type'=>'thuthue'])->all();
                foreach($maphieulaps as $maphieulap)
                {
                    if ($sophieutrongthang <= intval(explode('.', $maphieulap->maphieu)[1]))
                        $sophieutrongthang = intval(explode('.', $maphieulap->maphieu)[1])+1;
                }
                $danhsachthues = Nhapxuatkho::find()->where(['type'=>'thuthue'])->orderBy(['id'=>SORT_DESC])->all();
                $table = "<table class=\"table table-striped table-bordered table-hover\" id=\"sample_1\">
                            <thead>
                            <th>Mã phiếu </th>
                            <th>Tên </th>
                            <th>Ngày tạo </th>
                            <th>Tiền thuế </th>
                            <th>Trạng thái </th>
                            <th>Chức năng </th>
                            </thead>
                            <tbody>";
                $tr = "";

                foreach ($danhsachthues as $danhsachthue){
                    $danhsachthue->phuongthuc == 'congno'?$congno = "Chưa thanh toán":$congno = "Đã thanh toán";
                    $danhsachthue->thanhtien = number_format($danhsachthue->thanhtien,0,'','.');
                    $tr .= "<tr><td>{$danhsachthue->maphieu}</td>
                            <td> {$danhsachthue->nhacungcapkhachhang->name} </td>
                            <td> {$danhsachthue->ngaygiaodich} </td>
                            <td style='text-align: right'>{$danhsachthue->thanhtien}</td>
                            <td>
                                {$congno}
                            </td>
                            <td style='text-align: center'>
                                <a href='index.php?r=nhapxuathang/thuthue?id={$danhsachthue->id}' class = 'btn-success fa fa-edit' style = 'margin-right: 10px;' ></a>
                                <a href='index.php?r=nhapxuathang/thuthue' class = 'btn-danger fa fa-trash-o btn-del' id = '{$danhsachthue->id}' ></a>
                            </td></tr>";
                }
                $table = $table.$tr."</tbody></table>";
                echo Json::encode(['error' => false,'idphieucu'=>$phieuxuatkho->id,'message' => myFuncs::getMessage('Thông báo','success', 'Đã lưu xong'),'maphieumoi' => "TT.00".($sophieutrongthang),'ngaygiaodichmoi'=>date('d/m/Y',time()),'table'=>$table]);
            }
    }

    public function actionLuunodauky(){
        $khachhang = new Nhacungcapkhachhang();
        $khachhang->load(\Yii::$app->request->post());
        $khachhangcu = Nhacungcapkhachhang::find()->where(['dienthoai' => $khachhang->dienthoai,'name'=>$khachhang->name])->one();
        if(count($khachhangcu) > 0){
            $khachhangcu->load(\Yii::$app->request->post());
        }
        else{
            $khachhangcu = new Nhacungcapkhachhang();
            $khachhangcu->load(\Yii::$app->request->post());
        }
        $loi = [];
        if (isset($_POST['Nhacungcapkhachhang']['name']))
        {
            if ($_POST['Nhacungcapkhachhang']['name'] == '')
                $loi[] = 'Tên khách hàng không được để trống';
        }
        if (count($loi) > 0) {
            echo Json::encode(['error' => true, 'class' => 'chitietxuatnhapkho', 'errors' => [], 'message' => myFuncs::getMessage('Lỗi', 'danger', implode('<br/>', $loi))]);
        } else {

            $khachhangcu->save();
            if ($_POST['idhoadonban'] != "") {
                $phieuxuatkho = Nhapxuatkho::findOne($_POST['idhoadonban']);
            } else {
                $phieuxuatkho = new Nhapxuatkho();
                $phieuxuatkho->setScenario('nhapmoi');
            }
            $phieuxuatkho->load(\Yii::$app->request->post());
            $phieuxuatkho->type = 'nodauky';
            $phieuxuatkho->dienthoai = $khachhangcu->dienthoai;
            $phieuxuatkho->diachi = $khachhangcu->diachi;
            $phieuxuatkho->nhanviengiaodich = \Yii::$app->user->getId();
            $phieuxuatkho->nhacungcap_khachhang_id = $khachhangcu->id;
            $phieuxuatkho->phuongthuc = 'congno';
            $phieuxuatkho->thanhtien = str_replace('.','',$_POST['Nhapxuatkho']['thanhtien']);

            $phieuxuatkho->save();
            $sophieutrongthang = count(Nhapxuatkho::find()->where(['type'=>'nodauky'])->all());
            $maphieulaps = Nhapxuatkho::find()->where(['type'=>'nodauky'])->all();
            foreach($maphieulaps as $maphieulap)
            {
                if ($sophieutrongthang <= intval(explode('.', $maphieulap->maphieu)[1]))
                    $sophieutrongthang = intval(explode('.', $maphieulap->maphieu)[1])+1;
            }
            $danhsachthues = Nhapxuatkho::find()->where(['type'=>'nodauky'])->orderBy(['id'=>SORT_DESC])->all();
            $table = "<table class=\"table table-striped table-bordered table-hover\" id=\"sample_1\">
                            <thead>
                            <th>Mã phiếu </th>
                            <th>Tên </th>
                            <th>Ngày tạo </th>
                            <th>Tiền nợ </th>
                            <th>Trạng thái </th>
                            <th>Chức năng </th>
                            </thead>
                            <tbody>";
            $tr = "";

            foreach ($danhsachthues as $danhsachthue){
                $danhsachthue->phuongthuc == 'congno'?$congno = "Chưa thanh toán":$congno = "Đã thanh toán";
                $danhsachthue->thanhtien = number_format($danhsachthue->thanhtien,0,'','.');
                $tr .= "<tr><td>{$danhsachthue->maphieu}</td>
                            <td> {$danhsachthue->nhacungcapkhachhang->name} </td>
                            <td> {$danhsachthue->ngaygiaodich} </td>
                            <td style='text-align: right'>{$danhsachthue->thanhtien}</td>
                            <td>
                                {$congno}
                            </td>
                            <td style='text-align: center'>
                                <a href='index.php?r=nhapxuathang/nodauky?id={$danhsachthue->id}' class = 'btn-success fa fa-edit' style = 'margin-right: 10px;' ></a>
                                <a href='index.php?r=nhapxuathang/nodauky' class = 'btn-danger fa fa-trash-o btn-del' id = '{$danhsachthue->id}' ></a>
                            </td></tr>";
            }
            $table = $table.$tr."</tbody></table>";
            echo Json::encode(['error' => false,'idphieucu'=>$phieuxuatkho->id,'message' => myFuncs::getMessage('Thông báo','success', 'Đã lưu xong'),'maphieumoi' => "TT.00".($sophieutrongthang),'ngaygiaodichmoi'=>date('d/m/Y',time()),'table'=>$table]);
        }
    }

    public function actionTralai(){
        $khachhang = new Nhacungcapkhachhang();
        $khachhang->load(\Yii::$app->request->post());
        $khachhangcu = Nhacungcapkhachhang::find()->where(['dienthoai' => $khachhang->dienthoai,'name'=>$khachhang->name])->one();
        if(count($khachhangcu) > 0){
            $khachhangcu->load(\Yii::$app->request->post());
        }
        else{
            $khachhangcu = new Nhacungcapkhachhang();
            $khachhangcu->load(\Yii::$app->request->post());
        }
        $loi = [];
        if (isset($_POST['Nhacungcapkhachhang']['name']))
        {
            if ($_POST['Nhacungcapkhachhang']['name'] == '')
                $loi[] = 'Tên khách hàng không được để trống';
        }
        if (isset($_POST['Chitietxuatnhapkho'])){
            if (count($_POST['Chitietxuatnhapkho'])==1)
            {
                if (isset($_POST['Chitietxuatnhapkho'][0]['hanghoa_id'])) {
                    if ($_POST['Chitietxuatnhapkho'][0]['hanghoa_id'] == '')
                        $loi[] = 'Chưa có mặt hàng nào được nhập';
                    if (isset($_POST['Chitietxuatnhapkho'][0]['dongia']))
                        $_POST['Chitietxuatnhapkho'][0]['dongia'] = intval(str_replace('.','',$_POST['Chitietxuatnhapkho'][0]['dongia']));
                }
                if (isset($_POST['Chitietxuatnhapkho'][1]['hanghoa_id'])||!isset($_POST['Chitietxuatnhapkho'][1]['dongia'])||!isset($_POST['Chitietxuatnhapkho'][1]['soluong']))
                    $loi[] = 'Không có dữ liệu về mặt hàng này';
            }else if (count($_POST['Chitietxuatnhapkho']) > 1)
            {
                array_pop($_POST['Chitietxuatnhapkho']);
                foreach($_POST['Chitietxuatnhapkho'] as $key=>$val){
                    if (isset($val['hanghoa_id'])){
                        if ($val['hanghoa_id'] == '')
                            $loi[] = 'Chưa nhập đầy đủ mã hàng';
                        if($_POST['Chitietxuatnhapkho'][$key]['dongia'] == "")
                            $loi[] = "Chưa nhập đầy đủ đơn giá các mặt hàng";
                        if($_POST['Chitietxuatnhapkho'][$key]['soluong'] == '')
                            $loi[] = "Chưa nhập đầy đủ số lượng các mặt hàng";
                        if(count($loi) > 0)
                            break;
                    }
                    if (isset($_POST['Chitietxuatnhapkho'][$key]['dongia']))
                        $_POST['Chitietxuatnhapkho'][$key]['dongia'] = intval(str_replace('.','',$_POST['Chitietxuatnhapkho'][$key]['dongia']));
                }

            }
            if (count($loi)>0)
            {
                echo Json::encode(['error' => true, 'class' => 'chitietxuatnhapkho', 'errors' => [], 'message' => myFuncs::getMessage('Lỗi','danger',implode('<br/>',$loi))]);
            }else{

                $khachhangcu->save();
                if($_POST['idhoadonban'] != ""){
                    $phieuxuatkho = Nhapxuatkho::findOne($_POST['idhoadonban']);
                }
                else{
                    $phieuxuatkho = new Nhapxuatkho();
                    $phieuxuatkho->setScenario('nhapmoi');
                }
                $phieuxuatkho->load(\Yii::$app->request->post());
                $phieuxuatkho->type = 'tralai';
                $phieuxuatkho->dienthoai = $khachhangcu->dienthoai;
                $phieuxuatkho->diachi = $khachhangcu->diachi;
                $phieuxuatkho->nhanviengiaodich = \Yii::$app->user->getId();
                $phieuxuatkho->nhacungcap_khachhang_id = $khachhangcu->id;
                $phieuxuatkho->phuongthuc = 'congno';
                $phieuxuatkho->save();

                $noiDungIn = '';
                if($_POST['type'] == 'saveandprint')
                    $noiDungIn = (new Nhapxuatkho())->getPrintContent_trahang($phieuxuatkho->id);
                $sophieutrongthang = (Nhapxuatkho::find()->where(['type'=>'tralai'])->count());
                $maphieulap = Nhapxuatkho::find()->select('maphieu')->where(['type'=>'tralai'])->orderBy(['id' => SORT_DESC])->one();
                if ($sophieutrongthang <= intval(explode('.', $maphieulap->maphieu)[1]))
                    $sophieutrongthang = intval(explode('.', $maphieulap->maphieu)[1])+1;
                echo Json::encode(['error' => false,'message' => myFuncs::getMessage('Thông báo','success', 'Đã lưu xong'), 'noiDungIn' => $this->renderAjax('_phieuxuatkho', ['noidungin' => $noiDungIn]),'maphieumoi' => "TL.00".($sophieutrongthang),'ngaygiaodichmoi'=>date('d/m/Y',time())]);
            }
        }

    }
    public function actionXacnhanthanhtoan(){
        $idphieu = explode('-',$_POST['idhtmlphieu'])[1];
        $phieunhap = Nhapxuatkho::find()->where(['id'=>$idphieu])->one();
        $tienno = $phieunhap->thanhtien - $phieunhap->datra;
        $phieuthuchis = Thuchi::find()->where(['nhacungcap_khachhang_id'=>$phieunhap->nhacungcap_khachhang_id])->andWhere(['>','tienhoadon',0])->all();
        foreach ($phieuthuchis as $phieuthuchi){
            $tienno = $tienno - $phieuthuchi->tienhoadon;
            if(($tienno) > 0){
                $phieuthuchi->tienhoadon = 0;
                $phieuthuchi->ngaylap = date("d/m/Y", strtotime($phieuthuchi->ngaylap));
                $phieuthuchi->save();
            }
            else{
                $phieuthuchi->tienhoadon = -$tienno;
                $phieuthuchi->ngaylap = date("d/m/Y", strtotime($phieuthuchi->ngaylap));
                $phieuthuchi->save();
                break;
            }

        }
        $phieunhap->datra = $phieunhap->thanhtien;
        $phieunhap->phuongthuc = 'dathanhtoan';
        $phieunhap->ngaygiaodich = date("d/m/Y", strtotime($phieunhap->ngaygiaodich));
        if($phieunhap->save()){
            echo Json::encode(['error' => false, 'message' => myFuncs::getMessage('Thông báo','success',"Đã xác nhận!")]);
        }
        else
        {
            echo Json::encode(['error' => true, 'class' => 'phieuchi', 'errors' => $phieunhap->getErrors(), 'message' => '']);
        }

    }
    public function actionInphieuxuathang(){
        echo Json::encode(
            ['noidungin' => $this->renderAjax('_phieuxuatkho', ['noidungin' => (new Nhapxuatkho())->getPrintContent($_POST['idxuathang'],$_POST['xuatkho'])])]

        ) ;
    }
    public function actionInphieunhaphang(){
        echo Json::encode(
            ['noidungin' => $this->renderAjax('_phieuxuatkho', ['noidungin' => (new Nhapxuatkho())->getPrintContent_phieunhap($_POST['idnhaphang'])])]
        ) ;
    }
    public function actionInphieutrahang(){
        echo Json::encode(
            ['noidungin' => $this->renderAjax('_phieuxuatkho', ['noidungin' => (new Nhapxuatkho())->getPrintContent_trahang($_POST['idnhaphang'])])]
        ) ;
    }
    public function actionInphieuthuchi(){
        echo Json::encode(
            ['noidungin' => $this->renderAjax('_phieuxuatkho', ['noidungin' => (new Nhapxuatkho())->getPrintContent_thuchi($_POST['idphieu'])])]
        ) ;
    }
    public function actionInbangkehoadonbanhang(){
        if (isset($_POST['start'])&&isset($_POST['end']))
        {
            if (date('m',strtotime($_POST['start'])) == date('m',strtotime($_POST['end']))&&date('Y',strtotime($_POST['start'])) == date('Y',strtotime($_POST['end'])))
                $time = 'Tháng '.date('m',strtotime($_POST['start'])).' năm '.date('Y',strtotime($_POST['start']));
            else
                $time = 'Từ ngày '.date('d/m/Y',strtotime($_POST['start'])).' đến ngày '.date('d/m/Y',strtotime($_POST['end']));
        }
        if (isset($_POST['type'])&&$_POST['type'] == 'khachhang')
            $type = 'khachhang';
        else
            $type = 'all';
        if (isset($_POST['name'])&&$_POST['name']!='')
            $name = $_POST['name'];
        else
            $name = '';
        if (isset($_POST['table'])&&$_POST['table']!='')
            $table = $_POST['table'];
        else
            $table = '';
        if ($type == 'khachhang')
            echo Json::encode(
                ['noiDungIn' => $this->renderAjax('_phieuxuatkho', ['noidungin' => (new Nhapxuatkho())->getPrintContent_bangkehoadonbanhang($time,$name,$type,$table)])]
            );
        else
           echo Json::encode(
                ['noiDungIn' => $this->renderAjax('_inngang', ['noidungin' => (new Nhapxuatkho())->getPrintContent_bangkehoadonbanhang($time,$name,$type,$table)])]
            ); 
    }
    public function actionInchitiettranguoiban(){
        if (isset($_POST['start'])&&isset($_POST['end']))
        {
            if (date('m',strtotime($_POST['start'])) == date('m',strtotime($_POST['end']))&&date('Y',strtotime($_POST['start'])) == date('Y',strtotime($_POST['end'])))
                $time = 'Tháng '.date('m',strtotime($_POST['start'])).' năm '.date('Y',strtotime($_POST['start']));
            else
                $time = 'Từ ngày '.date('d/m/Y',strtotime($_POST['start'])).' đến ngày '.date('d/m/Y',strtotime($_POST['end']));
        }
        if (isset($_POST['name'])&&$_POST['name']!='')
            $name = $_POST['name'];
        else
            $name = '';
        if (isset($_POST['table'])&&$_POST['table']!='')
            $table = $_POST['table'];
        else
            $table = '';
        echo Json::encode(
            ['noiDungIn' => $this->renderAjax('_phieuxuatkho', ['noidungin' => (new Nhapxuatkho())->getPrintContent_chitiettranguoiban($time,$name,$table)])]
        );
    }
    public function actionInchitiettranguoimua(){
        if (isset($_POST['start'])&&isset($_POST['end']))
        {
            if (date('m',strtotime($_POST['start'])) == date('m',strtotime($_POST['end']))&&date('Y',strtotime($_POST['start'])) == date('Y',strtotime($_POST['end'])))
                $time = 'Tháng '.date('m',strtotime($_POST['start'])).' năm '.date('Y',strtotime($_POST['start']));
            else
                $time = 'Từ ngày '.date('d/m/Y',strtotime($_POST['start'])).' đến ngày '.date('d/m/Y',strtotime($_POST['end']));
        }
        if (isset($_POST['name'])&&$_POST['name']!='')
            $name = $_POST['name'];
        else
            $name = '';
        if (isset($_POST['table'])&&$_POST['table']!='')
            $table = $_POST['table'];
        else
            $table = '';
        echo Json::encode(
            ['noiDungIn' => $this->renderAjax('_phieuxuatkho', ['noidungin' => (new Nhapxuatkho())->getPrintContent_chitiettranguoimua($time,$name,$table)])]
        );
    }
    public function actionChitietthuchi(){
        if(isset($_POST['idhtmlphieu'])){
            $idphieu = explode('-',$_POST['idhtmlphieu'])[1];
            $thuchi = Thuchi::findOne($idphieu);
            $thuchi->ngaylap = date('d/m/Y',strtotime($thuchi->ngaylap));
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_chitietphieuthuchi',['thuchi'=>$thuchi]);
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
    public function actionSuaphieuthuchi(){
        if (isset($_POST['maphieu'])){

            $thuchi = Thuchi::findOne($_POST['maphieu']);
            if($thuchi->nhapxuatkho_id != null) {
                $thuchi->sotientra = intval(str_replace('.', '', $_POST['Thuchi']['sotientra']));
                $thuchi->ngaylap = (!isset($_POST['Thuchi']['ngaylap'])) ? date('d/m/Y', strtotime($thuchi->ngaylap)) : $_POST['Thuchi']['ngaylap'];
                $thuchi->ghichu = $_POST['Thuchi']['ghichu'];
                $tongtiendatra = 0;
            }else
            {
                $sotientracu = $thuchi->sotientra;
                $chenhlech = intval(str_replace('.', '', $_POST['Thuchi']['sotientra'])) - $sotientracu;
                $thuchi->sotientra = intval(str_replace('.', '', $_POST['Thuchi']['sotientra']));
                $thuchi->ngaylap = (!isset($_POST['Thuchi']['ngaylap'])) ? date('d/m/Y', strtotime($thuchi->ngaylap)) : $_POST['Thuchi']['ngaylap'];
                $thuchi->ghichu = $_POST['Thuchi']['ghichu'];
                $tongtiendatra = 0;
                $thuchi->tienhoadon = $thuchi->tienhoadon + $chenhlech;
            }
            if($thuchi->save()){
                $datras = Thuchi::find()->where(['nhapxuatkho_id'=>$thuchi->nhapxuatkho_id])->all();
                foreach ($datras as $datra){
                    $tongtiendatra += $datra->sotientra;
                }
                if ($thuchi->nhapxuatkho_id != NULL)
                {
                    $nhapxuatkho = Nhapxuatkho::findOne($thuchi->nhapxuatkho_id);
                    $nhapxuatkho->ngaygiaodich = date('d/m/Y',strtotime($nhapxuatkho->ngaygiaodich));
                    $nhapxuatkho->datra = $tongtiendatra;
                    $nhapxuatkho->save();
                    echo Json::encode(['error' => false, 'message' => myFuncs::getMessage('Thông báo','success',"Đã sửa phiếu!"),'ncc'=>$thuchi->nhacungcap_khachhang_id,'datra'=>number_format($nhapxuatkho->datra,0,'','.'),'thanhtien'=>number_format($nhapxuatkho->thanhtien,0,'','.'),'conno'=>number_format(intval($nhapxuatkho->thanhtien) - intval($nhapxuatkho->datra),0,'','.')]);

                }
                else {
                    echo Json::encode(['error' => false, 'message' => myFuncs::getMessage('Thông báo', 'success', "Đã sửa phiếu!"), 'ncc' => $thuchi->nhacungcap_khachhang_id]);
                }
            }
            else
            {
                echo Json::encode(['error' => true, 'class' => 'thuchi', 'errors' => $thuchi->getErrors(), 'message' => '']);
            }
        }
    }
    public function actionXoaphieuthuchi(){
        if(isset($_POST['idhtmlphieu'])) {
            $thuchi = Thuchi::find()->where(['maphieu' => $_POST['idhtmlphieu']])->one();
            if ($thuchi->nhapxuatkho_id != null || ($thuchi->nhapxuatkho_id == null && $thuchi->sotientra == $thuchi->tienhoadon)) {
                if ($thuchi->delete()) {
                    $datras = Thuchi::find()->where(['nhapxuatkho_id' => $thuchi->nhapxuatkho_id])->all();
                    $tongtiendatra = 0;
                    foreach ($datras as $datra) {
                        $tongtiendatra += $datra->sotientra;
                    }
                    if ($thuchi->nhapxuatkho_id != NULL) {
                        $nhapxuatkho = new Nhapxuatkho();
                        $nhapxuatkho = Nhapxuatkho::findOne($thuchi->nhapxuatkho_id);
                        $nhapxuatkho->ngaygiaodich = date('d/m/Y', strtotime($nhapxuatkho->ngaygiaodich));
                        $nhapxuatkho->datra = $tongtiendatra;
                        if ($tongtiendatra == 0)
                            $nhapxuatkho->phuongthuc = 'congno';
                        $nhapxuatkho->save();
                    }
                    echo Json::encode(['error' => false, 'message' => myFuncs::getMessage('Thông báo', 'success', "Đã xóa!"),'datra'=>($thuchi->nhapxuatkho_id != NULL)?number_format($nhapxuatkho->datra,0,'','.'):0,'conno'=>($thuchi->nhapxuatkho_id != NULL)?number_format($nhapxuatkho->thanhtien - $nhapxuatkho->datra,0,'','.'):0,'thanhtien'=>($thuchi->nhapxuatkho_id != NULL)?number_format($nhapxuatkho->thanhtien,0,'','.'):0, 'ncc' => $thuchi->nhacungcap_khachhang_id]);
                } else {
                    echo Json::encode(['error' => true, 'class' => 'thuchi', 'errors' => $thuchi->getErrors(), 'message' => '']);
                }
            }
            else{
                echo Json::encode(['error' => true, 'message' => myFuncs::getMessage('Thông báo', 'danger', "Phiếu này đã dược chi trả, không xóa được phiếu này!")]);
            }
        }
    }
    public function actionInbangkephieunhap(){
        if (isset($_POST['start'])&&isset($_POST['end']))
        {
            if (date('m',strtotime($_POST['start'])) == date('m',strtotime($_POST['end']))&&date('Y',strtotime($_POST['start'])) == date('Y',strtotime($_POST['end'])))
                $time = 'Tháng '.date('m',strtotime($_POST['start'])).' năm '.date('Y',strtotime($_POST['start']));
            else
                $time = 'Từ ngày '.date('d/m/Y',strtotime($_POST['start'])).' đến ngày '.date('d/m/Y',strtotime($_POST['end']));
        }
        if (isset($_POST['table'])&&$_POST['table']!='')
            $table = $_POST['table'];
        else
            $table = '';
        echo Json::encode(
            ['noiDungIn' => $this->renderAjax('_phieuxuatkho', ['noidungin' => (new Nhapxuatkho())->getPrintContent_bangkephieunhap($time,$table)])]
        );
    }

    public function actionTonghopcongnonhacungcap(){
        $nhacungcapkhachhang = new Nhacungcapkhachhang();
        return $this->render('tonghoptranguoiban', [
            'nhacungcapkhachhang' => $nhacungcapkhachhang,
        ]);
    }
    public function actionTonghopcongnokhachhang(){
        $nhacungcapkhachhang = new Nhacungcapkhachhang();
        return $this->render('tonghopcongnokhachhang', [
            'nhacungcapkhachhang' => $nhacungcapkhachhang,
        ]);
    }
    public function actionTonghopchitietcongno(){
        if(isset($_POST['Nhacungcapkhachhang']))
        {
            $mangloc = [];$khachhangfilter = '';
            if(isset($_POST['Nhacungcapkhachhang']['name']) && $_POST['Nhacungcapkhachhang']['name'] != '')
            {
                $mangloc['nhacungcap_khachhang_id'] = $_POST['Nhacungcapkhachhang']['name'];
                $khachhangfilter = Nhacungcapkhachhang::findOne($_POST['Nhacungcapkhachhang']['name']);
            }
            if (isset($_POST['start'])&&$_POST['start'] != '')
                $start = date('Y-m-d',strtotime(str_replace('/','-',$_POST['start'])));
            if (isset($_POST['end'])&&$_POST['end'] != '')
                $end = date('Y-m-d',strtotime(str_replace('/','-',$_POST['end'])));
            $mangloc['type'] = $_POST['type'];
            $ncckh = ($_POST['type'] == 'nhapkho')?'nhà cung cấp':'khách hàng';
            $kieu = $_POST['type'] == 'nhapkho'?'nhacungcap':'khachhang';
            if($_POST['Nhacungcapkhachhang']['name'] != ''){
                $tongnodaukys = \Yii::$app->getDb()->createCommand("select ngaygiaodich,ma,name,nhacungcap_khachhang_id,kieu,sum((case type when 'nhapkho' then thanhtien when 'xuatkho' then thanhtien when 'nodauky' then thanhtien when 'thuthue' then thanhtien end)) AS thanhtien,sum((case type when 'tralai' then thanhtien else 0 end)) AS tralai,sum(datra) as datra
                                                                    from vk_chitiethoadoncongno
                                                                    where kieu = '".$kieu."' and date(ngaygiaodich) < date('".$start."') and nhacungcap_khachhang_id = '".$_POST['Nhacungcapkhachhang']['name']."'
                                                                    group by nhacungcap_khachhang_id")->queryAll();
                $tongnogiuakys = \Yii::$app->getDb()->createCommand("select ngaygiaodich,ma,name,nhacungcap_khachhang_id,kieu,sum((case type when 'nhapkho' then thanhtien when 'xuatkho' then thanhtien when 'nodauky' then thanhtien when 'thuthue' then thanhtien end)) AS thanhtien,sum((case type when 'tralai' then thanhtien else 0 end)) AS tralai,sum(datra) as datra
                                                                    from vk_chitiethoadoncongno
                                                                    where kieu = '".$kieu."' and date(ngaygiaodich) between date('".$start."') and date('".$end."') and nhacungcap_khachhang_id = '".$_POST['Nhacungcapkhachhang']['name']."'
                                                                    group by nhacungcap_khachhang_id")->queryAll();
                $tradaukys = \Yii::$app->getDb()->createCommand("select COALESCE(sum(tienhoadon),0) as tientratruoc,nhacungcap_khachhang_id from vk_thuchi where date(ngaylap) < date('".$start."') and tienhoadon > 0 and nhacungcap_khachhang_id = '".$_POST['Nhacungcapkhachhang']['name']."'")->queryAll();
                $tragiuakys = \Yii::$app->getDb()->createCommand("select COALESCE(sum(tienhoadon),0) as tientratruoc,nhacungcap_khachhang_id from vk_thuchi where date(ngaylap) between date('".$start."') and date('".$end."') and nhacungcap_khachhang_id = '".$_POST['Nhacungcapkhachhang']['name']."'")->queryAll();

                foreach ($tongnodaukys as $index=>$tongnodauky){
                    foreach ($tradaukys as $tradauky){
                        if($tongnodauky['nhacungcap_khachhang_id'] == $tradauky['nhacungcap_khachhang_id']){
                            $tongnodaukys[$index]['datra'] = intval($tongnodauky['datra']) + intval($tradauky['tientratruoc']);

                        }
                    }
                }
                foreach ($tongnogiuakys as $asd=>$tongnogiuaky){
                    foreach ($tragiuakys as $tragiuaky){
                            $tongnogiuakys[$asd]['datra'] = intval($tongnogiuaky['datra']) + intval($tragiuaky['tientratruoc']);

                    }
                }

                foreach ($tongnogiuakys as $tongnogiuaky1){
                    $i = 0;
                    foreach ($tongnodaukys as $tongnodauky1){
                        if($tongnodauky1['nhacungcap_khachhang_id'] == $tongnogiuaky1['nhacungcap_khachhang_id']){
                            $i++;
                        }
                    }
                    if($i == 0){
                        $tongnogiuaky1['thanhtien'] = 0;
                        $tongnogiuaky1['datra'] = 0;
                        array_push($tongnodaukys,$tongnogiuaky1);
                    }
                }
                $nodauky = 0;
                $codauky = 0;
                $nophatsinh = 0;
                $cophatsinh = 0;
                foreach ($tongnodaukys as $tongnodauky2){
                    $nodauky += $tongnodauky2['datra'];
                    $codauky += $tongnodauky2['thanhtien'];
                }

                foreach ($tongnogiuakys as $tongnogiuaky2){
                    $nophatsinh += $tongnogiuaky2['datra'];
                    $cophatsinh += $tongnogiuaky2['thanhtien'];
                }
            }
            else{
                $tongnodaukys = \Yii::$app->getDb()->createCommand("select ngaygiaodich,ma,name,nhacungcap_khachhang_id,kieu,sum((case type when 'nhapkho' then thanhtien when 'xuatkho' then thanhtien when 'nodauky' then thanhtien when 'thuthue' then thanhtien end)) AS thanhtien,sum((case type when 'tralai' then thanhtien else 0 end)) AS tralai,sum(datra) as datra
                                                                    from vk_chitiethoadoncongno
                                                                    where kieu = '".$kieu."' and date(ngaygiaodich) < date('".$start."')
                                                                    group by nhacungcap_khachhang_id")->queryAll();
                $tongnogiuakys = \Yii::$app->getDb()->createCommand("select ngaygiaodich,ma,name,nhacungcap_khachhang_id,kieu,sum((case type when 'nhapkho' then thanhtien when 'xuatkho' then thanhtien when 'nodauky' then thanhtien when 'thuthue' then thanhtien end)) AS thanhtien,sum((case type when 'tralai' then thanhtien else 0 end)) AS tralai,sum(datra) as datra
                                                                    from vk_chitiethoadoncongno
                                                                    where kieu = '".$kieu."' and date(ngaygiaodich) between date('".$start."') and date('".$end."')
                                                                    group by nhacungcap_khachhang_id")->queryAll();
                $tradaukys = \Yii::$app->getDb()->createCommand("select COALESCE(sum(tienhoadon),0) as tientratruoc,nhacungcap_khachhang_id from vk_thuchi where date(ngaylap) < date('".$start."') and tienhoadon > 0 group by nhacungcap_khachhang_id ")->queryAll();
                $tragiuakys = \Yii::$app->getDb()->createCommand("select COALESCE(sum(tienhoadon),0) as tientratruoc,nhacungcap_khachhang_id from vk_thuchi where date(ngaylap) between date('".$start."') and date('".$end."') group by nhacungcap_khachhang_id ")->queryAll();
                foreach ($tongnodaukys as $ind => $tongnodauky){
                    foreach ($tradaukys as $tradauky){
                        if($tongnodauky['nhacungcap_khachhang_id'] == $tradauky['nhacungcap_khachhang_id']){
                            $tongnodaukys[$ind]['datra'] = ($tongnodauky['datra']) + ($tradauky['tientratruoc']);
                        }
                    }
                }
                foreach ($tongnogiuakys as $indd => $tongnogiuaky){
                    foreach ($tragiuakys as $tragiuaky){
                        if($tongnogiuaky['nhacungcap_khachhang_id'] == $tragiuaky['nhacungcap_khachhang_id']){
                            $tongnogiuakys[$indd]['datra'] = $tongnogiuaky['datra'] + $tragiuaky['tientratruoc'];
                        }
                    }
                }
                foreach ($tongnogiuakys as $indexx => $tongnogiuaky1){
                    $i = 0;
                    foreach ($tongnodaukys as $tongnodauky1){
                        if($tongnodauky1['nhacungcap_khachhang_id'] == $tongnogiuaky1['nhacungcap_khachhang_id']){
                            $i++;
                        }
                    }
                    if($i == 0){
                        $tongnogiuaky1['thanhtien'] = 0;
                        $tongnogiuaky1['datra'] = 0;
                        array_push($tongnodaukys,$tongnogiuaky1);
                    }
                }
                $nodauky = 0;
                $codauky = 0;
                $nophatsinh = 0;
                $cophatsinh = 0;
                foreach ($tongnodaukys as $tongnodauky2){
                    $nodauky += $tongnodauky2['datra'];
                    $codauky += $tongnodauky2['thanhtien'];
                }
                foreach ($tongnogiuakys as $tongnogiuaky2){
                    $nophatsinh += $tongnogiuaky2['datra'];
                    $cophatsinh += $tongnogiuaky2['thanhtien'];
                }
            }

            \Yii::$app->response->format = Response::FORMAT_JSON;
            return $this->renderAjax('_tonghopcongnonhacungcap',['tongnodaukys'=>$tongnodaukys,'tongnogiuakys'=>$tongnogiuakys,'nodauky'=>$nodauky,'codauky'=>$codauky,'nophatsinh'=>$nophatsinh,'cophatsinh'=>$cophatsinh,'tungay'=>$start,'denngay'=>$end,'khachhangfilter'=>$khachhangfilter,'type'=>$ncckh]);
        }

    }
    public function actionIntonghopcongno(){
        if (isset($_POST['start'])&&isset($_POST['end']))
        {
            if (date('m',strtotime($_POST['start'])) == date('m',strtotime($_POST['end']))&&date('Y',strtotime($_POST['start'])) == date('Y',strtotime($_POST['end'])))
                $time = 'Tháng '.date('m',strtotime($_POST['start'])).' năm '.date('Y',strtotime($_POST['start']));
            else
                $time = 'Từ ngày '.$_POST['start'].' đến ngày '.$_POST['end'];
        }else $time = '';
        if (isset($_POST['name'])&&$_POST['name']!='')
            $name = $_POST['name'];
        else
            $name = '';
        if (isset($_POST['table'])&&$_POST['table']!='')
            $table = $_POST['table'];
        else
            $table = '';
        if (isset($name)&&$name!='')
        {
             $name = Nhacungcapkhachhang::findOne($name);
            $ten = $name->name;
        }
        else
            $ten = '';
        echo Json::encode(
            ['noiDungIn' => $this->renderAjax('_inngang', ['noidungin' => (new Nhapxuatkho())->getPrintContent_tonghopcongno($time,$ten,$table,$_POST['type'])])]
        );
    }

    public function actionThongkexacnhan(){
        $nhapxuatkhos = Nhapxuatkho::find()->where("phuongthuc = 'dathanhtoan' and datra = 0")->all();
        return $this->render('thongkexacnhan',['nhapxuatkhos'=>$nhapxuatkhos]);
    }
    public function actionHuyxacnhan(){
        if(isset($_POST['idphieu'])){
            $nhapxuatkho = Nhapxuatkho::findOne(['id'=>$_POST['idphieu']]);
            $nhapxuatkho->ngaygiaodich = date("d/m/Y",strtotime($nhapxuatkho->ngaygiaodich));
            $nhapxuatkho->phuongthuc = 'congno';
            $nhapxuatkho->save();
            $thuchis = Thuchi::find()->where("tienhoadon < sotientra and nhapxuatkho_id is NULL")->andWhere(['nhacungcap_khachhang_id'=>$nhapxuatkho->nhacungcap_khachhang_id])->orderBy(['id'=>SORT_DESC])->all();
            $tienhoadon = $nhapxuatkho->thanhtien;
            foreach ($thuchis as $thuchi){

                if($thuchi->sotientra - $thuchi->tienhoadon > $tienhoadon){
                    $thuchi->tienhoadon = $thuchi->tienhoadon + $tienhoadon;
                    $thuchi->ngaylap = date("d/m/Y",strtotime($thuchi->ngaylap));
                    $thuchi->save();
                    break;
                }
                else{
                    $tienhoadon = $tienhoadon - $thuchi->sotientra - $thuchi->tienhoadon;
                    $thuchi->tienhoadon = $thuchi->sotientra;
                    $thuchi->ngaylap = date("d/m/Y",strtotime($thuchi->ngaylap));
                    $thuchi->save();
                }
            }
            $nhapxuatkhos = Nhapxuatkho::find()->where("phuongthuc = 'dathanhtoan' and datra = 0")->all();
            $table = "<table class=\"table table-striped table-bordered table-hover\" id=\"sample_1\">
                            <thead>
                            <th>Mã phiếu </th>
                            <th>Tên </th>
                            <th>Ngày tạo </th>
                            <th>Thành tiền </th>
                            <th>Trạng thái </th>
                            <th>Chức năng </th>
                            </thead>
                            <tbody>";
            $tr = "";

            foreach ($nhapxuatkhos as $danhsachthue){
                $danhsachthue->phuongthuc == 'congno'?$congno = "Chưa thanh toán":$congno = "Đã xác nhận";
                $danhsachthue->thanhtien = number_format($danhsachthue->thanhtien,0,'','.');
                $tr .= "<tr><td>{$danhsachthue->maphieu}</td>
                            <td> {$danhsachthue->nhacungcapkhachhang->name} </td>
                            <td> {$danhsachthue->ngaygiaodich} </td>
                            <td style='text-align: right'>{$danhsachthue->thanhtien}</td>
                            <td>
                                {$congno}
                            </td>
                            <td style='text-align: center'>
                                <a href='index.php?r=nhapxuathang/huyxacnhan' class = 'btn-danger fa fa-trash-o btn-del' id = '{$danhsachthue->id}' ></a>
                            </td></tr>";
            }
            $table = $table.$tr."</tbody></table>";
            echo Json::encode(['message'=>myFuncs::getMessage('Thông báo','success','Đã xóa xong!'),'table'=>$table]);
        }
    }
}