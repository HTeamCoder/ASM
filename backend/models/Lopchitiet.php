<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%lopchitiet}}".
 *
 * @property integer $id
 * @property integer $khoa_id
 * @property integer $lop_id
 *
 * @property Hocvien[] $hocviens
 * @property Khoa $khoa
 * @property Lop $lop
 */
class Lopchitiet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lopchitiet}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['khoa_id', 'lop_id'], 'required'],
            [['khoa_id', 'lop_id'], 'integer'],
            [['khoa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Khoa::className(), 'targetAttribute' => ['khoa_id' => 'id']],
            [['lop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lop::className(), 'targetAttribute' => ['lop_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'khoa_id' => Yii::t('app', 'Khóa học'),
            'lop_id' => Yii::t('app', 'Lop ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHocviens()
    {
        return $this->hasMany(Hocvien::className(), ['lop_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKhoa()
    {
        return $this->hasOne(Khoa::className(), ['id' => 'khoa_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLop()
    {
        return $this->hasOne(Lop::className(), ['id' => 'lop_id']);
    }
}
