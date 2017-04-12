<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%congtacvien}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property Hocvien[] $hocviens
 */
class Congtacvien extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%congtacvien}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['name', 'code'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Tên cộng tác viên'),
            'code' => Yii::t('app', 'Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHocviens()
    {
        return $this->hasMany(Hocvien::className(), ['congtacvien_id' => 'id']);
    }
}