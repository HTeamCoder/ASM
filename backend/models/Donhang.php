<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%donhang}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $thoigiantaptrung
 * @property string $ngaythi
 * @property string $diachilienhe
 * @property string $noilamviec
 * @property string $ghichu
 * @property string $ngaydo
 * @property integer $vunglamviec_id
 * @property integer $nghiepdoan_id
 * @property integer $xinghiep_id
 * @property string $noidaotaosautrungtuyen_id
 * @property integer $donvicungcapnguon_id
 *
 * @property Vunglamviec $vunglamviec
 * @property Nghiepdoan $nghiepdoan
 * @property Xinghiep $xinghiep
 * @property Noidaotaosautrungtuyen $noidaotaosautrungtuyen
 * @property Donvicungcapnguon $donvicungcapnguon
 * @property Donhangchitiet[] $donhangchitiets
 */
class Donhang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%donhang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'vunglamviec_id', 'nghiepdoan_id', 'xinghiep_id', 'noidaotaosautrungtuyen_id', 'donvicungcapnguon_id'], 'required'],
            [['thoigiantaptrung', 'ngaythi', 'ngaydo'], 'safe'],
            [['diachilienhe', 'ghichu'], 'string'],
            [['vunglamviec_id', 'nghiepdoan_id', 'xinghiep_id', 'noidaotaosautrungtuyen_id', 'donvicungcapnguon_id'], 'integer'],
            [['name', 'code', 'noilamviec'], 'string', 'max' => 255],
            [['vunglamviec_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vunglamviec::className(), 'targetAttribute' => ['vunglamviec_id' => 'id']],
            [['nghiepdoan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nghiepdoan::className(), 'targetAttribute' => ['nghiepdoan_id' => 'id']],
            [['xinghiep_id'], 'exist', 'skipOnError' => true, 'targetClass' => Xinghiep::className(), 'targetAttribute' => ['xinghiep_id' => 'id']],
            [['noidaotaosautrungtuyen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Noidaotaosautrungtuyen::className(), 'targetAttribute' => ['noidaotaosautrungtuyen_id' => 'id']],
            [['donvicungcapnguon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Donvicungcapnguon::className(), 'targetAttribute' => ['donvicungcapnguon_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Tên đơn hàng'),
            'code' => Yii::t('app', 'Code'),
            'thoigiantaptrung' => Yii::t('app', 'Thời gian tập trung'),
            'ngaythi' => Yii::t('app', 'Ngày thi'),
            'diachilienhe' => Yii::t('app', 'Địa chỉ liên hệ'),
            'noilamviec' => Yii::t('app', 'Nơi làm việc'),
            'ghichu' => Yii::t('app', 'Ghi chú'),
            'ngaydo' => Yii::t('app', 'Ngày tháng đỗ'),
            'vunglamviec_id' => Yii::t('app', 'Vùng làm việc'),
            'nghiepdoan_id' => Yii::t('app', 'Nghiệp đoàn'),
            'xinghiep_id' => Yii::t('app', 'Xí nghiệp'),
            'noidaotaosautrungtuyen_id' => Yii::t('app', 'Nơi đào tạo sau trúng tuyển'),
            'donvicungcapnguon_id' => Yii::t('app', 'Đơn vị cung cấp nguồn'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVunglamviec()
    {
        return $this->hasOne(Vunglamviec::className(), ['id' => 'vunglamviec_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNghiepdoan()
    {
        return $this->hasOne(Nghiepdoan::className(), ['id' => 'nghiepdoan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getXinghiep()
    {
        return $this->hasOne(Xinghiep::className(), ['id' => 'xinghiep_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoidaotaosautrungtuyen()
    {
        return $this->hasOne(Noidaotaosautrungtuyen::className(), ['id' => 'noidaotaosautrungtuyen_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonvicungcapnguon()
    {
        return $this->hasOne(Donvicungcapnguon::className(), ['id' => 'donvicungcapnguon_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonhangchitiets()
    {
        return $this->hasMany(Donhangchitiet::className(), ['donhang_id' => 'id']);
    }
}
