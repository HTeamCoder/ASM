<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%cauhinh}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 */
class Cauhinh extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cauhinh}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['content'], 'string'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Tên cấu hình'),
            'content' => Yii::t('app', 'Nội dung'),
        ];
    }
}
