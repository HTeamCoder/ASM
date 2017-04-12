<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%xinghiep}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $tengiamdoc
 * @property string $diachi
 *
 * @property Donhang[] $donhangs
 */
class Xinghiep extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%xinghiep}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'tengiamdoc', 'diachi'], 'required'],
            [['diachi'], 'string'],
            [['name', 'code', 'tengiamdoc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Tên xí nghiệp'),
            'code' => Yii::t('app', 'code'),
            'tengiamdoc' => Yii::t('app', 'Giám đốc'),
            'diachi' => Yii::t('app', 'Địa chỉ '),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonhangs()
    {
        return $this->hasMany(Donhang::className(), ['xinghiep_id' => 'id']);
    }
}
