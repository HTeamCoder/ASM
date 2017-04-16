<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%donhangchitiet}}".
 *
 * @property integer $id
 * @property string $ghichu
 * @property integer $hocvien_id
 * @property integer $donhang_id
 *
 * @property Hocvien $hocvien
 * @property Donhang $donhang
 * @property Xuatcanh[] $xuatcanhs
 */
class Donhangchitiet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%donhangchitiet}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ghichu'], 'string'],
            [['hocvien_id', 'donhang_id'], 'safe'],
            // [['hocvien_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hocvien::className(), 'targetAttribute' => ['hocvien_id' => 'id']],
            // [['donhang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Donhang::className(), 'targetAttribute' => ['donhang_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ghichu' => Yii::t('app', 'Ghi chú'),
            'hocvien_id' => Yii::t('app', 'Hocvien ID'),
            'donhang_id' => Yii::t('app', 'Donhang ID'),
        ];
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
    public function getDonhang()
    {
        return $this->hasOne(Donhang::className(), ['id' => 'donhang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getXuatcanhs()
    {
        return $this->hasMany(Xuatcanh::className(), ['donhangchitiet_id' => 'id']);
    }
}
