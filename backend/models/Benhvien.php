<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%benhvien}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property Hocvien[] $hocviens
 */
class Benhvien extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%benhvien}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'code'], 'required'],
            [['id'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Tên bệnh viện'),
            'code' => Yii::t('app', 'Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHocviens()
    {
        return $this->hasMany(Hocvien::className(), ['benhvien_id' => 'id']);
    }
}
