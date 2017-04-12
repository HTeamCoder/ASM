<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%baihoc}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property Chitietdanhgia[] $chitietdanhgias
 */
class Baihoc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%baihoc}}';
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
            'name' => Yii::t('app', 'Tên bài học'),
            'code' => Yii::t('app', 'Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChitietdanhgias()
    {
        return $this->hasMany(Chitietdanhgia::className(), ['baihoc_id' => 'id']);
    }
}
