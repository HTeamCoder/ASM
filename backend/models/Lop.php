<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%lop}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $khoa_id
 *
 * @property Hocvien[] $hocviens
 * @property Khoa $khoa
 */
class Lop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lop}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'code', 'khoa_id'], 'required'],
            [['id', 'khoa_id'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255],
            [['khoa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Khoa::className(), 'targetAttribute' => ['khoa_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Tên lớp'),
            'code' => Yii::t('app', 'Code'),
            'khoa_id' => Yii::t('app', 'Khóa học'),
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
}
