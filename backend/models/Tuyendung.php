<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tuyendung".
 *
 * @property integer $idhocvien
 * @property string $tenhocvien
 * @property string $mahocvien
 * @property string $anhdaidien
 * @property integer $idhoadon
 * @property string $tendonhang
 * @property string $ngaythi
 * @property string $ngaydo
 * @property string $ghichu
 */
class Tuyendung extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tuyendung';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idhocvien', 'idhoadon'], 'integer'],
            [['tenhocvien', 'mahocvien', 'tendonhang'], 'required'],
            [['ngaythi', 'ngaydo'], 'safe'],
            [['ghichu'], 'string'],
            [['tenhocvien'], 'string', 'max' => 100],
            [['mahocvien', 'anhdaidien', 'tendonhang'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idhocvien' => Yii::t('app', 'Idhocvien'),
            'tenhocvien' => Yii::t('app', 'Tên HV'),
            'mahocvien' => Yii::t('app', 'Mã HV'),
            'anhdaidien' => Yii::t('app', 'Ảnh học viên'),
            'idhoadon' => Yii::t('app', 'Idhoadon'),
            'tendonhang' => Yii::t('app', 'Tên đơn hàng'),
            'ngaythi' => Yii::t('app', 'Ngày thi'),
            'ngaydo' => Yii::t('app', 'Ngày tháng đỗ'),
            'ghichu' => Yii::t('app', 'Ghi chú'),
        ];
    }
}
