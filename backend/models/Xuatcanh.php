<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%xuatcanh}}".
 *
 * @property integer $id
 * @property string $dukienxuatcanh
 * @property string $ngayxuatcanh
 * @property string $ghichu
 * @property string $lichbay
 * @property integer $donhangchitiet_id
 *
 * @property Donhangchitiet $donhangchitiet
 */
class Xuatcanh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%xuatcanh}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dukienxuatcanh', 'ngayxuatcanh', 'donhangchitiet_id'], 'required'],
            [['dukienxuatcanh', 'ngayxuatcanh'], 'safe'],
            [['ghichu'], 'string'],
            [['donhangchitiet_id'], 'integer'],
            [['lichbay'], 'string', 'max' => 255],
            [['donhangchitiet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Donhangchitiet::className(), 'targetAttribute' => ['donhangchitiet_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'dukienxuatcanh' => Yii::t('app', 'Dự kiến xuất cảnh'),
            'ngayxuatcanh' => Yii::t('app', 'Ngày xuất cảnh'),
            'ghichu' => Yii::t('app', 'Ghi chú'),
            'lichbay' => Yii::t('app', 'Lichbay'),
            'donhangchitiet_id' => Yii::t('app', 'Donhangchitiet ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonhangchitiet()
    {
        return $this->hasOne(Donhangchitiet::className(), ['id' => 'donhangchitiet_id']);
    }
}
