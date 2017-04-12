<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%khoa}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $ngaybatdau
 * @property string $ngayketthuc
 *
 * @property Lop[] $lops
 */
class Khoa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%khoa}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'ngaybatdau'], 'required'],
            [['ngaybatdau', 'ngayketthuc'], 'safe'],
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
            'name' => Yii::t('app', 'Tên khóa học'),
            'code' => Yii::t('app', 'code'),
            'ngaybatdau' => Yii::t('app', 'Ngày bắt đầu'),
            'ngayketthuc' => Yii::t('app', 'Ngày kết thúc'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLops()
    {
        return $this->hasMany(Lop::className(), ['khoa_id' => 'id']);
    }
}
