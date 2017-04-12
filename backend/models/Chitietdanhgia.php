<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%chitietdanhgia}}".
 *
 * @property integer $id
 * @property integer $baihoc_id
 * @property integer $hocvien_id
 * @property string $thoigian
 * @property integer $asv_danhgiaquatrinhhoc_id
 *
 * @property Baihoc $baihoc
 * @property Hocvien $hocvien
 * @property Danhgiaquatrinhhoc $asvDanhgiaquatrinhhoc
 */
class Chitietdanhgia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%chitietdanhgia}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['baihoc_id', 'hocvien_id', 'thoigian', 'asv_danhgiaquatrinhhoc_id'], 'required'],
            [['baihoc_id', 'hocvien_id', 'asv_danhgiaquatrinhhoc_id'], 'integer'],
            [['thoigian'], 'safe'],
            [['baihoc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Baihoc::className(), 'targetAttribute' => ['baihoc_id' => 'id']],
            [['hocvien_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hocvien::className(), 'targetAttribute' => ['hocvien_id' => 'id']],
            [['asv_danhgiaquatrinhhoc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Danhgiaquatrinhhoc::className(), 'targetAttribute' => ['asv_danhgiaquatrinhhoc_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'baihoc_id' => Yii::t('app', 'Baihoc ID'),
            'hocvien_id' => Yii::t('app', 'Hocvien ID'),
            'thoigian' => Yii::t('app', 'Thoigian'),
            'asv_danhgiaquatrinhhoc_id' => Yii::t('app', 'Asv Danhgiaquatrinhhoc ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaihoc()
    {
        return $this->hasOne(Baihoc::className(), ['id' => 'baihoc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHocvien()
    {
        return $this->hasOne(Hocvien::className(), ['id' => 'hocvien_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsvDanhgiaquatrinhhoc()
    {
        return $this->hasOne(Danhgiaquatrinhhoc::className(), ['id' => 'asv_danhgiaquatrinhhoc_id']);
    }
}
