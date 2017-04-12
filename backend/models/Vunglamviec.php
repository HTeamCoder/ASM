<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%vunglamviec}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property Donhang[] $donhangs
 */
class Vunglamviec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vunglamviec}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
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
            'name' => Yii::t('app', 'Vùng làm việc'),
            'code' => Yii::t('app', 'Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonhangs()
    {
        return $this->hasMany(Donhang::className(), ['vunglamviec_id' => 'id']);
    }
}
