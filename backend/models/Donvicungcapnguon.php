<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%donvicungcapnguon}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property Donhang[] $donhangs
 */
class Donvicungcapnguon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%donvicungcapnguon}}';
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
            'name' => Yii::t('app', 'Tên đơn vị'),
            'code' => Yii::t('app', 'Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonhangs()
    {
        return $this->hasMany(Donhang::className(), ['donvicungcapnguon_id' => 'id']);
    }
}
