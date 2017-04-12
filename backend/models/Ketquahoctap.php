<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%ketquahoctap}}".
 *
 * @property integer $id
 * @property string $thoigian
 * @property integer $viet
 * @property integer $nghe
 * @property integer $hoithoai
 * @property integer $hocvien_id
 * @property string $ghichu
 *
 * @property Hocvien $hocvien
 */
class Ketquahoctap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ketquahoctap}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thoigian', 'hocvien_id'], 'required'],
            [['thoigian'], 'safe'],
            [['viet', 'nghe', 'hoithoai', 'hocvien_id'], 'integer'],
            [['ghichu'], 'string'],
            [['hocvien_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hocvien::className(), 'targetAttribute' => ['hocvien_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'thoigian' => Yii::t('app', 'Thời gian'),
            'viet' => Yii::t('app', 'Viết'),
            'nghe' => Yii::t('app', 'Nghe'),
            'hoithoai' => Yii::t('app', 'Hội thoại'),
            'hocvien_id' => Yii::t('app', 'Hocvien ID'),
            'ghichu' => Yii::t('app', 'Ghi chú'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHocvien()
    {
        return $this->hasOne(Hocvien::className(), ['id' => 'hocvien_id']);
    }
}
