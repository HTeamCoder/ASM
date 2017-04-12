<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%loaidanhsach}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * @property Hocvien[] $hocviens
 */
class Loaidanhsach extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%loaidanhsach}}';
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
            'name' => Yii::t('app', 'Loại danh sách'),
            'code' => Yii::t('app', 'Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHocviens()
    {
        return $this->hasMany(Hocvien::className(), ['loaidanhsach_id' => 'id']);
    }
}
