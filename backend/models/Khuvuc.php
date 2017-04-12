<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%khuvuc}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $parent_id
 * @property integer $child_id
 *
 * @property Hocvien[] $hocviens
 * @property Hocvien[] $hocviens0
 * @property Hocvien[] $hocviens1
 * @property Hocvien[] $hocviens2
 * @property Khuvuc $parent
 * @property Khuvuc[] $khuvucs
 * @property Khuvuc $child
 * @property Khuvuc[] $khuvucs0
 */
class Khuvuc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%khuvuc}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['parent_id', 'child_id'], 'integer'],
            [['name', 'code'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Khuvuc::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['child_id'], 'exist', 'skipOnError' => true, 'targetClass' => Khuvuc::className(), 'targetAttribute' => ['child_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Phường xã '),
            'code' => Yii::t('app', 'Code'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'child_id' => Yii::t('app', 'Child ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHocviens()
    {
        return $this->hasMany(Hocvien::className(), ['khuvuc_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHocviens0()
    {
        return $this->hasMany(Hocvien::className(), ['noicap' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHocviens1()
    {
        return $this->hasMany(Hocvien::className(), ['noihoctap' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHocviens2()
    {
        return $this->hasMany(Hocvien::className(), ['noisinh' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Khuvuc::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKhuvucs()
    {
        return $this->hasMany(Khuvuc::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild()
    {
        return $this->hasOne(Khuvuc::className(), ['id' => 'child_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKhuvucs0()
    {
        return $this->hasMany(Khuvuc::className(), ['child_id' => 'id']);
    }
}
