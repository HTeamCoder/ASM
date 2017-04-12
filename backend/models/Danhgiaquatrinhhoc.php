<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%danhgiaquatrinhhoc}}".
 *
 * @property integer $id
 * @property string $ketquahoctap
 * @property string $kyluattacphong
 * @property string $ghichu
 *
 * @property Chitietdanhgia[] $chitietdanhgias
 */
class Danhgiaquatrinhhoc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%danhgiaquatrinhhoc}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ketquahoctap', 'kyluattacphong', 'ghichu'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ketquahoctap' => Yii::t('app', 'Ketquahoctap'),
            'kyluattacphong' => Yii::t('app', 'Kyluattacphong'),
            'ghichu' => Yii::t('app', 'Ghi chú'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChitietdanhgias()
    {
        return $this->hasMany(Chitietdanhgia::className(), ['asv_danhgiaquatrinhhoc_id' => 'id']);
    }
}
