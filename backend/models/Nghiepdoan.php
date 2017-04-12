<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%nghiepdoan}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property Donhang[] $donhangs
 */
class Nghiepdoan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%nghiepdoan}}';
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
            'name' => Yii::t('app', 'Tên nghiệp đoàn'),
            'code' => Yii::t('app', 'code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonhangs()
    {
        return $this->hasMany(Donhang::className(), ['nghiepdoan_id' => 'id']);
    }
}
