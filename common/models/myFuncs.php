<?php
/**
 * Created by PhpStorm.
 * User: HungLuongHien
 * Date: 6/2/2016
 * Time: 1:51 AM
 */

namespace common\models;

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use yii\web\UploadedFile;

class myFuncs

{
    public static function createCode($str){
        $coDau=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ"
        ,"ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ","ì","í","ị","ỉ","ĩ",
            "ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
        ,"ờ","ớ","ợ","ở","ỡ",
            "ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
            "ỳ","ý","ỵ","ỷ","ỹ",
            "đ",
            "À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
        ,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
            "È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
            "Ì","Í","Ị","Ỉ","Ĩ",
            "Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
        ,"Ờ","Ớ","Ợ","Ở","Ỡ",
            "Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
            "Ỳ","Ý","Ỵ","Ỷ","Ỹ",
            "Đ","ê","ù","à");
        $khongDau=array("a","a","a","a","a","a","a","a","a","a","a"
        ,"a","a","a","a","a","a",
            "e","e","e","e","e","e","e","e","e","e","e",
            "i","i","i","i","i",
            "o","o","o","o","o","o","o","o","o","o","o","o"
        ,"o","o","o","o","o",
            "u","u","u","u","u","u","u","u","u","u","u",
            "y","y","y","y","y",
            "d",
            "A","A","A","A","A","A","A","A","A","A","A","A"
        ,"A","A","A","A","A",
            "E","E","E","E","E","E","E","E","E","E","E",
            "I","I","I","I","I",
            "O","O","O","O","O","O","O","O","O","O","O","O"
        ,"O","O","O","O","O",
            "U","U","U","U","U","U","U","U","U","U","U",
            "Y","Y","Y","Y","Y",
            "D","e","u","a");
        $str = str_replace($coDau,$khongDau,$str);
        $str = trim(preg_replace("/\\s+/", " ", $str));
        $str = preg_replace("/[^a-zA-Z0-9 \-\.]/", "", $str);
        $str = strtolower($str);
        return str_replace(" ", '-', $str);;
    }
    //source: D/m/y
    //Convert to: y-m-d
    public static function convertDateSaveIntoDb($date, $splash = '/'){
        if($date == "")
            return null;
        $arr = explode(trim($splash), $date);
        return "{$arr[2]}-{$arr[1]}-{$arr[0]}";
    }

    public static function getIdOtherModel($value, $model, $attributeTitle = 'name', $attributeType = ['name' => '', 'value' => '']){
        if($value=="")
            return null;

        $data = $model->find()->where("code = :name", [':name' => self::createCode(trim($value))])->one();

        if(count($data) == 0){
            $model->{$attributeTitle} = trim($value);
            if($attributeType['name'] != '')
                $model->{$attributeType['name']} = trim($attributeType['value']);

            $model->save();
            return $model->id;
        }
        return $data->id;
    }

    public static function getNameFromIdOfModel($model, $field, $relation){
        $str = "";
        if($model->{$field}!=""){
            $str .= $model->{$relation}->name;
            if(isset($model->{$relation}->code)){
                if($model->{$relation}->code!="")
                    $str .= " - {$model->{$relation}->code}";
            }

        }
        return $str;
    }

    public static function getMessage($title, $class="success|danger|warning", $noidung){
        return "<div class='note note-{$class}'><h4 class='block'>{$title} </h4><p>{$noidung}</p></div>";
    }

    /**
     * @param $form ActiveForm
     * @param $model ActiveRecord
     * @param $field string
     * @param $label string
     * @return string
     */
    public static function activeDateField($form, $model, $field, $label,$option = ['class' => 'form-control']){
        return $form->field($model,$field)->widget(\yii\jui\DatePicker::className(),[
            'language' => 'vi',
            'clientOptions' => [
                'dateFormat' => 'dd/mm/yy',
                'changeMonth' => true,
                'yearRange' => '1996:2099',
                'changeYear' => true,
            ],
            'options' => $option
        ])->label($label);
    }

    public static function VndText($amount)
    {
        if($amount <=0)
        {
            return $textnumber="Tiền phải là số nguyên dương lớn hơn số 0";
        }
        $Text=array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
        $TextLuythua =array("","nghìn", "triệu", "tỷ", "ngàn tỷ", "triệu tỷ", "tỷ tỷ");
        $textnumber = "";
        $length = strlen($amount);

        for ($i = 0; $i < $length; $i++)
            $unread[$i] = 0;

        for ($i = 0; $i < $length; $i++)
        {
            $so = substr($amount, $length - $i -1 , 1);

            if ( ($so == 0) && ($i % 3 == 0) && ($unread[$i] == 0)){
                for ($j = $i+1 ; $j < $length ; $j ++)
                {
                    $so1 = substr($amount,$length - $j -1, 1);
                    if ($so1 != 0)
                        break;
                }

                if (intval(($j - $i )/3) > 0){
                    for ($k = $i ; $k <intval(($j-$i)/3)*3 + $i; $k++)
                        $unread[$k] =1;
                }
            }
        }

        for ($i = 0; $i < $length; $i++)
        {
            $so = substr($amount,$length - $i -1, 1);
            if ($unread[$i] ==1)
                continue;

            if ( ($i% 3 == 0) && ($i > 0))
                $textnumber = $TextLuythua[$i/3] ." ". $textnumber;

            if ($i % 3 == 2 )
                $textnumber = 'trăm ' . $textnumber;

            if ($i % 3 == 1)
                $textnumber = 'mươi ' . $textnumber;


            $textnumber = $Text[$so] ." ". $textnumber;
        }

        //Phai de cac ham replace theo dung thu tu nhu the nay
        $textnumber = str_replace("không mươi", "lẻ", $textnumber);
        $textnumber = str_replace("lẻ không", "", $textnumber);
        $textnumber = str_replace("mươi không", "mươi", $textnumber);
        $textnumber = str_replace("một mươi", "mười", $textnumber);
        $textnumber = str_replace("mươi năm", "mươi lăm", $textnumber);
        $textnumber = str_replace("mươi một", "mươi mốt", $textnumber);
        $textnumber = str_replace("mười năm", "mười lăm", $textnumber);

        return ucfirst($textnumber." đồng chẵn");
    }

}