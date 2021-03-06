<?php

namespace backend\models;


use Yii;
use common\models\myFuncs;
/**
 * This is the model class for table "asv_chuyennganh".
 *
 * @property integer $id
 * @property string $tenchuyennganh
 * @property string $code
 *
 * @property Hocvien[] $hocviens
 */
class Chuyennganh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asv_chuyennganh';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tenchuyennganh'], 'required'],
            [['tenchuyennganh', 'code'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tenchuyennganh' => 'Tên chuyên ngành',
            'code' => 'Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHocviens()
    {
        return $this->hasMany(Hocvien::className(), ['chuyennganh_id' => 'id']);
    }
    public function beforeSave($insert)
    {
        $this->code = myFuncs::createCode($this->tenchuyennganh);
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}
