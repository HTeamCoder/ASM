<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%noidaotaosautrungtuyen}}".
 *
 * @property string $id
 * @property string $name
 * @property string $code
 *
 * @property Donhang[] $donhangs
 */
class Noidaotaosautrungtuyen extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%noidaotaosautrungtuyen}}';
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
            'name' => Yii::t('app', 'Nơi đào tạo sau trúng tuyển'),
            'code' => Yii::t('app', 'Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonhangs()
    {
        return $this->hasMany(Donhang::className(), ['noidaotaosautrungtuyen_id' => 'id']);
    }
}
